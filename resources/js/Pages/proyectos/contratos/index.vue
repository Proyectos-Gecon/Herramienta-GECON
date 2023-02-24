<script setup>
import { ref } from 'vue';
<<<<<<< HEAD
import { permisos } from "@/composable/Permisions.js";
=======
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
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
<<<<<<< HEAD
import HeaderPage from "@/Components/customs/HeaderPage.vue";

const can = (array) => {
  var { val } = permisos(array);
  return val;
};
=======

>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
//Variables
const props = defineProps({
  contratos: Array(),
})
const form = useForm({
  _method: "DELETE",
  contrato: "",
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
    message: "¿Desea Eliminar el contrato "+name+"?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.contrato = id;
      form.delete(route("contratos.destroy", id), {
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


const { exporting } = exportExcel(props.contratos, "Contratos");

</script>

<template>
 <AppLayout title="Divisiones">
<<<<<<< HEAD
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full p-4">
                  
                <HeaderPage title="Contratos">
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
                          <span class="text-900 line-height-3">Lista de Contratos</span>
                      </li>
                      </ul>
                  </template>
                  
                  <template #buttons>
                            <Link
                            type="button"
                            :href="route('contratos.create')"
                            class="btn"
                            v-if="can(['create contratos'])"
                            >
                            <Button
                                label="Nuevo"
                                class="p-button-outlined mr-2"
                                icon="pi pi-plus"
                            ></Button>
                            </Link>
                        </template>
                </HeaderPage>
                <DataTable ref="dt" :value="props.contratos" responsiveLayout="scroll" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['contrato_id','objeto', 'material_casco']"   :paginator="true" :rows="25" :rowsPerPageOptions="[25,50,100]">
=======

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                <DataTable ref="dt" :value="props.contratos" responsiveLayout="scroll" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['contrato_id','objeto', 'material_casco']"  showGridlines  :paginator="true" :rows="25" :rowsPerPageOptions="[25,50,100]">
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
                    <template #header>
                    <div class="flex justify-between">
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
<<<<<<< HEAD
                       
                     
                         
                          <div>
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
                          </div>
                     
=======
                        <span class="mt-2 text-md md:text-2xl capitalize">Lista de contratos</span>
                        <div class="flex space-x-2">
                          <Link type="button" :href="route('contratos.create')" class="btn" v-if="$page.props.user.permisos.includes('create contratos')">
                              <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-plus"  /> 
                          </Link>
                          <div>
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
                          </div>
                        </div>
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
                    </div>
                </template>
                    <Column field="contrato_id" header="# Contrato"  sortable></Column>
                    <Column field="objeto" header="Objeto"  sortable></Column>
                    <Column field="cliente.nombre_cliente" header="Cliente" sortable></Column>
                    <Column field="supervisor" header="Supervisor" sortable ></Column>
                    <Column field="gerente" header="Gerente" sortable></Column>
                    <Column field="moneda" header="Moneda" sortable></Column>
                
                    <Column field="tipo_venta" header="Tipo de Venta" sortable></Column>
                    <Column field="precio_venta" header="Precio de Venta (Millones)" sortable></Column>
                    <Column field="fecha_inicio" header="Inicio" sortable></Column>
                    <Column field="fecha_fin" header="Fin" sortable></Column>
                    <Column field="estado" header="Estado" sortable></Column>
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
                    <Link :href="route('contratos.edit', data.id)"> 
                      <Button
                        icon="pi pi-pencil"
                        class="p-button-rounded p-button-info p-button-text"
                      />
                    </Link>
                    <ConfirmPopup></ConfirmPopup>
                    <Button
                      @click="deleted($event, data.id, data.contrato_id)"
                      icon="pi pi-trash"
                      class="p-button-rounded p-button-danger p-button-text"
                    ></Button>
                  </div>
                </template>
              </Column>
                </DataTable>
                    
                </div>
            </div>
<<<<<<< HEAD
=======
        </div>
        
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
 </AppLayout>

</template>

