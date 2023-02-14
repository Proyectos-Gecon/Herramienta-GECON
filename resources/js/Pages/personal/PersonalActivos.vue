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
import Dropdown from 'primevue/dropdown';
import { exportExcel } from "@/composable/ExportData";

const props = defineProps({
  users: Array(),
  divisiones: Array
})


const { exporting } = exportExcel(props.users, "Parte de Personal");



const formatCurrency = (value) => {
    return new Intl.NumberFormat().format(Number(value).toFixed(1))
}

var displayModal =  ref(false);


var filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    APELLIDOS_NOMBRES: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'country.name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'representative': {value: null, matchMode: FilterMatchMode.IN},
    'status': {value: null, matchMode: FilterMatchMode.EQUALS},
    'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
});

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




</script>

<template>
 <AppLayout title="Personal">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
           
                <DataTable :value="props.users" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['APELLIDOS_NOMBRES','NUM_SAP','CARGO']" 
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[10,25,50, 100]" currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries" showGridlines  :paginator="true" :rows="10">
                    <template #header>
                    <div class="flex justify-between mx-2">
                      <div class="text-center flex">
                        <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-file-excel" @click="exporting" /> 
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
                    <Column field="NUM_SAP" header="# SAP"  ></Column>
                    <Column field="IDENTIFICACION" header="Identificación"  :sortable="true"></Column>
                    <Column field="APELLIDOS_NOMBRES" header="Nombre"  :sortable="true"></Column>
                    <Column field="CARGO" header="Cargo"  :sortable="true"></Column>
                    <Column field="tipo_contrato" header="Tipo Contrato"  :sortable="true"></Column>
                    <Column field="inicio_contrato" header="Inicio Contrato"  :sortable="true"></Column>
                    <Column field="fin_contrato" header="Fin Contrato"  :sortable="true"></Column>
                    <Column field="salario" header="Salario" data-type="number" :sortable="true">
                      <template #body="{data}">
                        $ {{formatCurrency(data.salario)}}
                      </template>
                    </Column>
                    <Column field="salario" header="Costo Mes" data-type="number" :sortable="true">
                      <template #body="{data}">
                        $ {{formatCurrency(data.salario * 1.6)}}
                      </template>
                    </Column>
                    <Column field="salario" header="Costo Hora" data-type="number" :sortable="true">
                      <template #body="{data}">
                        $ {{formatCurrency((data.salario/240) * 1.6)}}
                      </template>
                    </Column>
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
                      @click="
                        form.user = data.ID;
                        displayModal = true"
                        icon="pi pi-user-edit"
                        class="p-button-rounded p-button-info p-button-text text-4xl"
                      />
                  </div>
                </template>
              </Column>
                </DataTable>
                    
                </div>
            </div>
        </div>
        <Dialog
            header="Agregar División"
            v-model:visible="displayModal"
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

<style lang="scss" scoped>
.p-chip.custom-chip {
    background: var(--green-50);
    color: var(--surface-900-color-text);
    font-size: x-small;
}
</style>