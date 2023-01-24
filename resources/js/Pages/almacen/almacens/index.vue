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
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "padre.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  representative: { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const labels = [
    {
        header: 'Nombre',
        field: 'nombre_almacen'
    },{
        header: 'Gerencia',
        field: 'gerencia_id'
    },
    {
        header: 'Ubicacion',
        field: 'ubicacion'
    }
]

</script>
<template>
    <AppLayout title="Almacen">
        <div class="max-w-full mx-2 mt-4">
            <div class="bg-white overflow-hidden shadow-xl max-w-full py-4">
                <DataTableCustom :elements="almacenes" :filters="filters" :labels="labels" :globalFilters="['nombre_almacen']"></DataTableCustom>
                <!-- <DataTable
                ref="dt"
                    :value="props.almacenes"
                    class="p-datatable-sm"
                    currentPageReportTemplate=" {first} al {last} de {totalRecords}"
                    paginatorTemplate="CurrentPageReport PrevPageLink PageLinks NextPageLink RowsPerPageDropdown"
                    filterDisplay="menu"
                    dataKey="id"
                    v-model:filters="filters"
                    :globalFilterFields="['name', 'padre.name']"
                    showGridlines
                    :paginator="true"
                    :rows="10"
                    :rowsPerPageOptions="[10, 25, 50]"
                >
                    <template #header>
                    <div class="flex justify-between">
                        <div>
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText
                            v-model="filters.global.value"
                            placeholder="Keyword Search"
                            />
                        </span>
                        </div>
                        <span class="mt-2 text-2xl">Almacenes</span>
                        <div class="space-x-4">
                            <Link type="button" :href="route('almacens.create')" class="btn mx-4">
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-user-plus"  />
                        </Link> 
                        </div>
                    </div>
                    </template>
                    <Column field="nombre_almacen" header="Nombre"></Column>
                    <Column field="gerencia_id" header="Gerencia"></Column>
                    <Column field="ubicacion" header="Ubicacion"></Column>
                </DataTable> -->
            </div>
        </div>
    </AppLayout>
</template>