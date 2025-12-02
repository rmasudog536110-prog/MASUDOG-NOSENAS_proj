<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pending Payments Report</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>

<body>

    <h2>Pending Payments Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>

            @php
            $totalRows = 5;
            $membersCount = count($pending);
            @endphp
            @forelse ($pending as $i => $sub)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sub->user->name }}</td>
                <td>{{ $sub->user->email }}</td>
                <td>{{ $sub->status }}</td>
                <td>{{ $sub->created_at->format('F d, Y') }}</td>
            </tr>
            @endforelse
            @for ($i = $membersCount; $i < $totalRows; $i++)
                <tr class="empty-row">
                    <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                        No users Expiring Soon
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

</body>
</html>
