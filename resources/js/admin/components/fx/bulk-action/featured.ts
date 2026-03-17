import {useMagic} from "@/shared/composables/alpine/use-magic";
import useBulkUpdateFetch from "@/admin/composables/use-bulk-update-fetch";

interface Props {
    route: string,
    entity: string,
}

interface Parent {
    checked: string[]
}

Alpine.data('bulkActionFeatured',  (props: Props)=> ({
    async featured() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            featured: true,
            checked,
        })
    },

    async unfeature() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            featured: false,
            checked,
        })
    },
}))
