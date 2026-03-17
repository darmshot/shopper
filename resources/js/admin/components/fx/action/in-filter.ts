import useUpdateFetch from "@/admin/composables/use-update-fetch";
import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}
Alpine.data('actionInFilter', ( props: Props) => ({
    ...props,

    get inFilter(): boolean {
        return useMagic(this).$root.dataset.inFilter === 'true'
    },

    async action() {
        const {update} = useUpdateFetch(this, props)

        await update({
            in_filter: !this.inFilter
        })
    }
}))
