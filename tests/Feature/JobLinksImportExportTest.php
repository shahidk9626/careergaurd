<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JobLink;
use App\Models\ServiceCategory;
use App\Models\Module;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class JobLinksImportExportTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $staff;
    protected $exportPermission;
    protected $importPermission;
    protected $viewPermission;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['id' => 1, 'role_id' => 1]); // super admin
        $this->staff = User::factory()->create(['role_id' => 2]); // staff

        $module = Module::create([
            'name' => 'Services',
            'slug' => 'services',
            'status' => 'active'
        ]);

        $this->viewPermission = Permission::create([
            'name' => 'View Job Links',
            'slug' => 'job-links.view',
            'module_id' => $module->id
        ]);

        $this->exportPermission = Permission::create([
            'name' => 'Export Job Links',
            'slug' => 'job-links.export',
            'module_id' => $module->id
        ]);

        $this->importPermission = Permission::create([
            'name' => 'Import Job Links',
            'slug' => 'job-links.import',
            'module_id' => $module->id
        ]);
    }

    public function test_guest_cannot_access_import_export_routes()
    {
        $this->post(route('admin.services.job-links.export'))->assertRedirect('/login');
        $this->post(route('admin.services.job-links.import'))->assertRedirect('/login');
        $this->get(route('admin.services.job-links.download-template'))->assertRedirect('/login');
    }

    public function test_staff_without_permissions_cannot_access_routes()
    {
        $this->actingAs($this->staff);

        $this->post(route('admin.services.job-links.export'))->assertStatus(403);
        $this->post(route('admin.services.job-links.import'))->assertStatus(403);
        $this->get(route('admin.services.job-links.download-template'))->assertStatus(403);
    }

    public function test_super_admin_can_download_template_and_export()
    {
        $this->actingAs($this->admin);

        // Export all
        $response = $this->post(route('admin.services.job-links.export'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');

        // Download Template
        $responseTemplate = $this->get(route('admin.services.job-links.download-template'));
        $responseTemplate->assertStatus(200);
        $responseTemplate->assertHeader('Content-Disposition', 'attachment; filename=job_links_template.xlsx');
    }

    public function test_super_admin_can_export_filtered_records()
    {
        $job1 = JobLink::create(['title' => 'Software Engineer', 'company_name' => 'Google', 'status' => 'active']);
        $job2 = JobLink::create(['title' => 'React Dev', 'company_name' => 'Facebook', 'status' => 'active']);

        $this->actingAs($this->admin);

        $response = $this->post(route('admin.services.job-links.export'), [
            'ids' => json_encode([$job1->id])
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
    }

    public function test_super_admin_can_import_excel_sheet()
    {
        // 1. Create a dummy parent category
        $parentCategory = ServiceCategory::firstOrCreate([
            'slug' => 'job-link'
        ], [
            'name' => 'Job Link',
            'status' => 'active'
        ]);

        // 2. Create a temporary Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Title', 'Job Title', 'Company Name', 'Location', 'City', 'State', 
            'Salary', 'Experience', 'Vacancies', 'Job URL', 'Contact Person Name', 
            'Mobile Number', 'Apply WhatsApp or Email', 'Categories', 'Description'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row1 = [
            'Fullstack Developer', 'Senior Fullstack Dev', 'Test Company LLC', 'Pune', 'Pune', 'Maharashtra',
            '₹8,00,000 - ₹12,00,000 P.A.', '3-7 Years', '2', 'https://test.com/job', 'Jane Doe',
            '919876543211', 'apply@test.com', 'Engineering, IT', 'This is a test job description for import.'
        ];
        $sheet->fromArray($row1, null, 'A2');

        $tempFile = tempnam(sys_get_temp_dir(), 'test_import') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        $uploadedFile = new UploadedFile(
            $tempFile,
            'test_import.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->actingAs($this->admin);

        $response = $this->post(route('admin.services.job-links.import'), [
            'file' => $uploadedFile
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => '1 jobs imported successfully.']);

        $this->assertDatabaseHas('job_links', [
            'title' => 'Fullstack Developer',
            'company_name' => 'Test Company LLC',
            'city' => 'Pune',
            'state' => 'Maharashtra'
        ]);

        // Check if categories are created under the parent category
        $this->assertDatabaseHas('service_categories', [
            'name' => 'Engineering',
            'parent_id' => $parentCategory->id
        ]);
        $this->assertDatabaseHas('service_categories', [
            'name' => 'IT',
            'parent_id' => $parentCategory->id
        ]);

        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    }
}
