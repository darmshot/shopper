@extends('design.index')

@section('body')
    <div class="container py-10">
        <div class="grid grid-cols-6 gap-5">
            <div class="col-span-6 md:col-span-5">
                <x-design::widget.new-arrivals-products
                    cols="5"
                />
            </div>

            <div class="col-span-1 hidden md:block">
                <x-design::widget.categories/>
            </div>
        </div>
    </div>
@endsection
