<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Header from '@/Components/customs/Header.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import MultiSelect from 'primevue/multiselect';
import Dropdown from 'primevue/dropdown';
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Listbox from 'primevue/listbox';
import TextInput from '@/Components/customs/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';

import { useToast } from "primevue/usetoast";
const toast = useToast();

//Variables
const props = defineProps({
  asignaciones: Array(),
  equipos: Array,
  personal: Array,
  proyectos: Array,
})

const form = useForm({
    persona_id: null,
    equipos: [],
    supervisor_id: null,
    proyecto_id: null,
    observacion: null
})

const submit = () => {
    
    form.post(route('asignaciones.store'),{
    onSuccess: () => {
        toast.add({severity:'success', summary: 'Asignaciones', detail:'Asignacion Agregada', life: 3000});
        Inertia.visit(route('asignaciones.index'))
       
    }
    })
      
  

}

</script>

<template>
 <AppLayout title="Asinaciones">

    <div class="py-4">
        <div class="max-w-full mx-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl shadow-slate-500 sm:rounded-lg max-w-full py-auto">
                <Header title="Asignar Equipos" /> 
                <form @focusout="validate" @submit.prevent="submit" class="pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 my-4 gap-6 px-6">
                    
                        <div class="p-fluid border-0 p-input-filled">
                            <label for="" class="text-lg font-semibold">Seleccionar Persona</label>
                            <Dropdown v-model="form.persona_id" :filterFields="['APELLIDOS_NOMBRES', 'CARGO', 'IDENTIFICACION']" optionValue="ID" :filter="true" class="multiselect-custom" :options="props.personal" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Personas" display="chip">
                                <template #option="slotProps">
                                    <div class="p-multiselect-car-option">
                                        <span>{{slotProps.option.APELLIDOS_NOMBRES}} - {{slotProps.option.CARGO}}</span>
                                    </div>
                                </template>
                            </Dropdown> 
                        </div>
                        
                        <div class="p-fluid border-0 p-input-filled">
                            <label for="" class="text-lg font-semibold">Seleccionar Supervisor</label>
                            <Dropdown v-model="form.supervisor_id" optionValue="ID" :filterFields="['APELLIDOS_NOMBRES', 'CARGO', 'IDENTIFICACION']" :filter="true" class="multiselect-custom" :options="props.personal" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Supervisor" display="chip">
                                <template #option="slotProps">
                                    <div class="p-multiselect-car-option">
                                        <span>{{slotProps.option.APELLIDOS_NOMBRES}} - {{slotProps.option.CARGO}}</span>
                                    </div>
                                </template>
                            </Dropdown> 
                        </div>

                        <div class="p-fluid border-0 p-input-filled">
                            <label for="" class="text-lg font-semibold">Seleccionar Proyecto</label>
                            <Dropdown v-model="form.proyecto_id" optionValue="id" :filterFields="['name']" :filter="true" class="multiselect-custom" :options="props.proyectos" optionLabel="name" placeholder="Seleccionar Supervisor" display="chip">
                            </Dropdown> 
                        </div>
                        
                        <TextInput label="Observaciones" v-model="form.observacion" sugerencia="Escriba una Observación"></TextInput>
                        
                        
                        <div class="p-fluid border-0 p-input-filled col-span-1 md:col-span-2">
                            <label for="" class="text-lg font-semibold">Seleccionar Equipos</label>
                            <Listbox  v-model="form.equipos" optionValue="id" :filterFields="['name', 'codigo_interno', 'serial']" :multiple="true" :filter="true" optionLabel="name" listStyle="max-height:250px"  class="multiselect-custom" :options="props.equipos" placeholder="Seleccionar Equipos" display="chip">
                                <template #option="slotProps">
                                    <div class="p-multiselect-car-option">
                                        <span>{{slotProps.option.name}} - {{ slotProps.option.serial }} </span>
                                    </div>
                                </template>
                            </Listbox> 
                        </div>
                    </div>
                    <div class="px-[2%] text-end mb-4">
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
    </div>
       
 </AppLayout>

</template>



