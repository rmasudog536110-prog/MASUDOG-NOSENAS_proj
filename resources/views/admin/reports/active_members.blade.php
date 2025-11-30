@extends('skeleton.layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')

<h2>Active Members Report</h2>

<div class="table-container">
    <table>
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
                $totalRows = 20; // number of rows to always display
                $membersCount = count($members);
            @endphp

            @foreach ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone_number }}</td>
                <td>{{ $member->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach

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
</div>

@include('admin.reports.footer')

@endsection
