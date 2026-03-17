@extends('admin.common.list', ['entity' => 'feature'])

@section('body')
    @parent
    <div x-data="{
        features: document.getElementById('features').$wire,
        apply(payload) {
            if (typeof payload.category_id != 'undefined') {
                this.features.$set('categoryId', payload.category_id)
            }
        }
    }"
         x-on:apply="apply($event.detail)">
        <x-admin::ui.layout.page.aside>
            <x-slot:aside>
                <livewire:widget.filter-category/>
            </x-slot:aside>

            <x-slot:body>
                <livewire:widget.features
                    id="features"
                />
            </x-slot:body>
        </x-admin::ui.layout.page.aside>
    </div>
@endsection
