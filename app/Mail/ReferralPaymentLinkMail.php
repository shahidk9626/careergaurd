<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Plan;
use App\Models\StaffMembershipReferral;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralPaymentLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $plan;
    public $referral;
    public $paymentLink;
    public $staff;

    /**
     * Create a new message instance.
     */
    public function __construct(User $customer, Plan $plan, StaffMembershipReferral $referral, $paymentLink, User $staff)
    {
        $this->customer = $customer;
        $this->plan = $plan;
        $this->referral = $referral;
        $this->paymentLink = $paymentLink;
        $this->staff = $staff;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your Membership Purchase - ' . $this->plan->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-link',
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
