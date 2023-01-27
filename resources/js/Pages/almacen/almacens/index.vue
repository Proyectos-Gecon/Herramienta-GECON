<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { Inertia } from "@inertiajs/inertia";
import DataTableCustom from "@/Components/customs/DataTableCustom";

const props = defineProps({
    almacenes : Array()
});


var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  nombre_almacen: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  gerencia_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  ubicacion: { value: null, matchMode: FilterMatchMode.IN },
});

const labels = [
    {
        header: 'Nombre',
        field: 'nombre_almacen',
        typeFilter: 'text',

    },{
        header: 'Gerencia',
        field: 'gerencia_id',
        typeFilter: 'text',
    },
    {
        header: 'Ubicacion',
        field: 'ubicacion',
        typeFilter: 'text',
    }
]

</script>
<template>
    <AppLayout title="Almacen">
        <div class="max-w-full mx-2 mt-4">
            <div class="bg-white overflow-hidden shadow-xl max-w-full py-4">
                <DataTableCustom :elements="almacenes" model="almacen" :filters="filters" :labels="labels"  keyState="data-key-almacen" :globalFilters="['nombre_almacen']"></DataTableCustom>
            </div>
        </div>
    </AppLayout>
</template>