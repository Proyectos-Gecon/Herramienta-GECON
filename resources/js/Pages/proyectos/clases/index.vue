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
import Chip from 'primevue/chip';

//Variables
const props = defineProps({
  clases: Array(),
})
const form = useForm({
  _method: "DELETE",
  division: "",
});

const dt = ref();

var filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'country.name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'representative': {value: null, matchMode: FilterMatchMode.IN},
    'status': {value: null, matchMode: FilterMatchMode.EQUALS},
    'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
});

const confirm = useConfirm();

const closeModal = () => {
        displayModal = false;
}

const deleted = (event, id, name) => {
  confirm.require({
    target: event.currentTarget,
    message: "¿Desea Eliminar esta la clase "+name+"?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.division = id;
      form.delete(route("clases.destroy", id), {
        onSuccess: () => {
        //   toast.add({
        //     severity: "info",
        //     summary: "Contratistas",
        //     detail: "Contratista Eliminado Exitosamente",
        //     life: 3000,
        //   });
        },
      });
    },
  });
};

const formatNumber = (number) => {
   return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 2 }).format(number)
}

const { exporting } = exportExcel(props.clases, "Clases");

</script>

<template>
 <AppLayout title="Divisiones">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                <DataTable ref="dt" :value="props.clases" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['name','type', 'material_casco']"  showGridlines  :paginator="true" :rows="25" :rowsPerPageOptions="[25,50,100]">
                    <template #header>
                    <div class="flex justify-between">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
                        <span class="mt-2 text-md md:text-2xl">Lista de clases</span>
                        <div class="flex space-x-2">
                          <Link type="button" :href="route('clases.create')" class="btn" v-if="$page.props.user.permisos.includes('create division')">
                              <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-plus"  /> 
                          </Link>
                          <div>
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
                          </div>
                        </div>
                    </div>
                </template>
                    <Column field="id" header="# ID"  sortable></Column>
                    <Column field="name" header="Nombre"  sortable></Column>
                    <Column field="proyectos_count" header="Proyectos" dataType="numeric" sortable></Column>
                    <Column field="type" header="Tipo Buque"  sortable></Column>
                    <Column field="material_casco" header="Material del Casto" sortable></Column>
                    <Column field="eslora" header="Eslora" sortable dataType="numeric" ></Column>
                    <Column field="manga" header="Manga" sortable dataType="numeric" ></Column>
                   
                    <Column
                    field="id"
                    header="Acciones"
                    headerStyle="width: 4rem; text-align: center"
                    bodyStyle="text-align: center; overflow: visible"
                    >
                    <template #body="{ data }" style="min-width: 8rem">
                    <div
                        class="
                        flex flex-column
                        md:flex-row md:justiify-content-between
                        "
                    >
                    <Link :href="route('clases.edit', data.id)"> 
                      <Button
                        icon="pi pi-pencil"
                        class="p-button-rounded p-button-info p-button-text"
                      />
                    </Link>
                    <ConfirmPopup></ConfirmPopup>
                    <Button
                      @click="deleted($event, data.id, data.name)"
                      icon="pi pi-trash"
                      class="p-button-rounded p-button-danger p-button-text"
                    ></Button>
                  </div>
                </template>
              </Column>
                </DataTable>
                    
                </div>
            </div>
        </div>
        
 </AppLayout>

</template>

