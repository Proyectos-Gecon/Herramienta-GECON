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
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.CONTAINS },
  type: { value: null, matchMode: FilterMatchMode.CONTAINS },
  material: { value: null, matchMode: FilterMatchMode.CONTAINS },
  eslora: { value: null, matchMode: FilterMatchMode.CONTAINS },
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
        header: 'Proyectos',
        field: 'proyectos_count',  
    },
    {
        header: 'Tipo',
        field: 'type',
        typeFilter: 'text',
    },
    {
        header: 'Material del Casco',
        field: 'material',
        typeFilter: 'text'
    },
    {
        header: 'Eslora',
        field: 'eslora',
        typeFilter: 'text'
    },
]


</script>

<template>
 <AppLayout title="Divisiones">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                  <DataTableCustom :elements="props.clases" model="clase" :filters="filters" keyState="data-key-clases" :labels="labels" :globalFilters="['name', 'type', 'material', 'eslora']"></DataTableCustom>
                </div>
            </div>
        </div>
        
 </AppLayout>

</template>



