import {useMagic} from "@/shared/composables/alpine/use-magic";
import {ProductPrice} from "@/types/design/components/entity/product";

Alpine.data('productPrice', function (this: object): ProductPrice {
    const priceEl = () => {
        const {$refs} = useMagic(this)
        return $refs.price
    }

    const oldPriceEl = () => {
        const {$refs} = useMagic(this)
        return $refs.oldPrice
    }

    return {
        setPrice({price, oldPrice}: { price: string, oldPrice: string | null }) {
            priceEl().innerText = price

            oldPriceEl().innerText = oldPrice || ''
        }
    }

})
