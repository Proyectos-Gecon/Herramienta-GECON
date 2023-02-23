<script setup>
import { ref } from "vue";
import Button from "primevue/button";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ConfirmPopup from "primevue/confirmpopup";
import { useConfirm } from "primevue/useconfirm";
import Dialog from 'primevue/dialog';
import MultiSelect from 'primevue/multiselect';

import { exportExcel } from "@/composable/ExportData";

const confirm = useConfirm();


const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 2 }).format(number)
}

const { exporting } = exportExcel(props.elements, "Proyectos");

const props = defineProps({
    modelName: String,
    height: {
      default: '500px',
      type: String
    },
    loading: {
      default: false,
      type: Boolean
    },
    labels : Array,
    elements: Array,
    globalFilters: Array,
    filters: Array,
    model: String,
    keyState: String,
    actions: {
      default:true,
      type: Boolean
    },
    buscardorGlobal: {
      default: false,
      type: Boolean
    }
  });



  const filtros = ref(props.filters)

  const deleted = (event, id) => {
    confirm.require({
    target: event.currentTarget,
    message: "¿Desea Eliminar "+ props.model +"?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.division = id;
      form.delete(route(props.model+"s.destroy", id), {
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
    <div>
        <DataTable :value="elements" 
          class="p-datatable-sm"
          :scrollHeight="props.height"
          currentPageReportTemplate="{first} al {last} de {totalRecords}"
          :paginatorTemplate="{
                  '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                  '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink ',
                  '1300px': 'CurrentPageReport  FirstPageLink PrevPageLink PageLinks NextPageLink ',
                  default: 'CurrentPageReport  FirstPageLink PrevPageLink PageLinks NextPageLink  RowsPerPageDropdown'
              }"
          :loading="props.loading"
          filterDisplay="menu"
          dataKey="id"
          stateStorage="session" 
          :stateKey="props.keyState"
          v-model:filters="filtros"
          :globalFilterFields="globalFilters"
          :scrollable="true"  scrollDirection="horizontal"
          :paginator="true"
          :rows="25"
          :rowsPerPageOptions="[10, 25, 50, 100]"
        >
            <template #header>
              <div class="flex justify-between">
                <span class="p-input-icon-left" v-if="props.buscardorGlobal">
                  <i class="pi pi-search" />
                  <InputText
                    v-model="filters.global.value"
                    placeholder="Buscado Global"
                  />
                </span>
                <div class="flex space-x-2">
                    <Button
                      class="p-button-raised p-button-info p-button-text"
                      icon="pi pi-file-excel"
                      @click="exporting"
                    />
                </div>
              </div>
            </template>
            <Column v-for="col of props.labels" :field="col.field" :header="col.header" :key="col.field" sortable :showFilterMatchModes="false">

              <template #filter="{filterModel}" v-if="col.typeFilter !== undefined">
                    <InputText type="text" v-model="filterModel.value" class="p-column-filter" :placeholder="'Buscar por '+ col.header" v-if="col.typeFilter == 'text'"/>
                </template>
            </Column>
            <Column field="id" header="Acciones" v-if="props.actions">
                    <template #body="{data}" >
                        <div class="space-x-2" v-if="data.id !== undefined">
                          <Link :href="route(props.model +'s.edit', data.id)"> 
                          <Button
                            icon="pi pi-pencil"
                            class="p-button-rounded p-button-info p-button-text"
                          />
                        </Link>
                            <ConfirmPopup></ConfirmPopup>
                            <Button style="font-size: 4rem" @click="deleted($event, data.ID)" icon="pi pi-trash"                       class="p-button-rounded p-button-danger p-button-text"
                            ></Button>
                        </div>
                    </template>
            </Column>
        </DataTable>
    </div>
</template>