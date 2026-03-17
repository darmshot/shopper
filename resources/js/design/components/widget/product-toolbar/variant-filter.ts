import {useMagic} from "@/shared/composables/alpine/use-magic";

interface Props {
    variant: string|null,
}
Alpine.data('variantFilter', (props: Props) => ({
    ...props,
    handle(e: Event) {
        const {$dispatch} = useMagic(this)
        const el = e.target as HTMLInputElement | null

        if (!el) return;

        this.variant === el.value
            ? this.variant = null
            : this.variant = el.value;
        $dispatch('filter-updated')
    }
}))
