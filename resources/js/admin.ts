import '@tabler/core/dist/js/tabler.js';
import '@tabler/core/dist/css/tabler.css';


document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('form')?.querySelectorAll("[data-fx-field]").forEach(async (el) => {
        const field = el.getAttribute("data-fx-field");
        if (!field) return;

        try {
            const module = await import(`./admin/components/fx/field/${field}.ts`);
            if (module.default) {
                module.default(el);
            }
        } catch (e) {
            console.error(`Failed to load FX field: ${field}`, e);
        }
    });

    /*document.querySelectorAll("[data-ui]").forEach(async (el) => {
        const name = el.getAttribute("data-ui");
        if (!name) return;

        try {
            const module = await import(`./components/admin/ui/${name}.ts`);
            if (module.default) {
                module.default(el);
            }
        } catch (e) {
            console.error(`Failed to load UI: ${name}`, e);
        }
    });*/
});


Alpine.magic('notify', () => {
   return (type: string, message: string) => window.dispatchEvent(
        new CustomEvent('notify', {
            detail: { type, message }
        })
    );
})

