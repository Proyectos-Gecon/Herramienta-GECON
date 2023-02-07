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
import Dropdown from 'primevue/dropdown';
import DataTableCustom from "@/Components/customs/DataTableCustom";
import { useToast } from "primevue/usetoast";
const toast = useToast();


//Variables
const props = defineProps({
  asignaciones: Array(),
})


const form = useForm({
  observacion: '',
  estado: null,
  equipo: null
})
var display = ref(false)

const submit = () => {
 
    form.post(route('asignaciones.descargar', form.equipo),{
        onSuccess: () => {
          toast.add({severity:'success', summary: 'Asignaciones', detail:'Asignacion Descargada', life: 3000});
          display.value = false
        }
    })
      
   
}

var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  "APELLIDOS_NOMBRES": { value: null, matchMode: FilterMatchMode.CONTAINS },
  "equipo.name": { value: null, matchMode: FilterMatchMode.CONTAINS },
  "equipo.serial": { value: null, matchMode: FilterMatchMode.CONTAINS },
  "equipo.codigo_interno": { value: null, matchMode: FilterMatchMode.CONTAINS },

});



</script>

<template>
 <AppLayout title="Asinaciones">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full p-4">
                    <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
            <ul
              class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
            >
              <li>
                <a class="text-500 no-underline line-height-3 cursor-pointer"
                  >Inicio</a
                >
              </li>
              <li class="px-2">
                <i class="pi pi-angle-right text-500 line-height-3"></i>
              </li>
              <li>
                <a class="text-500 no-underline line-height-3 cursor-pointer"
                  >Almacen</a
                >
              </li>
              <li class="px-2">
                <i class="pi pi-angle-right text-500 line-height-3"></i>
              </li>
              <li>
                <span class="text-900 line-height-3">Asignaciones</span>
              </li>
            </ul>
            <div class="flex align-items-start justify-between">
              <div>
                <div class="font-medium text-3xl text-900">Asignaciones</div>
               
              </div>
              <div class="mt-3 lg:mt-0 space-x-2">
                <Link
                  type="button"
                  :href="route('asignaciones.create')"
                  class="btn"
                 
                >
                  <Button
                    label="Nuevo"
                    class="p-button-outlined mr-2"
                    icon="pi pi-plus"
                  ></Button>
                </Link>
              </div>
            </div>
                  </div>
                   <DataTable :value="props.asignaciones"
                    class="p-datatable-sm"
                    currentPageReportTemplate="{first} al {last} de {totalRecords}"
                    :paginatorTemplate="{
                            '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                            '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink ',
                            '1300px': 'CurrentPageReport  FirstPageLink PrevPageLink PageLinks NextPageLink ',
                            default: 'CurrentPageReport  FirstPageLink PrevPageLink PageLinks NextPageLink  RowsPerPageDropdown'
                        }"
                    filterDisplay="menu"
                    dataKey="id"
                    v-model:filters="filters"
                    :globalFilterFields="[
                    'fecha_prestamo',
                    'equipo.name',
                    'equipo.serial',
                    'equipo.codigo_interno',
                    'APELLIDOS_NOMBRES',
                    'IDENTIFICACION',
                    'estado',
                    ]"
                    :paginator="true"
                    :rows="25"
                    :rowsPerPageOptions="[10, 25, 50, 100]">
                    <template #header>
                    <div class="flex justify-between">
                        <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText
                            v-model="filters.global.value"
                            placeholder="Buscado Global"
                        />
                        </span>

                        <div class="flex space-x-2">
                        <!-- <div>
                            <Button
                            class="p-button-raised p-button-info p-button-text"
                            icon="pi pi-file-excel"
                            @click="exporting"
                            />
                        </div> -->
                        </div>
                    </div>
                    </template>
                    <Column header="Fecha de prestamo" field="fecha_prestamo" sortable >
                    </Column>
                    <Column header="Persona" field="APELLIDOS_NOMBRES" sortable :showFilterMatchModes="false">
                        <template #filter="{filterModel}">
                            <div class="mb-3 font-bold">Buscar una Persona</div>
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar por Nombre Persona"/>
                        </template>
                    </Column>
                    <Column header="Equipo" field="equipo.name" sortable :showFilterMatchModes="false">
                        <template #filter="{filterModel}">
                            <div class="mb-3 font-bold">Buscar Equipos</div>
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar..."/>
                        </template>
                    </Column>
                    <Column header="Serial" field="equipo.serial" sortable :showFilterMatchModes="false">
                        <template #filter="{filterModel}">
                            <div class="mb-3 font-bold">Buscar Equipos</div>
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar..."/>
                        </template>
                    </Column>
                    <Column header="Codigo" field="equipo.codigo_interno" sortable :showFilterMatchModes="false">
                        <template #filter="{filterModel}">
                            <div class="mb-3 font-bold">Buscar Equipos</div>
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar..."/>
                        </template>
                    </Column>
                    <Column header="Estado" field="estado" sortable>
                    </Column>
                    <Column field="id" header="Acciones">
                    <template #body="{data}" >
                        <div class="space-x-2">
                        
                          <Button
                            v-on:click="display = true;
                            form.equipo = data.id;
                            "
                            icon="pi pi-download"
                            class="p-button-rounded p-button-help p-button-text"
                          />
                           
                            <Button style="font-size: 4rem" @click="deleted($event, data.ID)" icon="pi pi-trash"                       class="p-button-rounded p-button-danger p-button-text"
                            ></Button>
                        </div>
                    </template>
                    </Column>
                   </DataTable>
                </div>
            </div>
        </div>
        <Dialog header="Recibir Equipo" v-model:visible="display" position="top" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
          <form @submit.prevent="submit">
            <div class="mx-auto p-fluid border-0  mt-2">
                <span class="text-md font-semibold">Observación Devolución</span>
                <InputText
                v-model="form.observacion"
                    placeholder="Escriba una Observacion"
                />
            </div>
            <div class="p-fluid p-input-filled border-0 space-y-2 mt-2">
                <span>Estado del Equipo</span>
                <Dropdown v-model="form.estado" :options="['OPERATIVO', 'OPERATIVO CON LIMITACIONES','FUERA DE SERVICIO', 'BAJA']" placeholder="Seleccione o escriba el material del casco" />
            </div> 
             <div class="px-[2%] text-end mt-8">
                  <Button
                  label="Descargar"
                  type="submit"
                  icon="pi pi-download"
                  iconPos="left"
                  />
              </div>
        </form>
        </Dialog>

 </AppLayout>

</template>



