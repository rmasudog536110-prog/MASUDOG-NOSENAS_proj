<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Active Members Report</title>
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

<h2>Active Members Report</h2>

<table class="table-container">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joined</th>
        </tr>
    </thead>

    <tbody>
        @php
            $totalRows = 8;
            $membersCount = count($members);
        @endphp
        {{-- REAL DATA ROWS --}}
        @foreach ($members as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone_number }}</td>
            <td>{{ $member->created_at->format('M d, Y') }}</td>
        </tr>
        @endforeach

        {{-- FILL EMPTY ROWS --}}
        @for ($i = $membersCount; $i < $totalRows; $i++)
        <tr class="empty-row">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>


</body>
</html>