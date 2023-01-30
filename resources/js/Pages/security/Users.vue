<script setup>
import { ref } from "@vue/reactivity";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Listbox from 'primevue/listbox';
import Dropdown from 'primevue/dropdown';
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "primevue/usetoast";

const toast = useToast();

const props = defineProps({
  users: Array(),
  roles: Array(),
  divisiones: Array(),
});

var form = useForm({
    _method: 'POST',
    user: '',
    roles: '',
    division_id: ''
})

const eliminar = async (id, rol) => {
  const response = await Inertia.post(route('removeRolUser', [id, rol]), {
    onSuccess: () => {
      Inertia.toast.add({severity:'success', summary: 'Success Message', detail:'Order submitted', life: 3000});
    }
  })

}

var display = ref(false)

var filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  "country.name": { value: null, matchMode: FilterMatchMode.STARTS_WITH },
  representative: { value: null, matchMode: FilterMatchMode.IN },
  status: { value: null, matchMode: FilterMatchMode.EQUALS },
  verified: { value: null, matchMode: FilterMatchMode.EQUALS },
};

const submit = () => {
    form.post(route('users.store'),{
        onSuccess: () => {
          console.log('enviado')
        }
    })
}

</script>
<template>
  <AppLayout title="Users">
    <Toast />
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
            :value="props.users"
            class="p-datatable-sm"
            filterDisplay="menu"
            dataKey="id"
            v-model:filters="filters"
            :globalFilterFields="['name', 'email']"
            showGridlines
            :paginator="true"
            :rows="10"
            :rowsPerPageOptions="[10, 25, 50]"
          >
            <template #header>
              <div class="flex justify-between">
                <span class="mt-2 text-2xl"> Usuarios de la Aplicacion</span>
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
            <Column field="name" header="Usuario" :sortable="true"></Column>
            <Column field="username" header="Nombre de Usuario" :sortable="true"></Column>
            <Column field="division.name" header="Division" :sortable="true"></Column>
            <Column field="roles" header="Roles" :sortable="true">
              <template #body="{ data }">
                <div class="flex justify-start">
                  <span
                    class="
                      p-2
                      text-xs
                      rounded-3xl
                      bg-indigo-400
                      text-white
                      mx-2
                    "
                    v-for="rol in data.roles"
                    :key="rol.id"
                    >{{ rol.name }}&nbsp;
                    <i class="pi pi-times-circle cursor-pointer" v-if="data.id != 1" @click="eliminar(rol.id, data.id)"></i>
                    </span
                  >
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
                    icon="pi pi-user-edit"
                    class="p-button-rounded p-button-info p-button-lg p-button-text"
                    v-on:click="
                    display = true;
                    form.user = data.id;
                    "
                  />
                 
                </div>
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
    </div>
  </AppLayout>

  <Dialog
      header="Agregar Permiso"
      v-model:visible="display"
      position="top"
      :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
      :style="{ width: '50vw' }"
    >
      <form @submit.prevent="submit">
        <div class="mx-auto p-fluid border-0 mt-2 space-y-2">
            <span class="text-md font-semibold">Division o Departamento</span>
            <Dropdown v-model="form.division_id" :options="props.divisiones" optionValue="id" :filter="true" optionLabel="name" placeholder="Seleccionar Division O Departamento" />
          <div class="mt-4 space-y-2">
            <div class="flex w-ful justify-between">
              <span class="text-md font-semibold mt-4">Seleccionar Roles</span>
              
            </div>
            <Dropdown v-model="form.roles" :options="props.roles"  :filter="true" placeholder="Seleccionar Division O Departamento" />
            
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
</template>