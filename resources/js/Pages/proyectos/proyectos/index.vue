<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Dropdown from 'primevue/dropdown';
import { Link, useForm } from "@inertiajs/inertia-vue3";
import ConfirmPopup from "primevue/confirmpopup";
import { useConfirm } from "primevue/useconfirm";
import { exportExcel } from "@/composable/ExportData";
import Chip from "primevue/chip";
import OverlayPanel from "primevue/overlaypanel";
import Divider from "primevue/divider";
import { permisos } from "@/composable/Permisions.js";
import FileUpload from 'primevue/fileupload';
import HeaderPage from "@/Components/customs/HeaderPage.vue";
const can = (array) => {
  var { val } = permisos(array);
  return val;
};

//Variables
const confirm = useConfirm();

const props = defineProps({
  proyectos: Array(),
  construccion: Number,
  tipos: Array
});

const onAdvancedUpload = () => {
        
}

const form = useForm({
  _method: "DELETE",
  contrato: "",
});

const dt = ref();
const op = ref();
const opClase = ref();
var contrato = ref(null);
var clase = ref(null);

var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  casco: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.CONTAINS },
  "clase.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "contrato.contrato_id": { value: null, matchMode: FilterMatchMode.CONTAINS },
  tipo_proyecto: { value: null, matchMode: FilterMatchMode.EQUALS },
  codigo_SAP: { value: null, matchMode: FilterMatchMode.CONTAINS },
  alcance: { value: null, matchMode: FilterMatchMode.EQUALS },
  estado_proyecto: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const closeModal = () => {
  displayModal = false;
};

var displayModalUpdate =  ref(false);

const deleted = (event, id, name) => {
  confirm.require({
    target: event.currentTarget,
    message: "¿Desea Eliminar el proyecto " + name + "?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.contrato = id;
      form.delete(route("proyectos.destroy", id), {
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

const toggle = (event, data) => {
  contrato = data;
  if (contrato.contrato_id != "-") {
    op.value.toggle(event);
  }
};
const toggleClase = (event, data) => {
  clase = data;
  if (clase.name != "-") {
    opClase.value.toggle(event);
  }
};

const { exporting } = exportExcel(props.proyectos, "Proyectos");

</script>

<template>
  <AppLayout title="Divisiones">
    <div class="py-4">
      <div class="max-w-full mx-2 sm:px-6 lg:px-8">
        <div
          class="
            bg-white
            overflow-hidden
            shadow-xl
            sm:rounded-lg
            max-w-full
            p-4
          "
        >
        <HeaderPage title="proyecto" :create="can(['create proyectos'])" url="proyectos.create">
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
                <span class="text-900 line-height-3">Lista de Proyectos</span>
              </li>
            </ul>
          </template>
          
          <template #buttons>
            <div>
                <Button icon="pi pi-upload" class=" p-button-info  p-button-outlined" @click="displayModalUpdate = true" label="Importar"/>
              </div>
          </template>

          <template #footer>
            <div class="mr-5 flex align-items-center mt-3">
                    <i class="fa fa-ship mr-2"></i>
                    <span>{{ props.proyectos.length }} Proyectos totales</span>
                  </div>
                
                  <div class="flex align-items-center mt-3 space-x-1">
                    <i class="fa-solid fa-hammer"></i>
                    <span class="cursor-pointer" @click="filters.estado_proyecto.value = 'CONSTRUCCIÓN'">
                      {{ props.construccion }} Proyectos en construcción</span
                    >
                  </div>
          </template>
        </HeaderPage>
          <!-- <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
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
                <span class="text-900 line-height-3">Lista de Proyectos</span>
              </li>
            </ul>
            <div class="flex align-items-start justify-between">
              <div>
                <div class="font-medium text-3xl text-900">Proyectos</div>
                <div class="flex align-items-center text-700 flex-wrap">
                  
                </div>
              </div>
              <div class="mt-3 lg:mt-0 space-x-2 flex">
                <Link
                  type="button"
                  :href="route('proyectos.create')"
                  class="btn"
                  v-if="can(['create proyectos'])"
                >
                  <Button
                    label="Nuevo"
                    class="p-button-outlined mr-2"
                    icon="pi pi-plus"
                  ></Button>
                </Link>
                <div>
                  <Button icon="pi pi-upload" class=" p-button-info  p-button-outlined" @click="displayModalUpdate = true" label="Importar"/>
                </div>
              </div>
            </div>
          </div> -->
          <DataTable
            ref="dt"
            :value="props.proyectos"
            class="p-datatable-sm"
            currentPageReportTemplate=" {first} al {last} de {totalRecords}"
            paginatorTemplate="CurrentPageReport PrevPageLink PageLinks NextPageLink RowsPerPageDropdown"
            filterDisplay="menu"
            dataKey="id"
            stateStorage="session" 
            stateKey="data-key-proyectos"
            v-model:filters="filters"
            :globalFilterFields="[
              'casco',
              'name',
              'contrato.contrato_id',
              'clase.name',
              'estado',
              'codigo_SAP'
            ]"
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
                    placeholder="Buscado Global"
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
            <Column field="casco" header="# Casco" sortable>
              <template #body="{ data }">
                <Link
                  :href="route('proyectos.show', data.id)"
                  class="image-text font-extrabold cursor-pointer"
                  >{{ data.casco }}</Link
                >
              </template>
              <template #filter="{filterModel}">
                  <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar por Numero de Casco"/>
              </template>
            </Column>
            <Column field="name" header="Nombre" sortable>
              <template #filter="{filterModel}">
                  <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar por Nombre"/>
              </template>
            </Column>

            <Column field="clase.name" header="Clase" sortable>
              <template #body="{ data }">
                <span
                  class="image-text font-extrabold text-blue-400 cursor-pointer"
                  @click="toggleClase($event, data.clase)"
                  v-if="data.clase != null"
                  >{{ data.clase.name }}</span
                >
              </template>
              <template #filter="{filterModel}">
                  <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar por Nombre de Clase"/>
              </template>
            </Column>

            <Column field="contrato.contrato_id" header="Contrato" sortable>
              <template #body="{ data }">
                <span
                  class="image-text text-blue-400 font-extrabold cursor-pointer"
                  @click="toggle($event, data.contrato)"
                  v-if="data.contrato != null"
                  >{{ data.contrato.contrato_id }}</span
                >
              </template>
              <template #filter="{filterModel}">
                  <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar por ID de contrato"/>
              </template>
            </Column>

            <Column
              field="tipo_proyecto"
              header="Tipo de Proyecto"
              sortable
            >
            <template #filter="{filterModel}">
              <Dropdown v-model="filterModel.value"  :options="tipos" placeholder="Seleccione un tipo de proyecto" />
              </template>
            </Column>
            <Column field="codigo_SAP" header="PEP" sortable>
              <template #filter="{filterModel}">
                  <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Buscar PEP"/>
              </template>
            </Column>
            <Column field="alcance" header="Alcance" sortable>
              <template #filter="{filterModel}">
              <Dropdown v-model="filterModel.value"  :options="['ADQUISICÓN Y ENTREGA', 'CO DESARROLL DISEÑO Y CONSTRUCCIÓN', 'CO PRODUCCIÓN', 'CONSTRUCCIÓN', 'DISEÑO BUQUE', 'DISEÑO Y CONSTRUCCIÓN', 'SERVICIOS INDUSTRIALES']" placeholder="Seleccione un alcance" />
              </template>
            </Column>
            <Column field="estado_proyecto" header="Estado" sortable>
              <template #filter="{filterModel}">
              <Dropdown v-model="filterModel.value"  :options="['DISEÑO Y CONSTRUCCIÓN','CONSTRUCCIÓN', 'DISEÑO', 'GARANTIA', 'SERVICIO POSTVENTA']" placeholder="Seleccione un alcance" />
              </template>
            </Column>
            <Column field="contrato.fecha_inicio" header="Inicio" sortable></Column>
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
                  <Link
                    :href="route('proyectos.edit', data.id)"
                    v-if="can(['edit proyectos'])"
                  >
                    <Button
                      icon="pi pi-pencil"
                      class="p-button-rounded p-button-info p-button-text"
                    />
                  </Link>

                  <Link
                    :href="route('proyectos.duplicate', data.id)"
                    v-if="can(['create proyectos'])"
                  >
                    <Button
                      icon="pi pi-clone"
                      class="p-button-rounded p-button-help p-button-text"
                    />
                  </Link>
                  <ConfirmPopup></ConfirmPopup>
                  <Button
                    v-if="can(['delete proyectos'])"
                    @click="deleted($event, data.id, data.name)"
                    icon="pi pi-trash"
                    class="p-button-rounded p-button-danger p-button-text"
                  ></Button>
                </div>
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
    </div>

    <OverlayPanel ref="op" :showCloseIcon="true">
      <div class="mb-4">
        <span class="font-bold mb-2 text-center">
          Contrato: {{ contrato.contrato_id }}
        </span>
        <p class="text-gray-700 text-base mt-2">
          {{ contrato.objeto }}
        </p>
      </div>
      <div class="px-6 pt-2">
        <span
          class="
            inline-block
            bg-gray-200
            rounded-full
            px-3
            py-1
            text-sm
            font-semibold
            text-gray-700
            mr-2
            mb-2
          "
          >$ {{ contrato.precio_venta }} Millones</span
        >
        <span
          class="
            inline-block
            bg-gray-200
            rounded-full
            px-3
            py-1
            text-sm
            font-semibold
            text-gray-700
            mr-2
            mb-2
          "
          >{{ contrato.estado }}</span
        >
        <span
          class="
            inline-block
            bg-gray-200
            rounded-full
            px-3
            py-1
            text-sm
            font-semibold
            text-gray-700
            mr-2
            mb-2
          "
          >{{ contrato.fecha_inicio }}</span
        >
        <span
          class="
            inline-block
            bg-gray-200
            rounded-full
            px-3
            py-1
            text-sm
            font-semibold
            text-gray-700
            mr-2
            mb-2
          "
          >{{ contrato.fecha_fin }}</span
        >
      </div>
    </OverlayPanel>
    <OverlayPanel ref="opClase" :showCloseIcon="true">
      <div class="w-full rounded-3xl">
        <div class="text-center">
          <h3 class="text-center text-2xl font-bold">{{ clase.name }}</h3>
          <span class="text-sm">{{ clase.type }}</span>
          <Divider type="dashed" />
          <span class="text-sm">{{ clase.material_casco }}</span>
        </div>
        <Divider type="dashed" />
        <ul class="mt-4 mb-2 flex justify-center text-center text-lg">
          <li class="flex flex-col">
            <span class="font-bold">Eslora</span> {{ clase.eslora }}
          </li>
          <li class="mx-6 flex flex-col">
            <span class="font-bold">Manga</span> {{ clase.manga }}
          </li>
          <li class="flex flex-col">
            <span class="font-bold">Tripulacion</span>
            {{ clase.tripulacion_maxima }}
          </li>
        </ul>
      </div>
      <div class="w-full flex justify-end mt-4">
        <Link :href="route('clases.edit', clase.id)">
          <Button label="Editar" class="p-button-help p-button-text"></Button>
        </Link>
      </div>
    </OverlayPanel>

    <Dialog header="Carga Masiva" position="topright" v-model:visible="displayModalUpdate" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <form @submit.prevent="submit">
                <FileUpload name="file" :url="route('proyectos.upload')" @upload="onAdvancedUpload($event)" :multiple="false" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
                <template #content>
                    <ul v-if="uploadedFiles && uploadedFiles[0]">
                        <li v-for="file of uploadedFiles[0]" :key="file">{{ file.name }} - {{ file.size }} bytes</li>
                    </ul>
                </template>
                <template #empty>
                    <p>Drag and drop files to here to upload.</p>
                </template>
            </FileUpload>

            </form>
    </Dialog>
  </AppLayout>
</template>

