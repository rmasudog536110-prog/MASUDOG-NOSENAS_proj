@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')


<h2>Expiring Soon (Next 7 Days)</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Member</th><th>Plan</th><th>Expires At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscriptions as $sub)
        <tr>
            <td>{{ $sub->user->name }}</td>
            <td>{{ $sub->plan->name ?? 'N/A'}}</td>
            <td>{{ $sub->end_date->format('M d, Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection