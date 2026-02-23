import { defineStore } from 'pinia'
import axios from 'axios'

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [],
        summary: { items_count: 0, total: 0 },
        loading: false,
    }),

    actions: {
        async fetch() {
            this.loading = true
            try {
                const { data } = await axios.get('/api/cart')
                this.items = data.items || []
                this.summary = data.summary || { items_count: 0, total: 0 }
            } finally {
                this.loading = false
            }
        },

        async add(productId, qty = 1) {
            this.loading = true
            try {
                const { data } = await axios.post('/api/cart/items', { product_id: productId, qty })
                this.items = data.items || []
                this.summary = data.summary || { items_count: 0, total: 0 }
                return { ok: true }
            } catch (e) {
                if (e?.response?.status === 422) {
                    return { ok: false, errors: e.response.data?.errors || {} }
                }
                throw e
            } finally {
                this.loading = false
            }
        },
    },
})
