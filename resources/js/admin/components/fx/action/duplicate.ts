import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

Alpine.data('actionDuplicate',
    (props: Props) => ({
        ...props,

        async action() {
            const {$dispatch, $notify} = useMagic(this)

            try {
                const response = await fetch(this.route, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: '{}',
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
