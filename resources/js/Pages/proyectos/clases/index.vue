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
import HeaderPage from "@/Components/customs/HeaderPage.vue";
import { permisos } from "@/composable/Permisions.js";

const can = (array) => {
  var { val } = permisos(array);
  return val;
};

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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full p-4">
                    <HeaderPage title="Clases" :create="can(['create clases'])" url="clases.create">
                        <template #head>
                            <ul
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
                                <span class="text-900 line-height-3">Lista de Clases</span>
                            </li>
                            </ul>
                        </template>
                        
                        <template #buttons>
                            <Link
                            type="button"
                            :href="route('clases.create')"
                            class="btn"
                            v-if="can(['create clases'])"
                            >
                            <Button
                                label="Nueva"
                                class="p-button-outlined mr-2"
                                icon="pi pi-plus"
                            ></Button>
                            </Link>
                        </template>

                    </HeaderPage>
                    <DataTableCustom :buscardorGlobal="true" :elements="props.clases" model="clase" :filters="filters" keyState="data-key-clases" :labels="labels" :globalFilters="['name', 'type', 'material', 'eslora']"></DataTableCustom>
                </div>
            </div>
        </div>
 </AppLayout>

</template>



