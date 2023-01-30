<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Button from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import InputText from 'primevue/inputtext';
    import { Link, useForm } from "@inertiajs/inertia-vue3";

    const props = defineProps({
        users: {
            type: Object,
        },
    });


    var form = useForm({
        nombre_almacen: null,
        gerencia_id: null,
        ubicacion: null,
    });
   
    const submit = () => {
        form.post(route('almacens.store'),{
            onSuccess: () => {
                alert('Enviado')
            }
        })
    }
</script>

<template>
    <AppLayout>
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-auto">
                    <div class="flex justify-between mx-auto p-4">
                        <span class="text-xl font-bold">Crear Almacen</span>
                        <Link type="button" :href="route('almacens.index')">
                            <Button label="Volver" icon="pi pi-chevron-left" class="p-button-raised p-button-warning p-button-text" />
                        </Link>
                    </div> 
                    <form @focusout="validate" @submit.prevent="submit" class="my-8">
                        <div class="grid grid-cols-2 my-4 gap-6 px-6">
                        <div class="p-fluid border-0 space-y-2">
                            <span>Nombre</span>
                            <InputText v-model="form.nombre_almacen" placeholder="Escriba el nombre del Almacen"></InputText>
                        </div>
                        <div class="p-fluid border-0 space-y-2">
                            <span>Gerencia</span>
                            <InputText v-model="form.gerencia_id" placeholder="Seleccione una Gerencia"></InputText>
                        </div>
                        <div class="p-fluid border-0 space-y-2">
                            <span>Ubicacion</span>
                            <InputText v-model="form.ubicacion" placeholder="Escriba la ubicación del almacen"></InputText>
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