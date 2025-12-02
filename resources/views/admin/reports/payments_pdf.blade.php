<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments Report</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #f2f2f2; }
        .total { margin-top: 20px; font-size: 14px; font-weight: bold; }
    </style>
</head>

<body>

    <h2>Payments Report</h2>

    <p class="total">Total Revenue: ₱{{ number_format($revenue, 2) }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Status</th>
                <th>Updated At</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($payments as $i => $record)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $record->user->name }}</td>
                <td>{{ $record->user->email }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ $record->updated_at->format('F d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
