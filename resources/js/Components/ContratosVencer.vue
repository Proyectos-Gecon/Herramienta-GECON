<template>
    <DataTableCustom  :elements="users" :labels="labels" :model="contratos" height="300px" :loading="loading" :actions="false">
    </DataTableCustom> 
</template>
<script setup>
import DataTableCustom from '@/Components/customs/DataTableCustom.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
const users = ref([])

var loading  = ref(false)

 onMounted(async () => {
    getData(10)
})

const getData = async (dias) => { 
    loading.value = true 
    await axios.get(route('getFinContratos', dias)).then((res) => {
        users.value = res.data.users;
        loading.value = false
       
    })
}

const labels = [
    
    {
        header: 'Nombre',
        field: 'name',
    },
    {
        header: 'Tipo de Contrato',
        field: 'tipo_contrato',
     
    },
    {
        header: 'Fecha',
        field: 'fecha',
    },
    {
        header: 'Prorrogas',
        field: 'prorrogas',
    },
]

</script>