type ModalType = 'info' | 'success' | 'warning' | 'danger';

interface ModalPayload {
    title: string;
    message: string;
    type?: ModalType;
    confirmText?: string;
    cancelText?: string;
    onConfirm?: (() => void) | null;
}

Alpine.data('modalDialog', () => ({
    title: '',
    message: '',
    type: 'info' as ModalType,
    confirmText: 'OK',
    cancelText: 'Cancel',
    visible: false,
    onConfirm: null as null | (() => void),

    open(payload: ModalPayload) {
        this._apply(payload);
        this._show();
    },

    close() {
        this._hide();
    },

    confirm() {
        if (typeof this.onConfirm === 'function') {
            this.onConfirm();
        }
        this.close();
    },

    _show() {
        this.visible = true;
        document.body.classList.add('modal-open');
    },

    _hide() {
        this.visible = false;
        document.body.classList.remove('modal-open');
    },

    _apply({
               title,
               message,
               type = 'info',
               confirmText = 'OK',
               cancelText = 'Cancel',
               onConfirm = null
           }: ModalPayload) {
        this.title = title;
        this.message = message;
        this.type = type;
        this.confirmText = confirmText;
        this.cancelText = cancelText;
        this.onConfirm = onConfirm;
    }
}));
