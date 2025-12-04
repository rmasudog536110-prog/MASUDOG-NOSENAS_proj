@extends('skeleton.layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<div class="report-page">
    <div class="report-header">
        <h1>Active Members</h1>
        <p class="report-meta">
            {{ $active }} active · {{ $cancelled }} cancelled
        </p>
    </div>

    <div class="report-card">
        <table class="reports-table">
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
            $totalRows = 5;
            $membersCount = count($members);
        @endphp

            @forelse($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone_number ?? 'N/A' }}</td>
                    <td>{{ $member->created_at->format('M d, Y') }}</td>
                </tr>
                  @empty
            @endforelse
            @for ($i = $membersCount; $i < $totalRows; $i++)
                    <tr class="empty-row">
                        <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                            No users yet
                        </td>
                    </tr>
            @endfor
            
        </tbody>
    </table>

<footer class="footer-reports">
<div class="report-footer">
    <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
        <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
    </a>
    <a href="{{ route('reports.active_members_pdf') }}" class="btn btn-primary">
        <i class="fa-solid fa-download"></i> Export to PDF
    </a>
</div>

</footer>

@endsection