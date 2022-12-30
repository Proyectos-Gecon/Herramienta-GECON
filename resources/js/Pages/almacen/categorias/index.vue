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
    categorias : Array()
});

const exportCSV = () => {
        Inertia.$refs.dt.exportCSV();
    }

var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "padre.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "padre.padre.name": { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
});

</script>
<template>
    <AppLayout title="Categorias">
        <div class="max-w-full mx-2 mt-4">
            <div class="bg-white overflow-hidden shadow-xl max-w-full py-4">
                <DataTable
                ref="dt"
                    :value="props.categorias"
                    class="p-datatable-sm"
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
                        <span class="mt-2 text-2xl"> Categorias</span>
                        <div class="space-x-4">
                            <!-- <Button
                            class="p-button-raised p-button-info p-button-text"
                            icon="pi pi-plus"
                            v-on:click="display = true"
                            /> -->
                            <Button
                            class="p-button-raised p-button-success p-button-text"
                            icon="pi pi-file-import"
                            v-on:click="display = true"
                            />
                            <Button icon="pi pi-external-link" label="Export" @click="exportCSV($event)" />
                        </div>
                    </div>
                    </template>
                    <Column field="name" filterField="name" :sortable="true" sortField="name" :showFilterMatchModes="false" :filterMenuStyle="{'width':'14rem'}" header="Nombre">
                        <template #body="{data}">
                            <span class="image-text">{{data.name}}</span>
                        </template>
                        <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template>
                    </Column>
                    <Column field="padre.name"  filterField="padre.name" :sortable="true" sortField="padre.name" :showFilterMatchModes="false" :filterMenuStyle="{'width':'14rem'}" header="Sub Grupo">
                        <template #body="{data}">
                            <span class="image-text">{{data.padre.name}}</span>
                        </template>
                        <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template>
                    </Column>
                    <Column field="padre.letra" header="Letra"></Column>

                    <Column field="padre.padre.name"  filterField="padre.padre.name" :sortable="true" sortField="padre.padre.name" :showFilterMatchModes="false" :filterMenuStyle="{'width':'14rem'}" header="Grupo">
                        <template #body="{data}">
                            <span class="image-text">{{data.padre.padre.name}}</span>
                        </template>
                        <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template></Column>
                    <Column field="padre.padre.letra" header="Letra"></Column>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>