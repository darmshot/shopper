import {useMagic} from "@/shared/composables/alpine/use-magic";
import useBulkUpdateFetch from "@/admin/composables/use-bulk-update-fetch";

interface Props {
    route: string,
    entity: string,
}

interface Parent {
    checked: string[]
}


Alpine.data('bulkActionInFilter', (props: Props) => ({
    async activate() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            in_filter: true,
            checked,
        })
    },

    async deactivate() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            in_filter: false,
            checked,
        })
    },
}))
