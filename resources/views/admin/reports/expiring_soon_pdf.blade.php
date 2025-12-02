<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Expiring Soon Report</title>

    <style>
            body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead tr {
            background: #555;
            color: white;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        tbody tr:nth-child(even) {
            background: #f4f4f4;
        }

        .empty-row td {
            height: 18px;
            background: #fff !important;
        }
    </style>
</head>

<body>
    <h2>Subscriptions Expiring Within 7 Days</h2>

<table>
    <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Email</th>
                <th>Plan</th>
                <th>End Date</th>
            </tr>
        </thead>

        <tbody> 
            
            @php
            $totalRows = 5;
            $membersCount = $subscriptions ? $subscriptions->count() : 0;
            @endphp
            
            @foreach ($subscriptions as $i => $sub)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sub->user->name }}</td>
                <td>{{ $sub->user->email }}</td>
                <td>{{ $sub->subscriptionPlan->name ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('F d, Y') }}</td>
            </tr>
            @endforeach
            {{-- FILL EMPTY ROWS --}}
            @for ($i = $membersCount; $i < $totalRows; $i++)
            <tr class="empty-row">
                <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                    No users Expiring Soon
                </td>
            </tr>
            @endfor
    </tbody>
</table>

<h2 class="mt-4">Active Subscriptions</h2>

    
<table class="reports-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Member</th>
            <th>Email</th>
            <th>Plan</th>
            <th>Ends At</th>
        </tr>
    </thead>

    <tbody>
        @php
            $activeRows = 5;
            $activeCount = $activeSubscriptions?->count() ?? 0;
        @endphp

        @forelse ($activeSubscriptions as $i => $active)
            <tr class="empty-row">
                <td>{{ $i + 1 }}</td>
                <td>{{ $active->user->name }}</td>
                <td>{{ $active->user->email }}</td>
                <td>{{ $active->plan->name ?? 'N/A' }}</td>
                <td>{{ $active->end_date->format('M d, Y') }}</td>
            </tr>
            
        @empty
        @endforelse 
            @for ($i = $activeCount; $i < $activeRows; $i++)
            <tr class="empty-row">
                <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                    No More Active Subscriptions
                </td>
            </tr>
            @endfor
        
    </tbody>
</table>


</body>
</html>
