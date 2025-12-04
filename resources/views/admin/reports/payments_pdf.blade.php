<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments Report</title>
    <style>
        /* =========================================
   1. Base & Reset
   ========================================= */
body {
    font-family: "DejaVu Sans", "Segoe UI", Arial, sans-serif;
    font-size: 12px;
    line-height: 1.4;
    color: #333;
    margin: 0 auto; /* Centered for preview, PDF engine usually handles page margins */
    padding: 20px;
    background-color: #fff;
}

/* =========================================
   2. Typography & Headers
   ========================================= */
/* Main Report Title (used in h1 tags) */
h1 {
    text-align: center;
    color: #2c3e50;
    font-size: 24px;
    font-weight: bold;
    margin: 0 0 10px 0;
    text-transform: uppercase;
}

/* Section Headings (used in h2 tags) */
h2 {
    color: #2c3e50;
    font-size: 16px;
    font-weight: 600;
    margin: 25px 0 15px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #3498db;
    page-break-after: avoid;
}

/* Subtitles & Meta Data */
p.subtitle, 
p[style*="text-align: center"] { /* Catches inline styles from Blade 1 */
    text-align: center;
    color: #7f8c8d;
    font-size: 12px;
    margin-bottom: 30px;
    font-style: italic;
}

/* Highlighted Total (used in Payments Report) */
.total {
    font-size: 14px;
    font-weight: bold;
    color: #2c3e50;
    background-color: #f8f9fa;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-left: 4px solid #27ae60; /* Green accent */
    margin-bottom: 20px;
    text-align: right;
    border-radius: 4px;
}

/* =========================================
   3. Tables (Unified Design)
   ========================================= */
/* Applies to generic tables and .table-container */
table, 
.table-container {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 11px;
    background-color: #fff;
}

/* Table Headers */
thead tr {
    background-color: #34495e; /* Dark Blue/Grey */
    color: white;
}

th {
    padding: 10px 8px;
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 10px;
    border: 1px solid #2c3e50;
    vertical-align: middle;
}

/* Table Body Cells */
td {
    padding: 8px;
    border: 1px solid #dee2e6;
    vertical-align: middle;
    color: #444;
}

/* Striping for readability */
tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* Specific Column Formatting (Optional Tweaks) */
td:first-child { /* ID/Index columns usually */
    text-align: center;
    width: 40px;
    color: #7f8c8d;
}

/* =========================================
   4. Special Row Types (From Blade Logic)
   ========================================= */

/* Section Headers inside tables (e.g., "ACTIVE MEMBERS") */
tr.section-header td {
    background-color: #e9ecef;
    color: #2c3e50;
    font-weight: bold;
    font-size: 11px;
    padding: 10px;
    text-align: left;
    border-bottom: 2px solid #bdc3c7;
}

/* Empty Rows (Padding for visual length) */
tr.empty-row td {
    height: 35px; /* Fixed height for empty fillers */
    background-color: #fff !important; /* Force white, override striping */
    color: #999;
    font-style: italic;
    text-align: center;
    border: 1px solid #f1f1f1;
}

/* No Data State (Specific message row) */
td.no-data {
    text-align: center;
    padding: 20px;
    color: #95a5a6;
    font-style: italic;
    background-color: #fff;
}

/* Summary Rows (Totals at bottom of table) */
tr.summary-row td {
    background-color: #fff;
    font-weight: bold;
    color: #2c3e50;
    border-top: 2px solid #34495e; /* Distinct separator */
}

/* Right align values in summary */
tr.summary-row td:last-child {
    text-align: right;
    color: #27ae60; /* Green for money/counts */
}

/* =========================================
   5. Footer
   ========================================= */
.footer {
    width: 100%;
    margin-top: 40px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    text-align: center;
    color: #95a5a6;
    font-size: 10px;
}

.footer p {
    margin: 2px 0;
}

/* =========================================
   6. Print Optimization (PDF Generation)
   ========================================= */
@media print {
    body {
        margin: 0;
        padding: 0;
    }

    /* Prevent tables from breaking awkwardly across pages */
    table { page-break-inside: auto; }
    tr { page-break-inside: avoid; page-break-after: auto; }
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    /* Ensure backgrounds print */
    thead tr, 
    tr.section-header td, 
    .total {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Clean up headers for print */
    h2 {
        page-break-after: avoid;
    }
}
    </style>
</head>

<body>

    <h1>Payments Report</h1>
    <h2>Generated on: {{ now()->format('F d, Y h:i A') }}</h2>

    <div class="total">Total Revenue: ₱{{ number_format($revenue, 2) }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Latest Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @php
                $totalRows = 5;
                $combined = $combined ?? collect();
                $membersCount = count($combined);
            @endphp

            @if($membersCount > 0)
                @foreach ($combined as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['user']->name ?? 'N/A' }}</td>
                    <td>{{ $row['user']->email ?? 'N/A' }}</td>
                    <td>₱{{ number_format($row['latest_amount'] ?? 0, 2) }}</td>
                    <td>{{ ucfirst($row['payment_method'] ?? 'N/A') }}</td>
                    <td>{{ ucfirst($row['status'] ?? 'N/A') }}</td>
                    <td>{{ isset($row['date']) ? $row['date']->format('M d, Y') : 'N/A' }}</td>
                </tr>
                @endforeach
            @endif

            @for ($i = $membersCount; $i < $totalRows; $i++)
                <tr class="empty-row">
                    <td colspan="7" style="text-align: center; color: #888;">
                        No payment records found
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by Gym Management System</p>
        <p>Page 1 of 1</p>
    </div>

</body>
</html>