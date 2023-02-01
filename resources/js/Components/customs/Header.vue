<script setup>
import BackButton from "@/Components/customs/BackButton.vue";
const props = defineProps({
    title: String
})
</script>

<template>
    <div>
        <div class="flex justify-between mx-auto p-4 space-x-2 bg-gradient-to-r from-cyan-500 to-blue-500 mb-8 shadow-xl">
            <div class="space-x-2">
            <BackButton></BackButton>
            <span class="text-2xl text-white mt-1 font-extrabold text-capitalize">{{ title }}</span>
            </div>
            <slot />
                     
        </div> 
    </div>
</template>