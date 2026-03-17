import {useMagic} from "@/shared/composables/alpine/use-magic";

Alpine.data('productToolbarForm', () => ({
    submitForm() {
        const {$el} = useMagic<{ $el: HTMLFormElement }>(this)

        $el.submit()
    }
}))

Alpine.data('productToolbar', () => ({
    isMobile: window.matchMedia('(max-width: 768px)').matches,

    get modal() {
        const {$refs} = useMagic(this)
        return $refs.modal as HTMLDialogElement
    },

    init() {
        const {$watch} = useMagic(this)

        const mq = window.matchMedia('(max-width: 768px)');
        mq.addEventListener('change', e => this.isMobile = e.matches);

        $watch('isMobile', () => this.teleport())

        this.teleport()
    },

    teleport() {
        const {$refs} = useMagic(this)

        const content = $refs.content;

        if (this.isMobile) {
            $refs.mobile.appendChild(content);
        } else {
            $refs.desktop.appendChild(content);
        }
    },

    openModal() {
        this.modal.showModal()
    },

    closeModal() {
        this.modal.close()
    }
}))



