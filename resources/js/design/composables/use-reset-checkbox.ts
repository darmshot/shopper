import {useMagic} from "@/shared/composables/alpine/use-magic";


export default (alpine: object) => {

    const {$root, $dispatch} = useMagic(alpine)

    const reset = () => {
        $root.querySelectorAll<HTMLInputElement>('[data-checkbox]').forEach((el) => el.checked = false);
        $dispatch('filter-updated');
    }

    return {
        reset,
    }
}
