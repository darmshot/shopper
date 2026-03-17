@extends('admin.common.list', ['entity' => 'brand'])

@section('body')
    @parent

    <div class="container-xl">
        <livewire:widget.brands/>
    </div>
@endsection
