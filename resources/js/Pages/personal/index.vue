<script setup>
import { ref } from "vue";
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
import { exportExcel } from "@/composable/ExportData";


const { exporting } = exportExcel(props.parte, "Parte de Personal");

const props = defineProps({
  parte: Array(),
  personalSinParte: Number
})

var filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

</script>

<template>
 <AppLayout title="Personal">

    <div class="py-4">
        <div class="max-w-full mx-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
            <ul
              class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
            >
              <li>
                <a class="text-500 no-underline line-height-3 cursor-pointer"
                  >Personal</a
                >
              </li>
              <li class="px-2">
                <i class="pi pi-angle-right text-500 line-height-3"></i>
              </li>
              <li>
                <span class="text-900 line-height-3">Parte de Personal</span>
              </li>
            </ul>
            <div class="flex align-items-start justify-between">
              <div>
                <div class="font-medium text-3xl text-900">Parte Actual</div>
                <div class="flex align-items-center text-700 flex-wrap">
                  <div class="mr-5 flex align-items-center mt-3">
                    <i class="fa fa-users mr-2"></i>
                    <span>{{ props.parte.length }} Personas Registradas</span>
                  </div>
                  <!-- <div class="mr-5 flex align-items-center mt-3">
                                      <i class="pi pi-globe mr-2"></i>
                                      <span>9402 Sessions</span>
                                  </div> -->
                  <div class="flex align-items-center mt-3 space-x-1">
                    
                    <i class="fa-solid fa-user-slash"></i>
                     <span>
                     {{ props.personalSinParte }} Personas No registradas</span
                    >
                  </div>
                </div>
              </div>
              <div class="mt-3 lg:mt-0 space-x-2">
                <div>
                    <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
                </div>
              </div>
            </div>
          </div>
                <DataTable :value="props.parte" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['user.APELLIDOS_NOMBRES','user.IDENTIFICACION']"  showGridlines  :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]">
                    <template #header>
                    <div class="flex justify-end mx-2">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
                    </div>
                </template>
                    <Column field="user.APELLIDOS_NOMBRES" header="Personal"  ></Column>
                    <Column field="user.CARGO" header="Cargo" :sortable="true"></Column>
                    
                    <Column field="estado" header="Estado"  :sortable="true"></Column>
                    <Column field="proyecto" header="Proyecto"  :sortable="true"></Column>
                    <Column field="truno" header="Turno" :sortable="true"></Column>
                    <Column field="fecha" header="Fecha" :sortable="true"></Column>
                   
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
</AppLayout>
</template>

<style lang="scss" scoped>
.p-chip.custom-chip {
    background: var(--primary-color);
    color: var(--primary-color-text);
}
</style>