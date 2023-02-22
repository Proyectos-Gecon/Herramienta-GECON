<script setup>
import BackButton from "@/Components/customs/BackButton.vue";
const props = defineProps({
    title: String,
    url: String,
    create: Boolean
})
</script>

<template>
     <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
            <slot name="head" />
            <!-- <ul
              class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
            >
              <li>
                <a class="text-500 no-underline line-height-3 cursor-pointer"
                  >Proyectos</a
                >
              </li>
              <li class="px-2">
                <i class="pi pi-angle-right text-500 line-height-3"></i>
              </li>
              <li>
                <span class="text-900 line-height-3">Lista de Proyectos</span>
              </li>
            </ul> -->
            <div class="flex align-items-start justify-between">
              <div>
                <div class="font-medium text-3xl text-900">{{ props.title }}</div>
                <div class="flex align-items-center text-700 flex-wrap">
                    <slot name="footer" />
                  <!-- <div class="mr-5 flex align-items-center mt-3">
                    <i class="fa fa-ship mr-2"></i>
                    <span>{{ props.proyectos.length }} Proyectos totales</span>
                  </div>
                  <div class="flex align-items-center mt-3 space-x-1">
                    <i class="fa-solid fa-hammer"></i>
                    <span class="cursor-pointer" @click="filters.estado_proyecto.value = 'CONSTRUCCIÓN'">
                      {{ props.construccion }} Proyectos en construcción</span
                    >
                  </div> -->
                </div>
              </div>
              <div class="mt-3 lg:mt-0 space-x-2 flex">
                <Link
                  type="button"
                  :href="route(props.url)"
                  class="btn"
                  v-if="props.create"
                >
                  <Button
                    label="Nuevo"
                    class="p-button-outlined mr-2"
                    icon="pi pi-plus"
                  ></Button>
                </Link>
                <slot name="buttons" />
                <!-- <div>
                  <Button icon="pi pi-upload" class=" p-button-info  p-button-outlined" @click="displayModalUpdate = true" label="Importar"/>
                </div> -->
              </div>
            </div>
          </div>
</template>