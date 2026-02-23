<script setup>
import { useCartStore } from '@/stores/cart.js'

const props = defineProps({
    productId: { type: Number, required: true },
})

const cart = useCartStore()

async function add() {
    const res = await cart.add(props.productId, 1)
    if (res?.ok === false) {
        const msg = res.errors?.stock?.[0] || 'Cannot add to cart'
        alert(msg)
    }
}
</script>

<template>
    <button type="button" :disabled="cart.loading" @click="add">
        Add to cart
    </button>
</template>
