<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "DejaVu Sans", "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0 auto;
            padding: 5px;
            background-color: #fff;
        }

        h1.full-report-title {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        p.full-report-subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
            margin-bottom: 5px;
            font-style: italic;
        }

        .total-revenue-display h2 {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            border-left: 4px solid #27ae60;
            margin-bottom: 20px;
            text-align: right;
            border-radius: 4px;
        }
        table.full-report-table {
            width: auto;          /* Shrinks table to content width */
            max-width: 100%;      /* Avoid overflow */
            margin: 0 auto 20px;  /* Top/bottom 0, horizontal auto for centering */
            border-collapse: collapse;
            font-size: 11px;
            background-color: #fff;
            display: table;       /* Ensure table acts as block-level for margin auto */
        }


        table.full-report-table th {
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            border: 1px solid #2c3e50;
            background-color: #34495e;
            color: #fff;
        }

        table.full-report-table td {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            text-align: center;
            color: #444;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        td:first-child {
            text-align: center;
            width: 40px;
            color: #7f8c8d;
        }

        tr.section-header td {
            background-color: #e9ecef;
            color: #2c3e50;
            font-weight: bold;
            font-size: 11px;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #bdc3c7;
        }

        td.no-data {
            text-align: center;
            padding: 20px;
            color: #95a5a6;
            font-style: italic;
            background-color: #fff;
        }

        tr.summary-row td {
            background-color: #fff;
            font-weight: bold;
            color: #2c3e50;
            border-top: 2px solid #34495e;
        }

        tr.summary-row td:last-child {
            text-align: right;
            color: #27ae60;
        }

        .footer {
            width: 100%;
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #95a5a6;
            font-size: 10px;
        }

        @media print {
            body { margin: 0; padding: 0; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            thead tr, tr.section-header td, .total-revenue-display h2 {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <h1 class="full-report-title">Full Gym Report</h1>
    <p class="full-report-subtitle">Generated on: <?php echo e(now()->format('F d, Y h:i A')); ?></p>

    <div class="total-revenue-display">
        <h2>Total Revenue: ₱<?php echo e(number_format($revenue, 2)); ?></h2>
    </div>

    <table class="full-report-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Member Name</th>
                <th>Subscription Status</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Payment Status</th>
                <th>Amount</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $counter = 1;
                $users = $active_members->keyBy('id');
                $approvedPaymentsByUser = $payments->groupBy(fn($p) => $p->user_id);
            ?>

            
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $activeSub = $user->subscriptions->where('status', 'active')->first();
                    $userPayments = $approvedPaymentsByUser[$user->id] ?? collect();
                    $latestPayment = $userPayments->sortByDesc('created_at')->first();
                ?>
                <tr>
                    <td><?php echo e($counter++); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->name); ?></td>                 
                    <td><span class="badge bg-success"><?php echo e($activeSub->status ?? 'Active'); ?></span></td>
                    <td><?php echo e($activeSub->plan->name ?? 'N/A'); ?></td>
                    <td><?php echo e($activeSub && $activeSub->start_date ? \Carbon\Carbon::parse($activeSub->start_date)->format('M d, Y') : 'N/A'); ?></td>
                    <td><?php echo e($activeSub && $activeSub->end_date ? \Carbon\Carbon::parse($activeSub->end_date)->format('M d, Y') : 'N/A'); ?></td>

                    <?php if($latestPayment): ?>
                        <td><span class="badge bg-success">Approved</span></td>
                        <td>₱<?php echo e(number_format($latestPayment->amount ?? 0, 2)); ?></td>
                        <td><?php echo e($latestPayment->created_at ? \Carbon\Carbon::parse($latestPayment->created_at)->format('M d, Y') : 'N/A'); ?></td>
                    <?php else: ?>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!isset($users[$payment->user_id])): ?>
                    <tr>
                        <td><?php echo e($counter++); ?></td>
                        <td><?php echo e($payment->user->name ?? 'N/A'); ?></td>
                        <td><?php echo e($payment->user->email ?? 'N/A'); ?></td>
                        <td><span class="badge bg-warning"><?php echo e($payment->status ?? 'Pending'); ?></span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>₱<?php echo e(number_format($payment->amount ?? 0, 2)); ?></td>
                        <td><?php echo e($payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by Gym Management System</p>
        <p>Page 1 of 1</p>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/reports/full_report_pdf.blade.php ENDPATH**/ ?>