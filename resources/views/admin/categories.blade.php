@extends('admin.common.list', ['entity' => 'category'])

@section('body')
    @parent

    <div class="container-xl">
        <livewire:widget.categories/>
    </div>
@endsection


