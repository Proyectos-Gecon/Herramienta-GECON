<script setup>
import BackButton from "@/Components/customs/BackButton.vue";
const props = defineProps({
    title: String,
    url: String,
})
</script>

<template>
     <div class="w-full px-4 py-5 md:px-6 lg:px-8 border-slate-500 border-b rounded-xl mb-4 shadow-sm shadow-blue-500 bg-sky-500/[0.1]">
            <slot name="head" />
          
            <div class="flex align-items-start justify-between">
              <div>
                <div class="font-extrabold text-3xl text-900">{{ props.title }}</div>
                <div class="flex align-items-center text-700 flex-wrap">
                    <slot name="footer" />
                </div>
              </div>
              <div class="mt-3 lg:mt-0 space-x-2 flex">
                <slot name="buttons" />
              </div>
            </div>
          </div>
</template>