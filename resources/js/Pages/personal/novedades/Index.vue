<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ConfirmPopup from "primevue/confirmpopup";
import { useConfirm } from "primevue/useconfirm";
import { exportExcel } from "@/composable/ExportData";
import Chip from 'primevue/chip';

//Variables
const props = defineProps({
  novedades: Array(),
  divisiones: Array
})

var display = ref(false)

const form = useForm({
  _method: "DELETE",
  division_id: '',
  user: '',
});

const submit = () => {
    form.put(route('personal.update', form.user),{
        onSuccess: () => {
          console.log('enviado')
        }
    })
}


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
                <DataTable ref="dt" :value="props.novedades" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['APELLIDOS_NOMBRES','type', 'material_casco']"  showGridlines  :paginator="true" :rows="25" :rowsPerPageOptions="[25,50,100]">
                    <template #header>
                    <div class="flex justify-between">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
                        <span class="mt-2 text-md md:text-2xl">Lista de Novedades</span>
                        <div class="flex space-x-2">
                          
                          <div>
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
                          </div>
                        </div>
                    </div>
                </template>
                    <Column field="user.NUM_SAP" header="# ID"  sortable></Column>
                    <Column field="user.APELLIDOS_NOMBRES" header="Nombre"  sortable></Column>
                    <Column field="supervisor.name" header="Encargado Parte"  sortable></Column>
                    <Column field="division.name" header="División"  sortable></Column>
                    <Column field="id" header="Actions"  sortable v-if="$page.props.user.permisos.includes('read activos')">
                      <template #body="{ data }" style="min-width: 8rem">
                        <div
                          class="
                            flex flex-column
                            md:flex-row md:justiify-content-between
                          "
                        >
                          <Button
                            icon="pi pi-user-edit"
                            class="p-button-rounded p-button-info p-button-lg p-button-text"
                            v-on:click="
                            display = true;
                            form.user = data.id;
                            "
                          />
                        
                        </div>
                      </template>
                    </Column>
                </DataTable>
                    
                </div>
            </div>
        </div>

        <Dialog
      header="Agregar Permiso"
      v-model:visible="display"
      position="top"
      :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
      :style="{ width: '50vw' }"
    >
      <form @submit.prevent="submit">
        <div class="mx-auto p-fluid border-0 mt-2 space-y-2">
            <span class="text-md font-semibold">Division o Departamento</span>
            <Dropdown v-model="form.division_id" :options="props.divisiones" optionValue="id" :filter="true" optionLabel="name" placeholder="Seleccionar Division O Departamento" />
        </div>
        <div class="px-[2%] text-end mt-8">
          <Button
            label="Crear"
            type="submit"
            icon="pi pi-save"
            iconPos="left"
          />
        </div>
      </form>
    </Dialog>
        
 </AppLayout>

</template>

