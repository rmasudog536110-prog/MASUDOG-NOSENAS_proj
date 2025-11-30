<link rel="stylesheet" href="{{ asset('css/footer.css') }}">

<footer class="footer-reports">
<div class="report-footer">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
        <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
    </a>
    <a href="{{ route('reports.active_members.pdf') }}" class="btn btn-primary">
        <i class="fa-solid fa-download"></i> Export to PDF
    </a>
</div>

</footer>