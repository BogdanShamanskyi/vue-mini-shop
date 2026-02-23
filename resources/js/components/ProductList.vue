<script setup>
import AddToCartButton from '@/components/AddToCartButton.vue'

defineProps({
    products: { type: Array, required: true },
    meta: { type: Object, required: true },
    loading: { type: Boolean, required: true },
})

const emit = defineEmits(['page'])
</script>

<template>
    <div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <b>Products</b>

            <div style="display:flex;gap:8px;align-items:center;">
                <button :disabled="meta.current_page <= 1" @click="emit('page', meta.current_page - 1)">
                    Prev
                </button>

                <span>Page {{ meta.current_page }} / {{ meta.last_page }}</span>

                <button :disabled="meta.current_page >= meta.last_page" @click="emit('page', meta.current_page + 1)">
                    Next
                </button>
            </div>
        </div>

        <div v-if="loading">Loading...</div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;">
            <div v-for="product in products" :key="product.id" style="border:1px solid #eee;padding:12px;">
                <div>
                    <a :href="`/products/${product.id}`">{{ product.title }}</a>
                </div>

                <div>{{ product.price }}</div>

                <AddToCartButton :product-id="product.id" />
            </div>
        </div>
    </div>
</template>
