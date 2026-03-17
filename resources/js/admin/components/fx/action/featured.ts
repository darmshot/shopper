import useUpdateFetch from "@/admin/composables/use-update-fetch";
import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    route: string,
    entity: string,
}

Alpine.data('actionFeatured', (props: Props) => ({
    ...props,

    get featured(): boolean {
        return useMagic(this).$root.dataset.featured === 'true'
    },

    async action() {
        const {update} = useUpdateFetch(this, props)

        await update({
            featured: !this.featured
        })
    }
}))
