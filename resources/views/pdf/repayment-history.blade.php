<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CareerGuard - Repayment Statement</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #252f40;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.5;
        }
        
        #watermark {
            position: fixed;
            top: 40%;
            left: 0;
            width: 100%;
            text-align: center;
            opacity: 0.06;
            font-size: 80px;
            font-weight: bold;
            color: #000000;
            transform: rotate(-35deg);
            transform-origin: 50% 50%;
            z-index: -1000;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: none;
        }
        .header-table td {
            padding: 0;
            border: none;
            vertical-align: middle;
        }
        .logo-container {
            width: 50%;
        }
        .logo-img {
            height: 35px;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 22px;
            font-weight: bold;
            color: #252f40;
            vertical-align: middle;
            margin-left: 8px;
        }
        .statement-title {
            text-align: right;
            width: 50%;
        }
        .statement-title h2 {
            margin: 0;
            font-size: 18px;
            color: #7928ca;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .statement-title p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #67748e;
        }

        .divider {
            height: 2px;
            background: #cb0c9f;
            margin-bottom: 25px;
        }

        .details-title {
            font-size: 13px;
            font-weight: bold;
            color: #7928ca;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #e8e8e8;
            padding-bottom: 5px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table td {
            padding: 8px 12px;
            border: 1px solid #f0f2f5;
        }
        .details-table td.label {
            font-weight: bold;
            color: #67748e;
            width: 25%;
            background-color: #f8f9fa;
        }
        .details-table td.value {
            color: #252f40;
            width: 25%;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
            border-radius: 4px;
        }
        .status-active {
            background-color: #82d616;
        }
        .status-pending {
            background-color: #17c1e8;
        }
        .status-inactive {
            background-color: #67748e;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .history-table th {
            background-color: #344767;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 10px 12px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .history-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e8e8e8;
            font-size: 11px;
        }
        .history-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-success-text {
            color: #2dce89;
            font-weight: bold;
        }
        .status-failed-text {
            color: #f5365c;
            font-weight: bold;
        }
        .status-other-text {
            color: #67748e;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #e8e8e8;
            padding-top: 8px;
        }
        .footer-table {
            width: 100%;
            border: none;
        }
        .footer-table td {
            font-size: 9px;
            color: #67748e;
            border: none;
            padding: 0;
        }
        .footer-table td.page-col {
            text-align: right;
        }
        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

    <div id="watermark">CareerGuard</div>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td class="logo-container">
                @if(file_exists(public_path('assets/img/careerguard-logo-black.webp')))
                    <img src="{{ public_path('assets/img/careerguard-logo-black.webp') }}" class="logo-img" alt="CareerGuard Logo">
                @else
                    <img src="https://test.careerguard.in/images/careerguard-logo-black.png" class="logo-img" alt="CareerGuard Logo">
                @endif
                <span class="brand-name">CareerGuard</span>
            </td>
            <td class="statement-title">
                <h2>Repayment Statement</h2>
                <p>Generated on {{ now()->format('d M, Y H:i') }}</p>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Membership Details -->
    <div class="details-title">Membership Details</div>
    <table class="details-table">
        <tr>
            <td class="label">Customer Name</td>
            <td class="value">{{ $purchasedPlan->user->name ?? 'N/A' }}</td>
            <td class="label">Membership Name</td>
            <td class="value">{{ $purchasedPlan->plan_name }}</td>
        </tr>
        <tr>
            <td class="label">Membership ID</td>
            <td class="value">{{ $purchasedPlan->plan_unique_id }}</td>
            <td class="label">Purchase Date</td>
            <td class="value">{{ $purchasedPlan->created_at->format('d M, Y') }}</td>
        </tr>
        <tr>
            <td class="label">Maturity Date</td>
            <td class="value">
                {{ $purchasedPlan->start_date ? $purchasedPlan->start_date->copy()->addDays($purchasedPlan->plan->claim_duration_days ?? 0)->format('d M, Y') : 'N/A' }}
            </td>
            <td class="label">Amount</td>
            <td class="value">₹{{ number_format($purchasedPlan->amount, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="value" colspan="3">
                <span class="status-badge {{ $purchasedPlan->status === 'active' ? 'status-active' : ($purchasedPlan->status === 'pending' ? 'status-pending' : 'status-inactive') }}">
                    {{ $purchasedPlan->status }}
                </span>
            </td>
        </tr>
    </table>

    <!-- Repayment History Section -->
    <div class="details-title">Repayment History</div>
    <table class="history-table">
        <thead>
            <tr>
                <th style="width: 8%;">Sr No</th>
                <th style="width: 20%;">Date</th>
                <th style="width: 15%;">Amount</th>
                <th style="width: 17%;">Payment Method</th>
                <th style="width: 25%;">Transaction ID</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $tx)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tx->created_at->format('d M, Y H:i') }}</td>
                    <td>₹{{ number_format($tx->amount, 2) }}</td>
                    <td>{{ strtoupper($tx->payment_method) }}</td>
                    <td>{{ $tx->transaction_reference }}</td>
                    <td>
                        @if($tx->payment_status === 'success')
                            <span class="status-success-text">Success</span>
                        @elseif($tx->payment_status === 'failed')
                            <span class="status-failed-text">Failed</span>
                        @else
                            <span class="status-other-text">{{ ucfirst($tx->payment_status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #67748e; padding: 20px;">
                        No repayment history available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Page Footer -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    Thank you for choosing CareerGuard. This is a computer-generated statement and does not require a physical signature.
                </td>
                <td class="page-col">
                    Page <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
