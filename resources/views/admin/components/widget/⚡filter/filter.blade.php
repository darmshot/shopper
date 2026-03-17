<div {{ $attributes->class('card') }}>
    <div class="card-body">
        <div class="btn-list">
            @foreach($this->filters as $key => $name)
                <button
                    type="button"
                    class="btn btn-sm btn-link {{ $filter === $key ? 'active' : null }}"
                    wire:click="$set('filter','{{ $key }}')">{{ $name }}</button>
            @endforeach
        </div>
    </div>
</div>
