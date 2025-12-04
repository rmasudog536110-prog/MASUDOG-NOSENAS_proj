<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payments Report</title>
    <link rel="stylesheet" href="css/pdf.css">
</head>

<body>

    <h2>Payments Report</h2>

    <p class="total">Total Revenue: ₱{{ number_format($combined['total_revenue'], 2) }}</p>

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
            @foreach ($combined as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['email'] }}</td>
                <td>{{ ucfirst($row['status']) }}</td>
                <td>{{ \Carbon::parse($row['updated_at'])->format('F d, Y') }}</td>
                <td>₱{{ number_format($row['total_revenue'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
