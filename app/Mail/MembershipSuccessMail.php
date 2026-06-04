<?php

namespace App\Mail;

use App\Models\PurchasedPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchasedPlan;
    public $user;
    public $plan;
    public $isProfileComplete;
    public $isPendingApproval;

    /**
     * Create a new message instance.
     */
    public function __construct(PurchasedPlan $purchasedPlan)
    {
        $this->purchasedPlan = $purchasedPlan;
        
        // Ensure relationships are loaded
        $this->purchasedPlan->load(['user', 'plan.planServices.category']);
        
        $this->user = $purchasedPlan->user;
        $this->plan = $purchasedPlan->plan;

        // Resolve profile status
        // Profile Complete + Approved: profile_completed === 1 && verification_status === 'verified'
        $this->isProfileComplete = $this->user->profile_completed === 1 && $this->user->verification_status === 'verified';
        
        // Profile Completed but Pending Approval: profile_completed === 1 && verification_status !== 'verified'
        $this->isPendingApproval = $this->user->profile_completed === 1 && $this->user->verification_status !== 'verified';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Membership Activated Successfully - Career Guard',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.membership-success',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
