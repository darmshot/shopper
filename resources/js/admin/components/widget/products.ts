type VariantState = {
    expanded: boolean;
};

interface ProductState {
    variants: VariantState;
}

Alpine.data('widgetProducts', () => ({
    checked: [] as string[],
    stateProducts: {} as Record<string, ProductState>,
    expandedVariants: false,
    checkedAll: false,

    toggleAllVariants() {
        this.expandedVariants = !this.expandedVariants

        for (const id in this.stateProducts) {
            this.stateProducts[id].variants.expanded = this.expandedVariants
        }
    },

    variantCollapse(productId: string, state: boolean) {
        this.stateProducts[productId].variants.expanded = state
    },

    toggleVariantCollapse(productId: string) {
        const row = this.stateProducts[productId];
        this.stateProducts[productId].variants.expanded = !row.variants.expanded
    },

    toggleCheckedAll() {
        this.checkedAll = !this.checkedAll

        if (this.checkedAll) {
            this.checked = Object.keys(this.stateProducts)
        } else {
            this.checked = []
        }
    },

    initStateProduct(productId: string) {
        this.stateProducts[productId] ??= {
            variants: {expanded: false}
        }
    }
}))
