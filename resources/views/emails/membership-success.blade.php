<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Success</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .content {
            padding: 40px 30px;
            color: #334155;
            line-height: 1.6;
        }

        .content h2 {
            font-size: 20px;
            color: #1e293b;
            margin-top: 0;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background-color: #f8fafc;
            border-radius: 8px;
            overflow: hidden;
        }

        .detail-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        .detail-table td.label {
            font-weight: bold;
            color: #475569;
            width: 40%;
        }

        .detail-table td.value {
            color: #1e293b;
        }

        .notice-box {
            background-color: #f0fdf4;
            border-left: 4px solid #16a34a;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .notice-title {
            font-weight: bold;
            color: #15803d;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .notice-text {
            color: #166534;
            font-size: 14px;
            margin: 0;
        }

        .benefits-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 30px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .benefit-icon {
            color: #16a34a;
            margin-right: 10px;
            font-weight: bold;
        }

        .cta-container {
            text-align: center;
            margin: 35px 0 15px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff !important;
            text-decoration: none;
            background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(219, 39, 119, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        .footer p {
            margin: 5px 0;
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin-top: 0;
                margin-bottom: 0;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>CAREER GUARD</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            
            @if($isProfileComplete)
                <p>Your membership has been activated successfully! You are now fully covered under your Career Guard protection plan.</p>
            @else
                <div class="notice-box">
                    <div class="notice-title">Action Required</div>
                    <p class="notice-text">
                        @if($isPendingApproval)
                            Your membership has been activated successfully. Your profile has been submitted successfully and is currently under review. Please wait for verification.
                        @else
                            Your membership has been activated successfully. Please complete your profile to ensure faster processing of future services and claims.
                        @endif
                    </p>
                </div>
            @endif

            <table class="detail-table">
                <tr>
                    <td class="label">Customer Name</td>
                    <td class="value">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Policy Number</td>
                    <td class="value">{{ $purchasedPlan->plan_unique_id }}</td>
                </tr>
                <tr>
                    <td class="label">Membership Name</td>
                    <td class="value">{{ $purchasedPlan->plan_name }}</td>
                </tr>
                <tr>
                    <td class="label">Purchase Date</td>
                    <td class="value">{{ $purchasedPlan->created_at->format('d M, Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Amount Paid</td>
                    <td class="value">₹{{ number_format($purchasedPlan->amount, 2) }}</td>
                </tr>
            </table>

            @if($isProfileComplete && $plan)
                <div class="benefits-title">Membership Benefits & Coverage</div>
                
                <div class="benefit-item">
                    <span class="benefit-icon">&#10004;</span>
                    <span>Support Coverage: Upto <strong>₹{{ number_format($plan->compensation_amount, 0) }}</strong> after {{ $plan->claim_duration_days }} days.</span>
                </div>
                
                <div class="benefit-item">
                    <span class="benefit-icon">&#10004;</span>
                    <span>Tenure: {{ $plan->tenure_value }} {{ ucfirst($plan->tenure_type) }} protection duration.</span>
                </div>

                @if($plan->prematurity_available)
                    <div class="benefit-item">
                        <span class="benefit-icon">&#10004;</span>
                        <span>Pre-maturity support is available.</span>
                    </div>
                @endif

                @php
                    $groupedServices = $plan->planServices->groupBy('service_type');
                    $serviceLabels = [
                        'resume' => 'Resume Templates Access',
                        'job-link' => 'Curated Job Links',
                        'question' => 'Interview Q&A Portal',
                    ];
                @endphp

                @foreach($groupedServices as $type => $services)
                    @php $label = $serviceLabels[$type] ?? ucfirst($type); @endphp
                    <div class="benefit-item">
                        <span class="benefit-icon">&#10004;</span>
                        <span>{{ $label }} (Mapped categories: 
                            {{ $services->map(fn($s) => $s->category->name ?? '')->filter()->join(', ') }}).
                        </span>
                    </div>
                @endforeach
            @endif

            <div class="cta-container">
                @if($isProfileComplete)
                    <a href="{{ route('customer.purchased-plans') }}" class="cta-button">View Membership</a>
                @elseif($isPendingApproval)
                    <a href="{{ route('customer.profile') }}" class="cta-button">View Profile</a>
                @else
                    <a href="{{ route('customer.registration') }}" class="cta-button">Complete Your Profile</a>
                @endif
            </div>

            <p>Regards,<br><strong>CAREER GUARD Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Career Guard. All rights reserved.</p>
            <p>Support: support@careerguard.in</p>
        </div>
    </div>
</body>

</html>
