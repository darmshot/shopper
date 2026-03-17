import useUpdateFetch from "@/admin/composables/use-update-fetch";
import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

Alpine.data('actionActive', (props: Props) => ({
    ...props,

    get active(): boolean {
        return useMagic(this).$root.dataset.active === 'true'
    },

    async action() {
        const {update} = useUpdateFetch(this, props)

        await update({
            active: !this.active
        })
    }
}))
