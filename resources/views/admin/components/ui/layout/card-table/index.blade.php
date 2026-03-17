@props([
    'title' => null,
    'bulkActions',
    'headerRight',
    'thead',
    'tbody',
    'footer',
])
<div {{ $attributes->class('card') }}>
    <div class="card-table">
        <div class="card-header">
            <div class="row flex-grow-1">
                <div class="col">
                    <h3 class="card-title fw-bold mb-0">{{ $title }}</h3>
                    <div class="btn-actions flex-wrap">
                        {{ $bulkActions }}
                    </div>
                </div>
                <div class="col-md-auto col-sm-12">
                    {{ $headerRight }}
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter table-striped table-mobile-md card-table">
                <thead>
                {{$thead}}
                </thead>

                <tbody>
                {{ $tbody }}
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $footer }}
        </div>
    </div>
</div>

