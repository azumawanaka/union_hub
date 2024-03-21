
<a href="{{ route('reports.index') }}">
    <i class="fa fa-warning"></i>
    <span class="badge badge-pill gradient-{{ $totalReports > 0 ? '1' : '2' }} badge-primary">{{ $totalReports }}</span>
</a>
