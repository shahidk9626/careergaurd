<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update Request Rejected</title>
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

        .rejection-box {
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            color: #9f1239;
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
            <p>Your profile update request was rejected by the administrator.</p>
            
            <div class="rejection-box">
                <strong>Reason for rejection:</strong><br>
                {{ $remark }}
            </div>

            <p>If you have any questions or need to make adjustments, you can submit a new request through your profile page or contact our support team.</p>
            <p>Regards,<br><strong>CAREER GUARD Support Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Career Guard. All rights reserved.</p>
            <p>Support: support@financewebsite.com</p>
        </div>
    </div>
</body>

</html>
