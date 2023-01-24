<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    users:  Array(),
    division: Object
});

var form = useForm({
    _method: 'POST',
    name: props.division != null ? props.division.name :'',
    jefe_id: props.division != null ? props.division.jefe_id :'',
    abreiacion: props.division != null ? props.division.abreiacion :'',
    planillador_id: props.division != null ? props.division.planillador_id :'',
    auxiliares: null,
})

const submit = () => {
    if(props.division.id == null){
        form.post(route('divisiones.create'),{
            onSuccess: () => {
                alert('Enviado')
            }
        })
        return props.division;
    }
    form.put(route('divisiones.update', props.division.id),{
        onSuccess: () => {
            Inertia.get(route('divisiones.index'))
        }
    })
    
}
</script>

<template>
    <AppLayout title="Divisiones">
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-auto">
                    <div class="flex justify-start mx-auto p-4 space-x-2">
                        <Link type="button" :href="route('divisiones.index')">
                            <Button icon="pi pi-chevron-left" class=" p-button-info  p-button-sm" />
                        </Link>
                        <span class="text-2xl text-blue-400 mt-1 font-bold ">Crear División</span>
                    </div> 
                 
                    <form @focusout="validate" @submit.prevent="submit" class="my-8">
                        <div class="grid grid-cols-2 my-4 gap-6 px-6 ">
                          <div class="p-fluid border-0 space-y-2">
                            <span>Nombre</span>
                            <InputText v-model="form.name" placeholder="Escriba el nombre de la división"></InputText>
                          </div>
                          <div class="p-fluid border-0 space-y-2">
                            <span>Jefe de Division</span>
                            <Dropdown v-model="form.jefe_id" :options="props.users" optionValue="ID" :filter="true" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Usuario" />
                          </div>
                          <div class="p-fluid border-0 space-y-2">
                            <span>Planillador</span>
                            <Dropdown v-model="form.planillador_id" :options="props.users" optionValue="ID" :filter="true" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Usuario" />
                          </div>
                          <div class="p-fluid border-0 space-y-2">
                            <span>Auxiliares</span>
                            <MultiSelect v-model="form.auxiliares" :options="props.users" display="chip" optionValue="ID" :filter="true" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Usuario" />
                          </div>
                          <div class="p-fluid border-0 space-y-2">
                            <span>Abreviación</span>
                            <InputText v-model="form.abreiacion" placeholder="Escriba la Abrebiación de la división"></InputText>
                          </div>
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
         
        </div>
    </AppLayout>
</template>