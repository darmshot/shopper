type BrandState = Record<string, unknown>;
Alpine.data('brandCardBrands', () => ({
    checked: [] as string[],
    stateBrands: {} as Record<string, BrandState>,
    checkedAll: false,

    toggleCheckedAll() {
        this.checkedAll = !this.checkedAll

        if (this.checkedAll) {
            this.checked = Object.keys(this.stateBrands)
        }else {
            this.checked = []
        }
    },

    initStateBrand(brandId: string) {
        this.stateBrands[brandId] ??= {}
    }
}))
