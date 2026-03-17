<div {{ $attributes->class('container-xl') }}
     class="container-xl">
    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top">
                <div class="space-y gap-1">
                   {{ $aside }}
                </div>
            </div>
        </div>
        <div class="col-md-9">
           {{ $body }}
        </div>
    </div>
</div>
