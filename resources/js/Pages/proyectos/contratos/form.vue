<script setup>
    import { ref } from "vue";
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Button from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import TextInput from '@/Components/customs/TextInput.vue';
    import InputText from 'primevue/inputtext';
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import Dropdown from 'primevue/dropdown';
    import InputNumber from 'primevue/inputnumber';
    import Calendar from 'primevue/calendar';
    import { Inertia } from '@inertiajs/inertia';
    import { usePreValidate } from "@/composable/UsePrevalidate";
    import NumberInput from '@/Components/customs/NumberInput.vue';
    import Dialog from 'primevue/dialog';
    import FileUpload from 'primevue/fileupload';
    import BackButton from "@/Components/customs/BackButton.vue";

    var form = useForm({
        contrato_id: props.contrato != null ? props.contrato.contrato_id : null,
        objeto: props.contrato != null ? props.contrato.objeto : null,
        cliente_id: props.contrato != null ? parseInt(props.contrato.cliente_id) : null,
        supervisor: props.contrato != null ? props.contrato.supervisor : null,
        gerente: props.contrato != null ? props.contrato.gerente : null,
        tipo_venta: props.contrato != null ? props.contrato.tipo_venta : null,
        fecha_inicio: props.contrato != null ? props.contrato.fecha_inicio : null,
        fecha_fin:props.contrato != null ? props.contrato.fecha_fin :  null,
        moneda: props.contrato != null ? props.contrato.moneda : 'COP',
        precio_venta: props.contrato != null ? props.contrato.precio_venta : null,
        estado: props.contrato != null ? props.contrato.estado : null
    });

    var displayModal =  ref(false);
    
    const { validate } = usePreValidate(form, {
        method: "post",
        url: route("contratos.store"),
        });


    const props = defineProps({
        clientes : Array,
        contrato: Object,
        gerentes: Array,
    });
    

    const submit = () => {
        form.post(route('contratos.store'),{
            onSuccess: () => {
                alert('Holaa')
               // Inertia.get(route('equipos.index'))
            }
        })
    }

    const onAdvancedUpload = () => {
        
    }
    /* End functions */ 
</script>

<template>
    <AppLayout>
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-auto">
                    <div class="flex justify-between mx-auto p-4 space-x-2">
                        <BackButton></BackButton>
                        <span class="text-2xl text-blue-400 mt-1 font-bold ">Crear Contratos</span>
                       
                        <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar"/>
                      
                    </div> 
                    <form @focusout="validate" @submit.prevent="submit" class="pb-4">
                        <div class="grid md:grid-cols-3 grid-cols-1 my-2 gap-6 px-6">
                            <TextInput label="Contrato ID" :error=" form.errors.contrato_id" v-model="form.contrato_id" sugerencia="Escriba el Id del contrato"></TextInput>

                            <TextInput label="Objeto del contrato" v-model="form.objeto" sugerencia="Escriba el Objeto"></TextInput>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Cliente</span>
                                <Dropdown v-model="form.cliente_id" :filter="true" :options="props.clientes" optionValue="id" optionLabel="nombre_cliente"  placeholder="Seleccione un Cliente" />
                            </div>
                            
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Gerente</span>
                                <Dropdown v-model="form.gerente" :filter="true" :editable="true" optionValue="APELLIDOS_NOMBRES" optionLabel="APELLIDOS_NOMBRES" :options="props.gerentes" placeholder="Seleccione o escriba el nombre del Gerente" />
                            </div>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Tipo de Venta</span>
                                <Dropdown v-model="form.tipo_venta"  :options="['VENTA DIRECTA', 'VENTA FINANCIADA', 'VENTA LEASING']" placeholder="Seleccione un tipo de venta" />
                            </div>
                            
                            <TextInput label="Supervisor" v-model="form.supervisor" sugerencia="Escriba el nombre del Supervisor"></TextInput>   
                        
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <label for="icon">Fecha de Inicio</label>
                                <Calendar inputId="icon" v-model="form.fecha_inicio" :showIcon="true" placeholder="Seleccione una fecha"/>
                            </div>
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <label for="icon">Fecha de fin</label>
                                <Calendar inputId="icon" v-model="form.fecha_fin" :showIcon="true" placeholder="Seleccione una fecha"/>
                            </div>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Modena</span>
                                <Dropdown v-model="form.moneda" :options="['COP', 'USD']" placeholder="Seleccione un tipo de venta" />
                            </div>
                          
                            <NumberInput label="Precio de Venta" v-model="form.precio_venta" sugerencia="Escriba el precio de Venta"></NumberInput>
                            
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Estado del Contrato</span>
                                <Dropdown v-model="form.estado"  :options="['LIQUIDADO', 'EN EJECUCIÓN']" placeholder="Seleccione un estado" />
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
        <Dialog header="Carga Masiva" position="topright" v-model:visible="displayModal" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <form @submit.prevent="submit">
                <FileUpload name="file" :url="route('contratos.upload')" @upload="onAdvancedUpload($event)" :multiple="false" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
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