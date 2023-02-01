<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Button from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import Calendar from 'primevue/calendar';
    import Header from '@/Components/customs/Header.vue';
    const props = defineProps({
        users: {
            type: Object,
        },
    });


    var form = useForm({
        users: [],
        fecha_devolucion: null
    });
   
    const submit = () => {
        form.post(route('personal.store'),{
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
                    <Header title="Agregar Personal a mi Equipo">

                    </Header>
                    <form @focusout="validate" @submit.prevent="submit" class="my-8">
                        <div class="grid grid-cols-2 my-4 gap-6 px-6">
                            <div class="p-fluid border-0 p-input-filled">
                                <label for="">Seleccionar Personal</label>
                                <MultiSelect v-model="form.users" :filterFields="['APELLIDOS_NOMBRES', 'CARGO', 'IDENTIFICACION']" :filter="true" class="multiselect-custom" :options="props.users" optionLabel="APELLIDOS_NOMBRES" placeholder="Seleccionar Personas" display="chip">
                                    <template #option="slotProps">
                                        <div class="p-multiselect-car-option">
                                            <span>{{slotProps.option.APELLIDOS_NOMBRES}} - {{slotProps.option.CARGO}}</span>
                                        </div>
                                    </template>
                                </MultiSelect> 
                            </div>
                            <div class="p-fluid border-0 p-input-filled">
                                <label for="">Fecha de devolución</label>
                                <Calendar inputId="icon" v-model="form.fecha_devolucion" :min-date="new Date()" dateFormat="dd/mm/yy" :showIcon="true"/>
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