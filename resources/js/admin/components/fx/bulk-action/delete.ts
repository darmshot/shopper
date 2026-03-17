import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

interface Parent {
    checked: string[]
}

Alpine.data('bulkActionDelete',
    (props: Props) => ({
        ...props,

        confirmBulkDelete() {
            const {checked} = useMagic<Parent>(this)

            window.dispatchEvent(new CustomEvent('dialog', {
                detail: {
                    title: 'Are you sure?',
                    message: `Bulk Delete of ${checked.length} ${this.entity}? This cannot be undone.`,
                    type: 'danger',
                    confirmText: 'Delete',
                    cancelText: 'Cancel',
                    onConfirm: () => this.action()
                }
            }));
        },

        async action() {
            const {$dispatch, checked, $notify} = useMagic<Parent>(this)

            try {
                if (checked.length === 0) {
                    $notify('danger', 'No items selected')

                    return
                }

                const response = await fetch(this.route, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    method: 'POST',
                    body: JSON.stringify({
                        checked,
                    })
                });

                if (!response.ok) {
                    const error = await response.json();

                    $notify('danger', error.message)

                    return;
                }

                $dispatch('success')

                $notify('success', `${this.entity} updated`)
            } catch (e) {
                $notify('danger', 'Unexpected error')
            }
        }
    }))
