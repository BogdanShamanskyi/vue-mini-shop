<script setup>
import { onMounted, computed } from 'vue'
import { useCartStore } from '@/stores/cart.js'

const cart = useCartStore()

onMounted(() => {
    cart.fetch()
})

const count = computed(() => cart.summary.items_count)
const total = computed(() => cart.summary.total)
</script>

<template>
    <div style="display:flex;gap:10px;align-items:center;">
        <b>Cart</b>
        <span>{{ count }} items</span>
        <span>— {{ total }}</span>
    </div>
</template>
