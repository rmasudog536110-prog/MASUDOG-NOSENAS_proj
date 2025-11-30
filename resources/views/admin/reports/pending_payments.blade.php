@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h1>Pending Payment Verifications</h1>

@if($pending->isEmpty())
    <p>No pending payments found.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pending as $pendings)
                <tr>
                    <td>{{ $pendings->user->name }}</td>
                    <td>{{ $pendings->subscriptionPlan->name ?? 'N/A' }}</td>
                    <td>{{ $pendings->start_date->format('M d, Y') }}</td>
                    <td>{{ $pendings->end_date->format('M d, Y') }}</td>
                    <td>{{ $pendings->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
