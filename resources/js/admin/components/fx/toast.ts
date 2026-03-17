interface Toast {
    id: string;
    message: string;
    type: ToastType;
    visible: boolean;
    timeout: number | null;
}

type ToastType = 'info' | 'success' | 'warning' | 'danger';

interface AddToastPayload {
    message: string;
    type?: ToastType;
    duration?: number;
}

Alpine.data('toast', () => ({
    toasts: [] as Toast[],

    add({ message, type = 'info', duration = 4000 }: AddToastPayload) {
        const id = crypto.randomUUID();

        const toast: Toast = {
            id,
            message,
            type,
            visible: true,
            timeout: null,
        };

        this.toasts.push(toast);

        toast.timeout = window.setTimeout(() => this.close(id), duration);
    },

    close(id: string) {
        const toast = this.toasts.find(t => t.id === id);
        if (!toast) return;

        toast.visible = false;

        if (toast.timeout !== null) {
            clearTimeout(toast.timeout);
            toast.timeout = null;
        }

        setTimeout(() => {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }, 300);
    }
}));
