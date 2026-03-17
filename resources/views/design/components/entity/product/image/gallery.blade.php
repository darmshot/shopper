@props([
    'product'
])
@php
    $btnNavigation = 'btn text-white bg-black/40 border-none'
@endphp
<div {{ $attributes->class('carousel w-full') }}>
    @if(count($product->images) > 1)
        @foreach($product->images as $image)
            <div id="slide{{ $loop->iteration }}" class="carousel-item relative w-full">
                <img
                    src="{{ asset("storage/$image") }}"
                    class="w-full aspect-3/4 object-cover"
                    alt="{{ $product->name }} image {{ $loop->iteration }}"
                />
                <div class="absolute left-1 right-1 top-1/2 flex -translate-y-1/2 transform justify-between">
                    @if($loop->last)
                        <a href="#slide{{ $loop->iteration - 1 }}" @class($btnNavigation)>❮</a>
                        <a href="#slide1" @class($btnNavigation)>❯</a>
                    @elseif($loop->first)
                        <a href="#slide{{ $loop->count }}" @class($btnNavigation)>❮</a>
                        <a href="#slide{{ $loop->iteration + 1 }}" @class($btnNavigation)>❯</a>
                    @else
                        <a href="#slide{{ $loop->iteration - 1 }}" @class($btnNavigation)>❮</a>
                        <a href="#slide{{ $loop->iteration + 1 }}" @class($btnNavigation)>❯</a>
                    @endif
                </div>
            </div>
        @endforeach
    @elseif($product->image)
        <img
            src="{{ asset("storage/$product->image") }}"
            class="w-full aspect-3/4 object-cover"
            alt="{{ $product->name }}"
        />
    @else
        <x-design::fx.placeholder/>
    @endif
</div>
