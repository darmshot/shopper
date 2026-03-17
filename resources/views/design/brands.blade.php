@extends('design.index')

@section('title', 'Brands')

@section('header_bottom')
    <x-design::widget.breadcrumbs
        class="text-black">
        <x-design::widget.breadcrumbs.item.link
            label="Brands"
        />
    </x-design::widget.breadcrumbs>
@endsection

@section('body')
    <div class="container py-10">
        <x-design::widget.catalog-brands/>
    </div>
@endsection
