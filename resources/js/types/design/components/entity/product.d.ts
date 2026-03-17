export interface ProductPrice {
    setPrice(payload: { price: string; oldPrice?: string | null }): void
}
