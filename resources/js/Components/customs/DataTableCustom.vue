<script setup>
import { ref } from "vue";
import Button from "primevue/button";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import InputText from "primevue/inputtext";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { exportExcel } from "@/composable/ExportData";


const { exporting } = exportExcel(props.elements, "Proyectos");

const props = defineProps({
    modelName: String,
    labels : Array,
    elements: Array,
    globalFilters: Array,
    filters: Array
});

const filtros = ref(props.filters)

</script>

<template>
    <div>
        <DataTable :value="elements" 
        class="p-datatable-sm"
        currentPageReportTemplate="{first} al {last} de {totalRecords}"
        paginatorTemplate="CurrentPageReport PrevPageLink PageLinks NextPageLink RowsPerPageDropdown"
        filterDisplay="menu"
        dataKey="id"
        v-model:filters="filtros"
        :globalFilterFields="globalFilters"
        showGridlines
        :paginator="true"
        :rows="10"
        :rowsPerPageOptions="[10, 25, 50, 100]"
        >
        <template #header>
              <div class="flex justify-between">
                <span class="p-input-icon-left">
                  <i class="pi pi-search" />
                  <InputText
                    v-model="filters.global.value"
                    placeholder="Buscador Global"
                  />
                </span>

                <div class="flex space-x-2">
                  <div>
                    <Button
                      class="p-button-raised p-button-info p-button-text"
                      icon="pi pi-file-excel"
                      @click="exporting"
                    />
                  </div>
                </div>
              </div>
            </template>
            <Column v-for="col of labels" :field="col.field" :header="col.header" :key="col.field" sortable></Column>
        </DataTable>
    </div>
</template>