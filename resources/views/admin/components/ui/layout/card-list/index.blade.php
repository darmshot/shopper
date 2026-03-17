@props([
    'bulkActions',
    'headerRight',
    'body',
    'footer' => null,
    'title' => null,
])
<div {{ $attributes->class('card') }}>
    <div class="card-header">
        <div class="row flex-grow-1">
            <div class="col">
                <h3 class="card-title fw-bold mb-1">{{ $title }}</h3>

                <div class="btn-actions flex-wrap">
                  {{ $bulkActions }}
                </div>
            </div>
            <div class="col-md-auto col-sm-12">
                {{ $headerRight }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="divide-y">
            {{ $body }}
        </div>
    </div>

    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>


