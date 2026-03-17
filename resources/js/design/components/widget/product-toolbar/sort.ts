import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    sort: string | null

}
Alpine.data('productToolbarSort', (props: Props) => ({
    ...props,

    toggle(prefix:string) {
        const {$dispatch} = useMagic(this)
        this.sort = this.sort === `${prefix}_desc` ? `${prefix}_asc` : `${prefix}_desc`;

        $dispatch('sort-updated');
    }
}))
