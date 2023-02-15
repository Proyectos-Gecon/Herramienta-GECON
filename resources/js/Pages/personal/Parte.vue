<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ConfirmPopup from "primevue/confirmpopup";
import { usePreValidate } from "@/composable/UsePrevalidate";
import ToggleButton from 'primevue/togglebutton';
import { useConfirm } from "primevue/useconfirm";
import Chip from 'primevue/chip';
import Card from 'primevue/card';
import Dropdown from 'primevue/dropdown';
import DataView from 'primevue/dataview';
import MultiSelect from 'primevue/multiselect';

const props = defineProps({
  users: Array(),
  proyectos: Array,
  parte: Number,
  estados: Array,
})
const form = useForm({
    _method: "POST",
    users: [],
});

onMounted(() => {
    
    props.proyectos.push('APOYO PROD')
    props.proyectos.push('ADMINISTRATIVO')


    for(let user of props.users){
        if(user.user !== null)
        form.users.push({
            id: user.user.ID,
            name: user.user.APELLIDOS_NOMBRES,
            cargo: user.user.CARGO,
            fecha: user.parte != null ? user.parte.fecha :null,
            proyecto: user.parte != null ? user.parte.proyecto:null,
            estado: user.parte != null ? user.parte.estado: null,
            turno: ref(false),
        })
    }
})


const confirm = useConfirm();


   
const { validate } = usePreValidate(form, {
        method: "post",
        url: route("parte.store"),
    });


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

const submit = () => {
        form.post(route('parte.store'),{
            onSuccess: () => {
                alert('Enviado')
            }
        })
    }
</script>

<template>
 <AppLayout title="Personal">
            <div class="max-w-full mx-2 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4">
            
                    <div class="flex justify-between mx-2 w-full">
                        <div>
                            <Link type="button" :href="route('personal.create')" class="btn mx-4">
                            <Button class="p-button-raised p-button-info p-button-text" icon="pi pi-user-plus"  />
                            </Link> 
                            <span class="mt-2 text-2xl">Parte Personal</span>
                        </div>
                        <div>
                            <span class="mt-8 text-sm mx-12 border border-green-400 p-2 rounded-full">{{ parte }} de {{ form.users.length }}</span>
                        </div>
                    </div>
                <form @focusout="validate" @submit.prevent="submit" class="my-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 p-2 gap-3 mt-4">
                    <Card v-for="(user, index) in form.users" :key="index" >
                        <template #title>
                            <div class="flex justify-between">
                                <span>
                                    {{ user.name }}
                                </span>
                                <ToggleButton v-model="user.turno" onIcon="pi pi-moon" offIcon="pi pi-sun" onLabel="Nocturno" offLabel="Diurno"/>
                            </div>
                        </template>
                        <template #content>
                          {{ user.cargo }}
                        </template>
                        <template #footer>
                            <div class="flex justify-between space-x-4">
                                <div class="p-fluid w-full border-2 rounded-md" :class="user.fecha == new Date().toLocaleDateString('en-CA') ? 'border-green-400':''">
                                <Dropdown v-model="user.estado" :filterFields="['estado']" :filter="true" class="multiselect-custom"  :options="props.estados" optionLabel="estado" optionValue="estado" placeholder="Seleccionar Estados" display="chip" :class="form.errors[`users.${index}.estado`] != null ? 'p-invalid':''">
                                </Dropdown> 
                                <small id="username2-help" class="p-error">{{
                                        form.errors[`users.${index}.estado`]
                                    }}</small>
                                </div>
                                <div class="p-fluid w-full border-2 rounded-md" :class="user.fecha == new Date().toLocaleDateString('en-CA') ? 'border-green-400':''" v-if="user.estado != 'VACAC'">
                                <Dropdown  v-model="user.proyecto" :options="props.proyectos"  placeholder="Seleccionar Proyecto" display="chip" :class="form.errors[`users.${index}.proyecto`] != null ? 'p-invalid':''">
                                </Dropdown> 
                                <small id="username2-help" class="p-error">{{
                                        form.errors[`users.${index}.proyecto`]
                                    }}</small>
                                </div>
                              
                            </div>
                        </template>
                    </Card>
                  
                </div>
                    <div class="px-[2%] text-end">
                            <Button
                                label="Guardar"
                                type="submit"
                                icon="pi pi-save"
                                iconPos="left"
                                />
                    </div> 
                </form>
            </div>
        </div>
 </AppLayout>

</template>
