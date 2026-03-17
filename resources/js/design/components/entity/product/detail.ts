import {useMagic} from "@/shared/composables/alpine/use-magic";
import {ProductPrice} from "@/types/design/components/entity/product";

Alpine.data('productDetail', ()  => ({
    get priceData(): ProductPrice {
        const {$root} = useMagic(this)
        const el = $root.querySelector('[x-data="productPrice"]') as HTMLElement
        return Alpine.$data(el)
    },

    setPriceFromVariant(e: Event) {
        const target = e.target as HTMLElement

        this.priceData.setPrice({
            price: target.dataset.price!,
            oldPrice: target.dataset.oldPrice,
        })
    }
}))

