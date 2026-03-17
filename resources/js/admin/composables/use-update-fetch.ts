import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

export default (alpine: object, {route, entity}: Props) => {

    const update = async (body: object) => {
        const {$dispatch, $notify} = useMagic(alpine)

        try {
            const response = await fetch(route, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                method: 'PATCH',
                body: JSON.stringify(body)
            });

            if (!response.ok) {
                const error = await response.json();

                $notify('danger', error.message)

                return Promise.reject(error)
            }

            $dispatch('success')

            $notify('success', `${entity} updated`)

            return Promise.resolve(true)
        } catch (e) {
            $notify('danger', 'Unexpected error')

            return Promise.reject(e)
        }
    }

    return {
        update
    }
}
