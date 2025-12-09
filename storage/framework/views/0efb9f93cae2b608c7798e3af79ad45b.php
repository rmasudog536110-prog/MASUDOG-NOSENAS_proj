<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments Report</title>
    <link rel="stylesheet" href="css/pdf.css">
</head>

<body>

    <h2>Payments Report</h2>

    <p class="total">Total Revenue: ₱<?php echo e(number_format($combined['total_revenue'], 2)); ?></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Status</th>
                <th>Updated At</th>
                <th>Revenue Per User</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $combined; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($i + 1); ?></td>
                <td><?php echo e($row['name']); ?></td>
                <td><?php echo e($row['email']); ?></td>
                <td><?php echo e(ucfirst($row['status'])); ?></td>
                <td><?php echo e(\Carbon::parse($row['updated_at'])->format('F d, Y')); ?></td>
                <td>₱<?php echo e(number_format($row['total_revenue'], 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\reports\pending_payment_pdf.blade.php ENDPATH**/ ?>