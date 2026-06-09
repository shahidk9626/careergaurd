<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commission Invoice - {{ $staff['code'] }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        /* Watermark styling for DomPDF (repeats on every page) */
        .watermark {
            position: fixed;
            top: 40%;
            left: 5%;
            width: 90%;
            text-align: center;
            opacity: 0.03;
            z-index: -1000;
            font-size: 76px;
            font-weight: 800;
            color: #0f172a;
            transform: rotate(-35deg);
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #7e22ce;
            margin: 0;
        }

        .logo-subtext {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        .statement-title {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .statement-subtitle {
            text-align: right;
            font-size: 11px;
            color: #64748b;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #7e22ce;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 6px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            color: #475569;
            width: 130px;
        }

        .info-value {
            color: #334155;
        }

        .summary-box-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .summary-num {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .summary-lbl {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .data-table th {
            background-color: #7e22ce;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 10px 12px;
            font-size: 11px;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }

        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .badge-active {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-expired {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .footer {
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            font-size: 11px;
            color: #64748b;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-right {
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- Watermark Background -->
    <div class="watermark">CareerGuard</div>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td>
                <div class="logo-text">CareerGuard</div>
                <div class="logo-subtext">Premium Career Protection & Referral Program</div>
            </td>
            <td>
                <div class="statement-title">Commission Statement</div>
                <div class="statement-subtitle">Statement Period: {{ $dateRangeLabel }}</div>
            </td>
        </tr>
    </table>

    <!-- Staff Info Section -->
    <div class="section-title">Staff Information</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Staff Name:</td>
            <td class="info-value">{{ $staff['name'] }}</td>
            <td class="info-label">Role:</td>
            <td class="info-value">{{ $staff['role'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Staff Code:</td>
            <td class="info-value">{{ $staff['code'] }}</td>
            <td class="info-label">Department:</td>
            <td class="info-value">{{ $staff['department'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Email Address:</td>
            <td class="info-value">{{ $staff['email'] }}</td>
            <td class="info-label">Joining Date:</td>
            <td class="info-value">{{ $staff['joining_date'] }}</td>
        </tr>
        <tr>
            <td class="info-label">Contact Number:</td>
            <td class="info-value">{{ $staff['phone'] }}</td>
            <td class="info-label">Account Status:</td>
            <td class="info-value">{{ $staff['status'] }}</td>
        </tr>
    </table>

    <!-- Period Summary Section -->
    <div class="section-title">Performance Summary (Selected Period)</div>
    <table class="summary-box-table">
        <tr>
            <td style="width: 32%; padding-right: 1.5%;">
                <div class="summary-box">
                    <div class="summary-num">{{ $periodStats['total_policies'] }}</div>
                    <div class="summary-lbl">Policies Converted</div>
                </div>
            </td>
            <td style="width: 32%; padding-right: 1.5%; padding-left: 1.5%;">
                <div class="summary-box">
                    <div class="summary-num">Rs. {{ number_format($periodStats['total_premium'], 2) }}</div>
                    <div class="summary-lbl">Premium Generated</div>
                </div>
            </td>
            <td style="width: 32%; padding-left: 1.5%;">
                <div class="summary-box" style="border-left: 3px solid #7e22ce;">
                    <div class="summary-num" style="color: #7e22ce;">Rs. {{ number_format($periodStats['total_commission'], 2) }}</div>
                    <div class="summary-lbl">Commission Earned</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Commission Details Table -->
    <div class="section-title">Commission Details</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 20%;">Policy Number</th>
                <th style="width: 20%;">Customer Name</th>
                <th style="width: 20%;">Membership</th>
                <th style="width: 13%;">Purchase Date</th>
                <th style="width: 12%; text-align: right;">Premium</th>
                <th style="width: 7%; text-align: center;">Comm %</th>
                <th style="width: 12%; text-align: right;">Commission</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($referrals as $ref)
                <tr>
                    <td style="font-family: monospace; font-size: 10px;">{{ $ref['policy_number'] }}</td>
                    <td>{{ $ref['customer_name'] }}</td>
                    <td>{{ $ref['membership_name'] }}</td>
                    <td>{{ $ref['purchase_date'] }}</td>
                    <td class="text-right">Rs. {{ number_format($ref['premium_amount'], 2) }}</td>
                    <td class="text-center">{{ $ref['commission_percent'] }}%</td>
                    <td class="text-right" style="font-weight: bold; color: #7e22ce;">Rs. {{ number_format($ref['commission_amount'], 2) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $ref['status'] === 'active' ? 'badge-active' : 'badge-expired' }}">
                            {{ $ref['status'] }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="color: #64748b; font-style: italic; padding: 20px;">
                        No commission records found for the selected period.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer Section -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <div><strong>CareerGuard</strong> &copy; {{ date('Y') }}</div>
                    <div style="margin-top: 3px; font-size: 10px; color: #94a3b8;">This is a system generated statement and does not require a physical signature.</div>
                </td>
                <td class="footer-right">
                    <div><strong>Generated By:</strong> {{ $generated_by }}</div>
                    <div style="margin-top: 3px;"><strong>Generated Date:</strong> {{ $generated_at }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
