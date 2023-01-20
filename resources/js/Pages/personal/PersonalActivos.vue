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
import Chip from 'primevue/chip';
import FileUpload from 'primevue/fileupload';

const props = defineProps({
  users: Array(),
})
const form = useForm({
  _method: "DELETE",
  contratista: "",
});

var displayModal =  ref(false);


var filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'user.APELLIDOS_NOMBRES': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'country.name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'representative': {value: null, matchMode: FilterMatchMode.IN},
    'status': {value: null, matchMode: FilterMatchMode.EQUALS},
    'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
});

const confirm = useConfirm();

const closeModal = () => {
        displayModal = false;
}

const deleted = (event, id) => {
  confirm.require({
    target: event.currentTarget,
    message: "¿Quitar de tu lista?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.delete(route("personal.destroy", id), {
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
</script>

<template>
 <AppLayout title="Personal">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
           
                <DataTable :value="props.users" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['APELLIDOS_NOMBRES','NUM_SAP']" 
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50, 100]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
                showGridlines  :paginator="true" :rows="10">
                    <template #header>
                    <div class="flex justify-between mx-2">
                      <div class="text-center flex">
                        <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar"/>
                        <span class="mt-2 text-2xl"> Personal</span>
                      </div>
                      <div>
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
                      </div>
                    </div>
                </template>
                    <Column field="user.NUM_SAP" header="# SAP"  ></Column>
                    <Column field="user.IDENTIFICACION" header="Identificación"  :sortable="true"></Column>
                    <Column field="user.APELLIDOS_NOMBRES" header="Nombre"  :sortable="true"></Column>
                    <Column field="division.name" header="Division/DPTO"  :sortable="true"></Column>
                    <Column
                    field="ID"
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
                      <Button
                        icon="pi pi-user-edit"
                        class="p-button-rounded p-button-info p-button-text text-4xl"
                      />
                    
                    <ConfirmPopup></ConfirmPopup>
                    <Button
                      style="font-size: 4rem"
                      @click="deleted($event, data.ID)"
                      icon="pi pi-user-minus"
                      class="p-button-rounded p-button-danger p-button-text"
                    ></Button>
                  </div>
                </template>
              </Column>
                </DataTable>
                    
                </div>
            </div>
        </div>
        <Dialog header="Carga Masiva" position="topleft" v-model:visible="displayModal" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <form @submit.prevent="submit">
                <FileUpload name="file" :url="route('personal.upload')" @upload="onAdvancedUpload($event)" :multiple="false" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
                <template #content>
                    <ul v-if="uploadedFiles && uploadedFiles[0]">
                        <li v-for="file of uploadedFiles[0]" :key="file">{{ file.name }} - {{ file.size }} bytes</li>
                    </ul>
                </template>
                <template #empty>
                    <p>Drag and drop files to here to upload.</p>
                </template>
            </FileUpload>

            </form>
            
        </Dialog>
        
 </AppLayout>

</template>

<style lang="scss" scoped>
.p-chip.custom-chip {
    background: var(--green-50);
    color: var(--surface-900-color-text);
    font-size: x-small;
}
</style>