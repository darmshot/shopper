import useResetCheckbox from "@/design/composables/use-reset-checkbox";


Alpine.data('brandFilter', () => ({
    reset() {
        useResetCheckbox(this).reset()
    },
}))
