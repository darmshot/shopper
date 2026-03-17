import {useMagic} from "@/shared/composables/alpine/use-magic";
import useBulkUpdateFetch from "@/admin/composables/use-bulk-update-fetch";

type Parent = {
    checked: Array<string>
}

interface Props {
    route: string
    entity: string,
}

Alpine.data('bulkActionActive', (props: Props) => ({
    async activate() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            active: true,
            checked,
        })
    },

    async deactivate() {
        const {checked} = useMagic<Parent>(this)
        const {update} = useBulkUpdateFetch(this, props)

        await update({
            active: false,
            checked,
        })
    },
}))
