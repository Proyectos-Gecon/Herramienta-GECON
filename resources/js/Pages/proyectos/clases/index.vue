<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ConfirmPopup from "primevue/confirmpopup";
import { useConfirm } from "primevue/useconfirm";
import { exportExcel } from "@/composable/ExportData";
import DataTableCustom from "@/Components/customs/DataTableCustom";
import Chip from 'primevue/chip';

//Variables
const props = defineProps({
  clases: Array(),
})
const form = useForm({
  _method: "DELETE",
  division: "",
})

var filters = ref({
  eslora: {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.CONTAINS}]},
  type:{operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.CONTAINS}]},
  "material_casco": { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.CONTAINS}]},
});

const labels = [
    {
        header: 'id',
        field: 'id',
    },
    {
        header: 'Nombre',
        field: 'name',  
        typeFilter: 'text',
    },
    {
        header: 'Tipo',
        field: 'type',
        typeFilter: 'text',
    },
    {
        header: 'Material del Casco',
        field: 'material_casco',
        typeFilter: 'text'
    },
    {
        header: 'Eslora',
        field: 'eslora',
      
    },
    
]


</script>

<template>
 <AppLayout title="Divisiones">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                  <DataTableCustom :elements="props.clases" model="clase" :filters="filters" keyState="data-key-clases" :labels="labels" :globalFilters="['name', 'type', 'material_casco', 'eslora']"></DataTableCustom>
                </div>
            </div>
        </div>
        
 </AppLayout>

</template>



