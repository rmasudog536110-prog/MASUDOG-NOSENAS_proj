@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<div>
    <h2>Total Revenue Report</h2>

    <h3>₱{{ number_format($revenue, 2) }}</h3>
</div>

<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.expiring_soon_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>

@endsection
