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

const props = defineProps({
  divisiones: Array(),
})
const form = useForm({
  _method: "DELETE",
  division: "",
});


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

const deleted = (event, id) => {
  confirm.require({
    target: event.currentTarget,
    message: "¿Desea Eliminar esta Division?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.division = id;
      form.delete(route("divisiones.destroy", id), {
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
 <AppLayout title="Divisiones">

    <div class="py-4">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                <DataTable :value="props.divisiones" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['name','jefe.APELLIDOS_NOMBRES']"  showGridlines  :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]">
                    <template #header>
                    <div class="flex justify-between">
                        <Link type="button" :href="route('divisiones.create')" class="btn" v-if="$page.props.user.permisos.includes('create division')">
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-plus"  /> 
                        </Link>
                        <span class="mt-2 text-md md:text-2xl"> Divisiones y Departamentos</span>
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters.global.value" placeholder="Keyword Search" />
                        </span>
                    </div>
                </template>
                    <Column field="id" header="#"  ></Column>
                    <Column field="name" header="División/DPTTO"  :sortable="true"></Column>
                    <Column field="abreiacion" header="Abreviación"  :sortable="true"></Column>
                    <Column field="jefe.APELLIDOS_NOMBRES" header="Jefe"  :sortable="true"></Column>
                    <Column field="planillador.APELLIDOS_NOMBRES" header="Planillador" :sortable="true">
                    </Column>
                    <Column field="planillador.auxiliares" header="Auxiliares" :sortable="true">
                      <template #body="{data}">
                        <div class="flex justify-start">
                          <span class="p-2 text-xs rounded-3xl bg-indigo-400 text-white mx-2" v-for="auxiliar in data.auxiliares" :key="auxiliar.id">{{auxiliar.user.APELLIDOS_NOMBRES}}</span>
                          
                        </div>
                          
                      </template>
                    </Column>
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
                    <Link :href="route('divisiones.edit', data.id)">
                    <Button
                        icon="pi pi-pencil"
                        class="p-button-rounded p-button-info p-button-text"
                      />
                    </Link>
                      
                    
                    <ConfirmPopup></ConfirmPopup>
                    <Button
                      @click="deleted($event, data.id)"
                      icon="pi pi-times"
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