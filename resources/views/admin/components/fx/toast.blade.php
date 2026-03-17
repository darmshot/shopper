<div x-data="toast"
     x-on:notify.window="add($event.detail)"
     class="position-fixed top-0 end-0 p-3"
     style="z-index: 9999;"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter-start="toast-enter-start"
            x-transition:enter-end="toast-enter-end"
            x-transition:leave-start="toast-leave-start"
            x-transition:leave-end="toast-leave-end"
            class="rounded-3 shadow-lg bg-white p-3 mb-2 d-flex align-items-center gap-2"
            style="width: 300px;"
        >
            <template x-if="toast.type === 'success'">
                <x-admin::ui.icon.status.success
                    class="text-success flex-shrink-0"
                />
            </template>
            <template x-if="toast.type === 'danger'">
                <x-admin::ui.icon.status.danger
                    class="text-danger flex-shrink-0"
                />
            </template>
            <template x-if="toast.type === 'warning'">
                <x-admin::ui.icon.status.warning
                    class="text-warning flex-shrink-0"
                />
            </template>
            <template x-if="toast.type === 'info'">
                <x-admin::ui.icon.status.info
                    class="text-info flex-shrink-0"
                />
            </template>
            <span class="flex-grow-1" x-text="toast.message"></span>
            <button
                type="button"
                class="btn-close"
                aria-label="Close"
                x-on:click="close(toast.id)"
            ></button>
        </div>
    </template>
</div>

@pushonce('scripts')
    @vite('resources/js/admin/components/fx/toast.ts')
@endpushonce
