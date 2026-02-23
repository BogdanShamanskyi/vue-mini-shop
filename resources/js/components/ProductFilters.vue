<script setup>
const model = defineModel({ required: true })
defineEmits(['apply'])
</script>

<template>
    <div style="display:flex;gap:12px;align-items:end;border:1px solid #eee;padding:12px;">
        <label>
            Min price
            <input type="number" min="0" v-model="model.min_price" />
        </label>

        <label>
            Max price
            <input type="number" min="0" v-model="model.max_price" />
        </label>

        <button type="button" @click="$emit('apply')">Apply</button>
    </div>
</template>
