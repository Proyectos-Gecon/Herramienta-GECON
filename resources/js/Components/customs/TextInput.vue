<script setup>
import { onMounted, ref } from 'vue';
import InputText from "primevue/inputtext";


defineProps({
    modelValue: String,
    label: String,
    sugerencia: String,
    error: String
});

defineEmits(['update:modelValue']);

</script>

<template>
<<<<<<< HEAD
    <div class="p-fluid p-input-filled border-0">
        <span class="text-lg font-semibold">{{ label }}</span>
=======
    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>{{ label }}</span>
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
        <InputText :value="modelValue" :placeholder="sugerencia" :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)"></InputText>
        <small id="username2-help" class="p-error">{{
           error
        }}</small>
    </div>
</template>