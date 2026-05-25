<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Membership Purchase</title>
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
            background: linear-gradient(135deg, #7928ca 0%, #ff0080 100%);
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
        .details-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .details-row {
            margin-bottom: 10px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 8px;
        }
        .details-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .details-label {
            font-weight: 600;
            color: #64748b;
            display: inline-block;
            width: 150px;
        }
        .details-value {
            font-weight: 700;
            color: #0f172a;
            display: inline-block;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .button {
            background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(121, 40, 202, 0.2);
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: scale(1.02);
            opacity: 0.95;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CAREER GUARD</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $customer->name }},</h2>
            <p>A membership plan purchase has been initiated on your behalf by our staff member, <strong>{{ $staff->name }}</strong>.</p>
            <p>Please review the details below and click the button to complete your payment.</p>

            <div class="details-box">
                <div class="details-row">
                    <span class="details-label">Membership Name:</span>
                    <span class="details-value">{{ $plan->name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Tenure:</span>
                    <span class="details-value">{{ $plan->tenure_value }} {{ ucfirst($plan->tenure_type) }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Amount Due:</span>
                    <span class="details-value">₹{{ number_format($plan->premium_amount, 2) }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Staff Representative:</span>
                    <span class="details-value">{{ $staff->name }}</span>
                </div>
            </div>

            <div class="button-container">
                <a href="{{ $paymentLink }}" class="button">Complete Payment</a>
            </div>

            <p>If the button above does not work, copy and paste the following link into your browser:</p>
            <p style="word-break: break-all; font-size: 13px; color: #7928ca;">{{ $paymentLink }}</p>

            <p>Please note that this payment link is valid for 24 hours.</p>
            <p>Regards,<br><strong>CAREER GUARD Support Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Career Guard. All rights reserved.</p>
            <p>Support: support@financewebsite.com</p>
        </div>
    </div>
</body>
</html>
