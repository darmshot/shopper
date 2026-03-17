import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string
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
                method: 'POST',
                body: JSON.stringify(body)
            })

            if (!response.ok) {
                const error = await response.json()

                $notify('danger', error.message)

                return
            }

            $dispatch('success')

            $notify('success', `${entity} updated`)
        } catch (e) {
            $notify('danger', 'Unexpected error')
        }
    }

    return {update}
}
