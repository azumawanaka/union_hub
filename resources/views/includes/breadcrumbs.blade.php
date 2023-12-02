<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

            @php
                $breadcrumbs = [];
                $segments = request()->segments();

                foreach ($segments as $segment) {
                    $url = implode('/', $breadcrumbs) . '/' . $segment;
                    $breadcrumbs[] = $segment;
                    $isActive = end($segments) === $segment;
                    $segmentName = str_replace('_', ' ', ucfirst($segment));
            @endphp

            <li class="breadcrumb-item {{ $isActive ? 'active' : '' }}">
                @if (!$isActive)
                    <a href="{{ url($url) }}">{{ $segmentName }}</a>
                @else
                    {{ $segmentName }}
                @endif
            </li>

            @php
                }
            @endphp

        </ol>
    </div>
</div>
