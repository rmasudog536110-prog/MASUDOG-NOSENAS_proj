@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h2>Total Revenue Report</h2>

<h3>₱{{ number_format($revenue, 2) }}</h3>
@endsection
