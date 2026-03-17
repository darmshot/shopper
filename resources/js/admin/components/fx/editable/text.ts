import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    form: object,
    entity: string,
}

Alpine.data('editableText',
    (props: Props) => ({
        ...props,

        responseStatus: null as 'success' | 'error' | null,
        async action() {
            const {$notify} = useMagic(this)
            try {
                const response = await fetch(this.route, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    method: 'PATCH',
                    body: JSON.stringify(this.form)
                });

                if (!response.ok) {
                    const error = await response.json();

                    $notify('danger', error.message)

                    return;
                }

                this.responseStatus = 'success';

                $notify('success', `${this.entity} updated`)

            } catch (e) {

                $notify('danger', `Unexpected error`)

                this.responseStatus = 'error';

            }
        }
    }))
