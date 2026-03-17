<div  x-data="modalDialog"
      x-on:dialog.window="open($event.detail)">
    <!-- Backdrop -->
    <div
        x-show="visible"
        class="modal-backdrop fade show"
        style="display: none;"
    ></div>
    <!-- Modal -->
    <div
        class="modal"
        :class="{'show': visible}"
        :style="{display: visible ? 'block' : 'none'}"
        tabindex="-1"
        id="fx-dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button
                    type="button"
                    class="btn-close ms-auto mt-2 me-2"
                    x-on:click="close()"></button>

                <div class="modal-status"
                     :class="type === 'danger' ? 'bg-danger' :
                         type === 'warning' ? 'bg-warning' :
                         type === 'success' ? 'bg-success' : 'bg-info'">
                </div>

                <div class="modal-body text-center py-4">
                    <template x-if="type === 'danger'">
                        <x-admin::ui.icon.status.danger class="icon icon-lg text-danger mb-2"/>
                    </template>
                    <template x-if="type === 'warning'">
                        <x-admin::ui.icon.status.warning class="icon icon-lg text-warning mb-2"/>
                    </template>
                    <template x-if="type === 'success'">
                        <x-admin::ui.icon.status.success class="icon icon-lg text-success mb-2"/>
                    </template>
                    <template x-if="type === 'info'">
                        <x-admin::ui.icon.status.info class="icon icon-lg text-info mb-2"/>
                    </template>

                    <h3 x-text="title"></h3>
                    <div class="text-secondary" x-text="message"></div>
                </div>

                <div class="modal-footer">
                    <div class="w-100 row g-2">
                        <div class="col">
                            <button class="btn w-100" x-on:click="close()"
                                    x-text="cancelText"></button>
                        </div>
                        <div class="col">
                            <button class="btn w-100"
                                    :class="type === 'danger' ? 'btn-danger' : 'btn-primary'"
                                    x-on:click="confirm()"
                                    x-text="confirmText"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@pushonce('scripts')
    @vite('resources/js/admin/components/fx/modal-dialog.ts')
@endpushonce
