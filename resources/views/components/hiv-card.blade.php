@props(['icon', 'title', 'color' => 'bg-light'])

<div class="col-md-6">
    <div class="card shadow-sm h-100 border-0 {{ $color }}">
        <div class="card-body">
            <h5 class="card-title text-danger">
                <i class="bi {{ $icon }} me-2"></i>{{ $title }}
            </h5>
            <div class="card-text">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
