<script setup>
import { onMounted, ref } from 'vue';
import InputNumber from 'primevue/inputnumber';

defineProps({
    modelValue: Number,
    label: String,
    sugerencia: String,
    suffix: String,
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="p-fluid p-input-filled border-0">
        <span class="text-lg font-semibold">{{ label }}</span>
        <InputNumber :modelValue="modelValue" @input="$emit('update:modelValue', $event.value)" locale="de-DE" :placeholder="sugerencia" :suffix="suffix" :maxFractionDigits="2" />
    </div> 
</template>
