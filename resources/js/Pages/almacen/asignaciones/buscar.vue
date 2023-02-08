<script setup>
import MenuHeader from '@/Components/customs/MenuHeader.vue';
import DataTableCustom from '@/Components/customs/DataTableCustom.vue'

const props = defineProps({
    asignaciones: Array,
    user: Object,
    userLogin: Number
})
const labels = [
   
    {
        header: 'Fecha',
        field: 'fecha',  
    },
 
    {
        header: 'Nombre',
        field: 'nombre',  
    },
    {
        header: 'Serial',
        field: 'serial',  
    },
    {
        header: 'Estado',
        field: 'estado',  
    },
 
]

</script>
<template>
    <MenuHeader :userLogin="props.userLogin"></MenuHeader>
    <div class="w-full pt-40 g-white overflow-hidden shadow-xl sm:rounded-lg mx-12">
     <dataTableCustom :elements="props.asignaciones" :labels="labels" model="asignacione" keyState="data-key-buscar"></dataTableCustom>
    </div>
</template>