import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Parent {
    checked: string[]
}

interface Props {
    route: string,
    entity: string,
}

Alpine.data('bulkActionDuplicate',
    (props: Props) => ({
        ...props,

        async action() {
            const {$dispatch, checked, $notify} = useMagic<Parent>(this)

            try {
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

                $notify('success', `${this.entity} duplicated`)
            } catch (e) {
                $notify('danger', 'Unexpected error')
            }
        }
    }))
