@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')


<h2>Expiring Soon (Next 7 Days)</h2>

<table class="reports-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Member</th>
            <th>Plan</th>
            <th>Expires At</th>
        </tr>
    </thead>
    <tbody>

        @php
        $totalRows = 5;
        $membersCount = count($subscriptions);
        @endphp

        @forelse ($subscriptions as $i => $sub)
        <tr class="empty-row">
            <td>{{ $i + 1 }}</td>
            <td>{{ $sub->user->name }}</td>
            <td>{{ $sub->plan->name ?? 'N/A'}}</td>
            <td>{{ $sub->end_date->format('M d, Y') }}</td>
        </tr>
         @empty
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
            $activeCount = count($activeSubscriptions);
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
                    <td colspan="5" class="text-center" style="color: var(--muted-foreground);">
                        No Active Subscriptions
                    </td>
                </tr>
            @endfor
      
    </tbody>
</table>


<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.expiring_soon_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>

@endsection
