<div {{ $attributes->class('card') }}>
    <div class="card-header">Product Properties</div>
    <div class="card-body">
        @foreach($this->features as $feature)
            <div wire:key="{{ $feature->id }}" class="row">
                <label class="col-sm-4 col-form-label">
                    {{ $feature->name }}
                    <x-admin::fx.field.hidden
                        name="options[{{ $loop->index }}][feature_id]"
                        value="{{ $feature->id }}"
                    />
                </label>

                <div class="col-sm-8">
                    <x-admin::fx.field.text
                        name="options[{{ $loop->index }}][value]"
                        wire:model="options.{{ $loop->index }}.value"
                        placeholder="Value"
                    />
                </div>
            </div>
        @endforeach

        @foreach($newFeatures as $newFeature)
            <div class="row mb-3">
                <div class="col-sm-4">
                    <x-admin::fx.field.text
                        name="new_features[{{ $loop->index }}][name]"
                        wire:model="new_features.{{ $loop->index }}.name"
                        placeholder="Feature"
                    />
                </div>

                <div class="col-sm-8">
                    <div class="row g-1">
                        <div class="col">
                            <x-admin::fx.field.text
                                name="new_features[{{ $loop->index }}][value]"
                                wire:model="new_features.{{ $loop->index }}.value"
                                placeholder="Value"
                            />
                        </div>

                        <div class="col-auto">
                            <button
                                type="button"
                                wire:click="removeNewFeature({{ $loop->index }})"
                                class="btn btn-icon btn-ghost-danger">
                                <x-admin::ui.icon.x/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <button
            wire:click="addNewFeature"
            type="button"
            class="btn btn-ghost-success">
            <x-admin::ui.icon.plus/>
            Add new feature
        </button>
    </div>
</div>
