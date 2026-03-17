import useResetCheckbox from "@/design/composables/use-reset-checkbox";

Alpine.data('featureFilter',  ()=> ({
    reset(){
        useResetCheckbox(this).reset()
    },
}))
