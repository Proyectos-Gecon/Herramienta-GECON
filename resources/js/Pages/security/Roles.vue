<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import ConfirmPopup from "primevue/confirmpopup";
import { useConfirm } from "primevue/useconfirm";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import InputSwitch from 'primevue/inputswitch';
import Listbox from 'primevue/listbox';

const props = defineProps({
  roles: Array(),
  permisos: Array(),
});

var display = ref(false);

const confirm = useConfirm();

var form = useForm({
    _method: 'POST',
    name: '',
    id: '',
    permisos: [],
})

var filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "country.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  representative: { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
};

const selectAll = () => {
    form.permisos = props.permisos
}

const submit = () => {
    form.post(route('roles.store'),{
        onSuccess: () => {
          this.display = ref(false);
        }
    })
}

const active = (id) => {
      form.role = id;
      form.delete(route("roles.destroy", id), {
          onSuccess: () => {
          //   toast.add({
          //     severity: "info",
          //     summary: "Contratistas",
          //     detail: "Contratista Eliminado Exitosamente",
          //     life: 3000,
          //   });
          },
      });
}

const deleted = (event, id) => {
  confirm.require({
    target: event.currentTarget,
    message: "¿Eliminar Rol?",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      form.role = id;
      form.delete(route("roles.destroy", id), {
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
  <AppLayout title="Roles">
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
            :value="props.roles"
            class="p-datatable-sm"
            filterDisplay="menu"
            dataKey="id"
            v-model:filters="filters"
            :globalFilterFields="['APELLIDOS_NOMBRES', 'NUM_SAP']"
            showGridlines
            :paginator="true"
            :rows="10"
            :rowsPerPageOptions="[10, 25, 50]"
          >
            <template #header>
              <div class="flex justify-between">
                <Button
                  class="p-button-raised p-button-info p-button-text"
                  icon="pi pi-plus"
                  v-on:click="display = true"
                />
                <span class="mt-2 text-2xl"> Roles</span>
                <div>
                  <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                      v-model="filters.global.value"
                      placeholder="Keyword Search"
                    />
                  </span>
                </div>
              </div>
            </template>
            <Column field="name" header="Rol" :sortable="true"></Column>
            <Column
              field="ID"
              header="Estado"
              headerStyle="width: 4rem; text-align: center"
              bodyStyle="text-align: center; overflow: visible"
            >
              <template #body="{ data }" style="min-width: 8rem">
                <div class="flex cursor-pointer" @click="active(data.id)">
                  <i :class=" data.status == 1 ? 'pi pi-check-circle text-green-400':'pi pi-times-circle text-red-500'" style="font-size: 1rem"></i>
                  <span class="ml-2 -mt-1">{{data.status == 1 ? 'Activo':'Inactivo'}}</span>
                </div>
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
                    icon="pi pi-info-circle"
                    class="
                      p-button-rounded p-button-info p-button-text
                      text-4xl
                    "
                  />
                  <ConfirmPopup></ConfirmPopup>
                  <Button
                    style="font-size: 4rem"
                    @click="deleted($event, data.id)"
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
    <Dialog header="Agregar Rol" v-model:visible="display" position="top"  :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}">
        <form @submit.prevent="submit">
            <div class="mx-auto p-fluid border-0  mt-2">
                <span class="text-md font-semibold">Nombre del rol</span>
                <InputText
                v-model="form.name"
                    placeholder="Escriba El nombre del Nuevo Rol"
                />
                <div class="mt-4 space-y-2">
                  <div class="flex w-ful justify-between">
                    <span class="text-md font-semibold mt-4">Seleccionar permisos</span>
                    <div>

                      <Button label="Seleccionar Todo" @click="selectAll() "  class="p-button-text p-button-sm" />
                    </div>
                  </div>
                  <Listbox v-model="form.permisos" :filter="true" :options="props.permisos"  :multiple="true"/>
                </div>
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