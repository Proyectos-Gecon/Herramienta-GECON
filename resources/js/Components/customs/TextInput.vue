<script setup>
import { onMounted, ref } from 'vue';
import InputText from "primevue/inputtext";


defineProps({
    modelValue: String,
    label: String,
    sugerencia: String
});

defineEmits(['update:modelValue']);

</script>

<template>
    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>{{ label }}</span>
        <InputText :value="modelValue" :placeholder="sugerencia" @input="$emit('update:modelValue', $event.target.value)"></InputText>
    </div>
</template>