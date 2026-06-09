<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use App\Models\ServiceCategory;
use App\Models\PlanService;
use App\Models\PurchasedPlan;
use App\Models\ResumeTemplate;
use App\Models\JobLink;
use App\Models\InterviewQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerBenefitsPortalTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $plan;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard verified customer (role_id = 0, status = active, verification_status = verified)
        $this->customer = User::factory()->create([
            'role_id' => 0,
            'profile_completed' => 1,
            'verification_status' => 'verified',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create a service category
        $this->category = ServiceCategory::create([
            'name' => 'Software Engineering',
            'slug' => 'software-engineering',
            'status' => 'active',
        ]);

        // Create a plan
        $this->plan = Plan::create([
            'name' => 'Premium Career Pack',
            'slug' => 'premium-career-pack',
            'premium_amount' => 999.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'status' => 'active',
        ]);
    }

    /**
     * Test guest cannot access portals.
     */
    public function test_guest_is_redirected_from_benefit_portals()
    {
        $this->get(route('customer.job-links'))->assertRedirect(route('login'));
        $this->get(route('customer.resume-templates'))->assertRedirect(route('login'));
        $this->get(route('customer.interview-questions'))->assertRedirect(route('login'));
    }

    /**
     * Test active membership benefit access.
     */
    public function test_customer_with_active_membership_can_access_mapped_benefits()
    {
        // Map 'resume' and 'job-link' services to plan, but NOT 'question'
        PlanService::create([
            'plan_id' => $this->plan->id,
            'service_type' => 'resume',
            'service_category_id' => $this->category->id,
        ]);
        PlanService::create([
            'plan_id' => $this->plan->id,
            'service_type' => 'job-link',
            'service_category_id' => $this->category->id,
        ]);

        // Purchase plan
        PurchasedPlan::create([
            'user_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'plan_unique_id' => 'SUB-12345',
            'plan_name' => $this->plan->name,
            'amount' => 999.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        $this->actingAs($this->customer);

        // Resume & Job Link should be accessible
        $this->get(route('customer.resume-templates'))->assertStatus(200);
        $this->get(route('customer.job-links'))->assertStatus(200);

        // Interview Question should redirect to dashboard with error
        $this->get(route('customer.interview-questions'))->assertRedirect(route('dashboard'));
    }

    /**
     * Test expired membership removes access.
     */
    public function test_expired_membership_removes_benefit_access()
    {
        PlanService::create([
            'plan_id' => $this->plan->id,
            'service_type' => 'resume',
            'service_category_id' => $this->category->id,
        ]);

        // Purchase plan but set end_date in the past
        PurchasedPlan::create([
            'user_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'plan_unique_id' => 'SUB-12345',
            'plan_name' => $this->plan->name,
            'amount' => 999.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'start_date' => now()->subMonths(7),
            'end_date' => now()->subMonth(),
            'status' => 'active',
        ]);

        $this->actingAs($this->customer);

        $this->get(route('customer.resume-templates'))->assertRedirect(route('dashboard'));
    }

    /**
     * Test resume template download security.
     */
    public function test_resume_download_security()
    {
        // 1. Setup template in category
        $template = ResumeTemplate::create([
            'title' => 'Standard Tech Resume',
            'slug' => 'standard-tech-resume',
            'status' => 'active',
        ]);
        $template->categories()->sync([$this->category->id]);

        // 2. Setup another category the user DOES NOT have access to
        $restrictedCategory = ServiceCategory::create([
            'name' => 'Design & Creative',
            'slug' => 'design-creative',
            'status' => 'active',
        ]);
        $restrictedTemplate = ResumeTemplate::create([
            'title' => 'Creative Designer Resume',
            'slug' => 'creative-designer-resume',
            'status' => 'active',
        ]);
        $restrictedTemplate->categories()->sync([$restrictedCategory->id]);

        // 3. Set active purchase for 'resume' mapped ONLY to $this->category
        PlanService::create([
            'plan_id' => $this->plan->id,
            'service_type' => 'resume',
            'service_category_id' => $this->category->id,
        ]);

        PurchasedPlan::create([
            'user_id' => $this->customer->id,
            'plan_id' => $this->plan->id,
            'plan_unique_id' => 'SUB-12345',
            'plan_name' => $this->plan->name,
            'amount' => 999.00,
            'tenure_type' => 'months',
            'tenure_value' => 6,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        $this->actingAs($this->customer);

        // Can download template in their category
        $response = $this->get(route('customer.resume-templates.download', $template->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        // Cannot download template in the restricted category
        $this->get(route('customer.resume-templates.download', $restrictedTemplate->id))->assertStatus(403);
    }

    /**
     * Test JobLink model and validation with new fields and optional URL.
     */
    public function test_job_link_optional_url_and_new_fields()
    {
        $job = JobLink::create([
            'title' => 'Backend Developer',
            'job_title' => 'Senior Laravel Developer',
            'company_name' => 'Acme Corp',
            'contact_person_name' => 'Jane Smith',
            'mobile_number' => '919999999999',
            'vacancies' => '5',
            'location' => 'Remote',
            'salary' => '₹12,00,000 P.A.',
            'experience' => '3-5 Years',
            'apply_whatsapp_or_email' => '919999999999',
            'description' => 'Test Job Description',
        ]);

        $this->assertDatabaseHas('job_links', [
            'id' => $job->id,
            'title' => 'Backend Developer',
            'job_title' => 'Senior Laravel Developer',
            'job_url' => null,
            'contact_person_name' => 'Jane Smith',
            'mobile_number' => '919999999999',
        ]);

        // Accessors fallback test
        $this->assertEquals('Remote', $job->location);
        $this->assertEquals('3-5 Years', $job->experience);
        $this->assertEquals('₹12,00,000 P.A.', $job->salary);
    }
}
