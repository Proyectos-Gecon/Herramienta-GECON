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
import Chip from 'primevue/chip';
import { permisos } from '@/composable/Permisions.js'

const can = (array) => {
		var {val} = permisos(array)
		return val
	}

const props = defineProps({
  users: Array(),
  personal: Array
})

const displayModal = ref(false)

const form = useForm({
  _method: "DELETE",
  contratista: "",
});

const formTraer = useForm({
  user_actual_supervisor: null,
  user_nuevo_supervisor: null,
})

const formatCurrency = (value) => {
    return new Intl.NumberFormat().format(Number(value).toFixed(0) )
}
const intialSalarioValue = 0;
const costoTotal = props.users.reduce(
  (accumulator, user) => accumulator + (user.BET01/240)*1.60,
  intialSalarioValue
);


var counts = props.users.reduce((p, c) => {
  var name = c.tipo_contrato;
  if (!p.hasOwnProperty(name)) {
    p[name] = 0;
  }
  p[name]++;
  return p;
}, {})

var countsExtended = Object.keys(counts).map(k => {
  return {name: k, count: counts[k]}; });


var filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'country.name': {value: null, matchMode: FilterMatchMode.STARTS_WITH},
    'representative': {value: null, matchMode: FilterMatchMode.IN},
    'status': {value: null, matchMode: FilterMatchMode.EQUALS},
    'verified': {value: null, matchMode: FilterMatchMode.EQUALS}
});

const confirm = useConfirm();

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

const traerPersonal = () => {
  formTraer.get(route('traerPersonal'), {
    onSuccess: ()  => {
      alert('traer')
    }
  })
}
</script>

<template>
 <AppLayout title="Personal">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
                <div class="flex align-items-center flex-column sm:flex-row mx-4 overflow-x-scroll">
                  <Chip :label="(cargo.name + ': ' + cargo.count)" class="mr-2 mb-2  custom-chip" v-for="cargo in countsExtended" :key="cargo.name"/>
                </div>
                <DataTable :value="props.users" class="p-datatable-sm" filterDisplay="menu" dataKey="id" v-model:filters="filters" 
                :globalFilterFields="['APELLIDOS_NOMBRES','NUM_SAP', 'IDENTIFICACION']"  showGridlines  :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]">
                    <template #header>
                    <div class="flex justify-between mx-2">
                      <div class="text-center flex">
                        <Link type="button" :href="route('personal.create')" class="btn mx-4">
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-user-plus"  />
                        </Link> 
                        <Button @click="displayModal = true" class="p-button-raised p-button-info p-button-text" icon="pi pi-user-plus" label="Transladar Personal" />
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
                    <template #footer>
                      <div class="text-xl">
                        Costo Hora total $ {{ formatCurrency(costoTotal) }}
                      </div>
                    </template>
                    <Column field="NUM_SAP" header="# SAP"  ></Column>
                    <Column field="IDENTIFICACION" header="Identificación"  :sortable="true"></Column>
                    <Column field="APELLIDOS_NOMBRES" header="Nombre"  :sortable="true"></Column>
                    <Column field="tipo_contrato" header="Tipo de Contrato"></Column>
                    <Column field="parte.estado" header="Estado Parte"></Column>
                    <Column field="CARGO" header="Cargo" :sortable="true"></Column>
                    <Column field="BET01" header="Costo Hora" :sortable="true" v-if="can(['read personal details'])">
                      <template #body="{data}">
                        $ {{formatCurrency((data.BET01/180)*1.60 )}}
                      </template></Column>
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
                      
                        icon="pi pi-sign-out"
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
 </AppLayout>
 <Dialog
      header="Traer nuevo Personal"
      v-model:visible="displayModal"
      position="top"
      :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
      :style="{ width: '50vw' }"
    >
      <form @submit.prevent="traerPersonal">
        <div class="mx-auto p-fluid border-0 mt-2 space-y-2">
            <span class="text-md font-semibold">Division o Departamento</span>
            <Dropdown v-model="formTraer.user_actual_supervisor" :options="props.personal" optionValue="id" :filter="true" optionLabel="name" placeholder="Seleccionar El Auxiliar Anterior" />
        </div>
        <div class="mx-auto p-fluid border-0 mt-2 space-y-2">
            <span class="text-md font-semibold">Division o Departamento</span>
            <Dropdown v-model="formTraer.user_nuevo_supervisor" :options="props.personal" optionValue="id" :filter="true" optionLabel="name" placeholder="Seleccionar El Auxiliar Nuevo" />
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
</template>

<style lang="scss" scoped>
.p-chip.custom-chip {
    background: var(--green-50);
    color: var(--surface-900-color-text);
    font-size: x-small;
}
</style>