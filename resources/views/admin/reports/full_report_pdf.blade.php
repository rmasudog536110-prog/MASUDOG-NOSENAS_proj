<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Full Gym Report</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-top: 30px; border-bottom: 1px solid #222; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #f2f2f2; }
    </style>
</head>

<body>

    <h1 style="text-align: center;">Full Gym Report</h1>

    <!-- SECTION 1 -->
    <h2>1. Active Members ({{ $active_count }})</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th></tr>
        </thead>
        <tbody>
            @foreach ($active_members as $i => $member)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- SECTION 2 -->
    <h2>2. Expiring Soon (Next 7 Days)</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Ends</th></tr>
        </thead>
        <tbody>
            @foreach ($expiring_soon as $i => $sub)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sub->user->name }}</td>
                <td>{{ $sub->user->email }}</td>
                <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('F d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- SECTION 3 -->
    <h2>3. Approved Payments</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach ($payments as $i => $sub)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sub->user->name }}</td>
                <td>{{ $sub->user->email }}</td>
                <td>{{ $sub->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- SECTION 4 -->
    <h2>4. Pending Payments</h2>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach ($pending as $i => $sub)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sub->user->name }}</td>
                <td>{{ $sub->user->email }}</td>
                <td>{{ $sub->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- SECTION 5 -->
    <h2>5. Revenue Summary</h2>
    
    <p><strong>Total Revenue:</strong> ₱{{ number_format($revenue, 2) }}</p>

</body>
</html>
