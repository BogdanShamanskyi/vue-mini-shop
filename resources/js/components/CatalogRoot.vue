<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import ProductFilters from '@/components/ProductFilters.vue'
import ProductList from '@/components/ProductList.vue'

const props = defineProps({
    categoryId: { type: Number, required: true },
})

const filters = ref({ min_price: '', max_price: '' })

const products = ref([])
const meta = ref({
    current_page: 1,
    last_page: 1,
    per_page: 12,
    total: 0,
})

const loading = ref(false)

async function load(page = 1) {
    loading.value = true
    try {
        const { data } = await axios.get(`/api/categories/${props.categoryId}/products`, {
            params: {
                min_price: filters.value.min_price || undefined,
                max_price: filters.value.max_price || undefined,
                page,
            },
        })

        products.value = data.data || []
        meta.value = data.meta || meta.value
    } finally {
        loading.value = false
    }
}

onMounted(() => load(1))
</script>

<template>
    <div style="display:grid;gap:16px;">
        <ProductFilters v-model="filters" @apply="load(1)" />
        <ProductList :products="products" :meta="meta" :loading="loading" @page="load" />
    </div>
</template>
