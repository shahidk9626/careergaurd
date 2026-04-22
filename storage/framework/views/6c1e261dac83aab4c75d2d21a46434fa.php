<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Registration</title>
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

        .button-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .button {
            background-color: #3b82f6;
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2563eb;
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

        .social-links {
            margin-top: 15px;
        }

        .social-links a {
            margin: 0 10px;
            color: #64748b;
            text-decoration: none;
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
            <h1>CAREER GUARDPORTAL</h1>
        </div>
        <div class="content">
            <h2>Hello <?php echo e($user->name); ?>,</h2>
            <p>Thank you for registering with us. We are excited to have you on board!</p>
            <p>Please verify your email and complete your registration by clicking the button below. This link will
                expire in 24 hours.</p>

            <div class="button-container">
                <a href="<?php echo e($verificationUrl); ?>" class="button">Complete Registration</a>
            </div>

            <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
            <p style="word-break: break-all; font-size: 13px; color: #3b82f6;"><?php echo e($verificationUrl); ?></p>

            <p>If you did not create an account, no further action is required.</p>
            <p>Regards,<br><strong>CAREER GUARDTeam</strong></p>
        </div>
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> Career Guard. All rights reserved.</p>
            <p>Support: support@financewebsite.com</p>
            <div class="social-links">
                <a href="#">Twitter</a>
                <a href="#">LinkedIn</a>
                <a href="#">Facebook</a>
            </div>
        </div>
    </div>
</body>

</html>
<?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/emails/customer-verification.blade.php ENDPATH**/ ?>