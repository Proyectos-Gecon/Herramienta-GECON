<script setup>
const props = defineProps({
    color: String,
    value: Number,
    text: String,
    border: String
})
</script>

<template>
    <div class="flex flex-wrap flex-row sm:flex-col mt-2 justify-center items-center w-full p-5 bg-white rounded-md shadow-xl border-l-4 " :class="border">
			<div class="flex justify-end w-full">
        <div>
            <div style="padding-top: 0.1em; padding-bottom: 0.1rem"
                class="flex items-center text-xs px-3  rounded-full text-black" :class="'bg-'+props.color+'-400'">{{ text }}</div>
        </div>
    </div>
    <div>
        <div class="font-bold text-5xl text-center">
            {{ value }}
        </div>
        
    </div>
</div>
</template>