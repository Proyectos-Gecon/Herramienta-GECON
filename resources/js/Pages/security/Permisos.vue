<script setup>
import { ref } from "vue";
import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Listbox from "primevue/listbox";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  roles: Array(),
  permisos: Array(),
});
const selectAll = () => {
    form.roles = props.roles
}

const eliminar = async (id, rol) => {
  const response = await Inertia.post(route('quitarRol', [id, rol]), {
    onSuccess: () => {
      alert('QUITADO')
    }
  })

}

var form = useForm({
  _method: "POST",
  name: "",
  id: "",
  roles: ["ADMIN"],
});

var display = ref(false);

var filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const submit = () => {
    if(form.id != ""){
      form.put(route("permisos.update", form.id), {
        onSuccess: () => {
          
        },
      })
    return
    }
    form.post(route("permisos.store"), {
    onSuccess: () => {},
    })
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
            :value="props.permisos"
            class="p-datatable-sm"
            filterDisplay="menu"
            dataKey="id"
            v-model:filters="filters"
            :globalFilterFields="['name']"
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
                <span class="mt-2 text-2xl"> Permisos</span>
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
            <Column field="id" header="#"></Column>
            <Column field="name" header="Permiso" :sortable="true"></Column>
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
                      mx-2 flex
                    "
                    v-for="rol in data.roles"
                    :key="rol.id"
                    >{{ rol.name }}  &nbsp;
                    <i class="pi pi-times-circle cursor-pointer" v-if="rol.id != 1" @click="eliminar(data.id, rol.id)"></i>
                    </span
                  >
                </div>
              </template>
            </Column>
            <Column
              field="ID"
              header="Estado"
              headerStyle="width: 4rem; text-align: center"
              bodyStyle="text-align: center; overflow: visible"
            >
              <template #body="{ data }" style="min-width: 8rem">
                <div class="flex cursor-pointer" @click="active(data.id)">
                  <i
                    :class="
                      data.status == 1
                        ? 'pi pi-check-circle text-green-400'
                        : 'pi pi-times-circle text-red-500'
                    "
                    style="font-size: 1rem"
                  ></i>
                  <span class="ml-2 -mt-1">{{
                    data.status == 1 ? "Activo" : "Inactivo"
                  }}</span>
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
                    icon="pi pi-pencil"
                    class="
                      p-button-rounded p-button-info p-button-text
                      text-4xl
                    "
                    v-on:click="display = true;
                    form.name = data.name;
                    form.id = data.id;
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
    <Dialog
      header="Agregar Permiso"
      v-model:visible="display"
      position="top"
      :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
      :style="{ width: '50vw' }"
    >
      <form @submit.prevent="submit">
        <div class="mx-auto p-fluid border-0 mt-2">
          <span class="text-md font-semibold">Acción</span>
          <InputText
            v-model="form.name"
            placeholder="Escriba El nombre del Nuevo Rol"
          />
          <div class="mt-4 space-y-2">
            <div class="flex w-ful justify-between">
              <span class="text-md font-semibold mt-4">Seleccionar Roles</span>
              <div>
                <Button
                  label="Seleccionar Todo"
                  @click="selectAll()"
                  class="p-button-text p-button-sm"
                />
              </div>
            </div>
            <Listbox
              v-model="form.roles"
              :filter="true"
              :options="props.roles"
              :multiple="true"
            />
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