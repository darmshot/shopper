import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

Alpine.data('actionDelete', (props: Props) => ({
    ...props,

    async action() {
        const {$dispatch, $notify} = useMagic(this)

        try {
            const response = await fetch(this.route, {
                headers: {
                    'Accept': 'application/json',
                },
                method: 'DELETE',
            });

            if (!response.ok) {
                const error = await response.json();

                $notify('danger', error.message)

                return;
            }

            $dispatch('success')

            $notify('success', `${this.entity} deleted`)

        } catch (e) {
            $notify('danger', 'Unexpected error')
        }
    },

    confirmDelete() {
        window.dispatchEvent(new CustomEvent('dialog', {
            detail: {
                title: 'Are you sure?',
                message: `Delete ${this.entity}? This cannot be undone.`,
                type: 'danger',
                confirmText: 'Delete',
                cancelText: 'Cancel',
                onConfirm: () => this.action()
            }
        }));
    }
}))
