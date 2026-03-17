type FeatureState = Record<string, unknown>;

Alpine.data('featureCardFeatures', () => ({
    checked: [] as string[],
    stateFeatures: {} as Record<string, FeatureState>,
    checkedAll: false,

    toggleCheckedAll() {
        this.checkedAll = !this.checkedAll

        if (this.checkedAll) {
            this.checked = Object.keys(this.stateFeatures)
        }else {
            this.checked = []
        }
    },

    initStateFeature(featureId: string) {
        this.stateFeatures[featureId] ??= {}
    }

}))
