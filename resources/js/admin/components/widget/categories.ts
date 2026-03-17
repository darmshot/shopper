type CategoryState = Record<string, unknown>;

Alpine.data('categoryCardCategories', () => ({
    checked: [] as string[],
    stateCategories: {} as Record<string, CategoryState>,
    checkedAll: false,

    toggleCheckedAll() {
        this.checkedAll = !this.checkedAll

        if (this.checkedAll) {
            this.checked = Object.keys(this.stateCategories)
        }else {
            this.checked = []
        }
    },

    initStateCategory(categoryId: string) {
        this.stateCategories[categoryId] ??= {}
    }
}))
