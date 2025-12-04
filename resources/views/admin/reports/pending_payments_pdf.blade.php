<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pending Payments Report</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <h2>Pending Payment Verifications</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pending as $index => $subscription)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subscription->user->name ?? 'N/A' }}</td>
                    <td>{{ $subscription->user->email ?? 'N/A' }}</td>
                    <td>{{ $subscription->plan->name ?? 'N/A' }}</td>
                    <td>{{ optional($subscription->start_date)->format('M d, Y') ?? 'N/A' }}</td>
                    <td>{{ optional($subscription->end_date)->format('M d, Y') ?? 'N/A' }}</td>
                    <td>{{ $subscription->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No pending payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

