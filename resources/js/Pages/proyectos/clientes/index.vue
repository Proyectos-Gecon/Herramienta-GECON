<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { useConfirm } from "primevue/useconfirm";
import { exportExcel } from "@/composable/ExportData";
import { Inertia } from '@inertiajs/inertia';

//Variables
const props = defineProps({
  clientes: Array(),
});
const form = useForm({
  _method: "POST",
  nombre_cliente: "",
  tipo_cliente: '',
  pais: ''
});

const dt = ref();
var display = ref(false);

var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "country.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  representative: { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
});



const closeModal = () => {
  displayModal = false;
};

const editingRows = ref([]);

const onRowEditSave = (event) => {
  let { newData, index } = event;

  Inertia.put(route('clientes.update', newData.id), newData)
  
}

const submit = () => {
  form.post(route('clientes.store'), {
    onSuccess: () => {
          this.display = ref(false);
        }
  });
}

const { exporting } = exportExcel(props.clientes, "Clientes");
</script>

<template>
  <AppLayout title="Clientes">
    <div class="py-4">
      <div class="max-w-full mx-2 sm:px-6 lg:px-8">
        <div
          class="
            bg-white
            overflow-hidden
            shadow-xl
            sm:rounded-lg
            max-w-full
            py-4
          "
        >
          <DataTable
            editMode="row"
            dataKey="id"
            v-model:editingRows="editingRows"
            @row-edit-save="onRowEditSave"
            ref="dt"
            :value="props.clientes"
            class="p-datatable-sm"
            filterDisplay="menu"
            v-model:filters="filters"
            :globalFilterFields="['name', 'type', 'material_casco']"
            showGridlines
            :paginator="true"
            :rows="25"
            :rowsPerPageOptions="[25, 50, 100]"
          >
            <template #header>
              <div class="flex justify-between">
                <span class="p-input-icon-left">
                  <i class="pi pi-search" />
                  <InputText
                    v-model="filters.global.value"
                    placeholder="Keyword Search"
                  />
                </span>
                <span class="mt-2 text-md md:text-2xl">Lista de Clientes</span>
                <div class="flex space-x-2">
                  <div>
                    <Button
                      class="p-button-raised p-button-info p-button-text"
                      icon="pi pi-file-excel"
                      @click="exporting"
                    />
                  </div>
                  <div>
                    <Button
                      class="p-button-raised p-button-info p-button-text"
                      icon="pi pi-plus"
                      v-on:click="display = true"
                    />
                  </div>
                </div>
              </div>
            </template>
            <Column field="nombre_cliente" header="Nombre" sortable>
              <template #editor="{ data, field }">
                <InputText v-model="data[field]" autofocus />
              </template>
            </Column>
            <Column field="tipo_cliente" header="Tipo Cliente" sortable>
              <template #editor="{ data, field }">
                <InputText v-model="data[field]" autofocus />
              </template>
            </Column>
            <Column field="pais" header="Pais" sortable>
              <template #editor="{ data, field }">
                <InputText v-model="data[field]" autofocus />
              </template>
            </Column>

            <Column
              :rowEditor="true"
              style="width: 10%; min-width: 8rem"
              bodyStyle="text-align:center"
            >
            </Column>
          </DataTable>
        </div>
      </div>
      <Dialog header="Agregar Cliente" v-model:visible="display" position="top"  :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}">
        <form @submit.prevent="submit">
            <div class="mx-auto p-fluid border-0  mt-2">
                <span class="text-md font-semibold">Nombre del Cliente</span>
                <InputText
                v-model="form.nombre_cliente"
                    placeholder="Escriba el nombre del Cliente"
                />
            </div> 
            <div class="mx-auto p-fluid border-0  mt-2">
                <span class="text-md font-semibold">Tipo de cliente</span>
                <InputText
                v-model="form.tipo_cliente"
                    placeholder="Escriba el tipo de Cliente"
                />
            </div> 
            <div class="mx-auto p-fluid border-0  mt-2">
                <span class="text-md font-semibold">País</span>
                <InputText
                v-model="form.pais"
                    placeholder="Escriba el nombre del País"
                />
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
    </div>
  </AppLayout>


</template>

