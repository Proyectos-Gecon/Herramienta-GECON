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
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import { Inertia } from '@inertiajs/inertia';
import MultiSelect from 'primevue/multiselect';



const { exporting } = exportExcel(props.parte, "Parte de Personal");

const props = defineProps({
  parte: Array(),
  personalSinParte: Number,
  fecha: Date,
  divisiones: Array
})

const fechaDashboard = ref(props.fecha)
const selectFecha = () => {
    Inertia.get(route('parte.index', {
        fecha: fechaDashboard._value
    }))
}


var filters = ref({
    global: {value: null, matchMode: FilterMatchMode.CONTAINS},
    division: {value: null, matchMode: FilterMatchMode.IN}
});

</script>

<template>
 <AppLayout title="Personal">
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
              <div class="flex align-items-center mt-3 space-x-1">
                
                <i class="fa-solid fa-user-slash"></i>
                  <span>
                  {{ props.personalSinParte }} Personas No registradas</span
                >
              </div>
            </div>
          </div>
          <div class="mt-3 lg:mt-0 space-x-2 flex">
            <div>
                <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
            </div>
            <Calendar inputId="icon" :maxDate="new Date()" v-model="fechaDashboard" dateFormat="mm/dd/yy" :showIcon="true" v-on:date-select="selectFecha" placeholder="Seleccione una fecha"/>
          </div>
        </div>
      </div>
            <DataTable :value="props.parte" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
            :globalFilterFields="['NUM_SAP','APELLIDOS_NOMBRES','CARGO' ,'IDENTIFICACION','estado', 'proyecto' , 'area_trabajo', 'division']"  showGridlines  :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]">
                <template #header>
                <div class="flex justify-end mx-2">
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                    </span>
                </div>
            </template>
                <Column field="NUM_SAP" header="Personal"  :sortable="true"></Column>
                <Column field="APELLIDOS_NOMBRES" header="Personal"  ></Column>
                <Column field="CARGO" header="Cargo" :sortable="true"></Column>
                <Column field="area_trabajo" header="Area Trabajo" :sortable="true"></Column>
                <Column field="estado" header="Estado"  :sortable="true"></Column>
                <Column field="proyecto" header="Proyecto"  :sortable="true"></Column>

                <Column field="division" header="Division"  :sortable="true" :showFilterMatchModes="false">
                  <template #filter="{filterModel}" >
                    <MultiSelect  v-model="filterModel.value" :options="props.divisiones" optionValue="name" optionLabel="abreiacion" placeholder="Todas" />
                
                  </template>
                </Column>

                <Column field="truno" header="Turno" :sortable="true"></Column>
                <Column field="fecha" header="Fecha" :sortable="true"></Column>
            </DataTable>
                
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