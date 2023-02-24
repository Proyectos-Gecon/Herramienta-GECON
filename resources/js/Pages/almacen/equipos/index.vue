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

const props = defineProps({
    equipos : Array()
});


var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "padre.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  representative: { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
});

</script>
<template>
    <AppLayout title="Almacen">
        <div class="max-w-full mx-2 mt-4">
            <div class="bg-white overflow-hidden shadow-xl max-w-full py-4">
                <DataTable
                ref="dt"
                    :value="props.equipos"
                    class="p-datatable-customers"
                    dataKey="id"
                    :rowHover="true"
                    filterDisplay="menu"
                    v-model:filters="filters"
                    :globalFilterFields="['name', 'padre.name', 'codigo_interno', 'serial', 'estado']"
                    showGridlines
                    :paginator="true"
                    :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
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
                        <span class="mt-2 text-2xl">Equipos</span>
                        <div class="space-x-4">
                            <Link type="button" :href="route('equipos.create')" class="btn mx-4">
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi pi-plus"  />
                        </Link> 
                        </div>
                    </div>
                    </template>
                    <Column field="name" header="Nombre"></Column>
                    <Column field="codigo_interno" header="Codigo Interno"></Column>
                    <Column field="serial" header="Serial"></Column>
                    <Column field="estado_operativo" header="Estado Operativo"></Column>
                    <Column field="estado" header="Estado"></Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>