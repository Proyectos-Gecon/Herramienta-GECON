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
    import InputMask from 'primevue/inputmask';
    import BackButton from "@/Components/customs/BackButton.vue";

    var form = useForm({
        casco: props.proyecto != null ? props.proyecto.casco:null,
        name:  props.proyecto != null ? props.proyecto.name:null,
        clase_id:  props.proyecto != null ? parseInt(props.proyecto.clase_id) : null,
        contrato_id:  props.proyecto != null ? parseInt(props.proyecto.contrato_id):null,
        tipo_proyecto:  props.proyecto != null ? props.proyecto.tipo_proyecto:null,
        codigo_SAP:  props.proyecto != null ? props.proyecto.codigo_SAP:null,
        estado_proyecto:  props.proyecto != null ? props.proyecto.estado_proyecto:null,
        siglas_proyecto:  props.proyecto != null ? props.proyecto.siglas_proyecto:null,
        alcance:  props.proyecto != null ? props.proyecto.alcance:null,
        nombre_buque:  props.proyecto != null ? props.proyecto.nombre_buque:null,
    });

    var displayModal =  ref(false);
    
    const { validate } = usePreValidate(form, {
        method: "post",
        url: route("proyectos.store"),
    });


    const props =  defineProps({
        clases: Array,
        contratos: Array,
        doubling: Boolean,
        proyecto: Object
    });
    

    const submit = () => {
        if(props.proyecto != null && !props.doubling){
            form.put(route('proyectos.update', props.proyecto.id),{
            onSuccess: () => {
                
               // Inertia.get(route('equipos.index'))
            }
        })
        return
        }
        form.post(route('proyectos.store'),{
            onSuccess: () => {
                let urlPrev = usePage().props.value.urlPrev
                if (urlPrev !== 'empty') {
                    Inertia.visit(urlPrev)
                }
            
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
                        
                        <BackButton />
                        <span class="text-2xl text-blue-400 mt-1 font-bold capitalize mx-2">{{ props.proyecto == null ? 'crear':(props.doubling ? 'Duplicar':'editar') }} Proyecto</span>
                        
                        <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar"/>
                      
                    </div> 
                    <form @focusout="validate" @submit.prevent="submit" class="pb-4">
                        <div class="grid md:grid-cols-3 grid-cols-1 my-2 gap-6 px-6">

                            <TextInput label="Numero de Casco" :error="form.errors.casco" v-model="form.casco" sugerencia="Escriba el numero del Casco"></TextInput>

                            <TextInput label="Nombre del proyecto" v-model="form.name" :error="form.errors.name" sugerencia="Escriba el nombre del proyecto"></TextInput>
                           
                            <TextInput label="Siglas" v-model="form.siglas_proyecto" :error="form.errors.siglas_proyecto" sugerencia="Escriba las Siglas del proyecto"></TextInput>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <div class="flex justify-between">
                                    <span>Clase de Buque</span>
                                    <Link :href="route('clases.create')" class="cursor-pointer text-indigo-400">+ Nueva</Link>
                                </div>
                                <Dropdown v-model="form.clase_id" :filter="true" :options="props.clases" optionValue="id" optionLabel="name" placeholder="Seleccione una Clase" />
                            </div>
                            
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Contrato</span>
                                <Dropdown v-model="form.contrato_id" :filter="true" optionLabel="contrato_id" optionValue="id" :options="props.contratos" placeholder="Seleccione un Contrato" />
                            </div>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Tipo de Proyecto</span>
                                <Dropdown v-model="form.tipo_proyecto"  :options="['PROYECTO DE VENTA', 'PROYECTO DE INVERSION INTERNA', 'PROYECTO DE INVERSIÓN DE BUQUE']" placeholder="Seleccione un tipo de proyecto" />
                            </div>
                            
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <label for="icon">Codigo SAP</label>
                                <InputMask v-model="form.codigo_SAP" mask="a-99-9999" placeholder="Escriba un codigo de SAP" />
                            </div>

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Estado del Proyecto</span>
                                <Dropdown v-model="form.estado_proyecto" :options="['DISEÑO Y CONSTRUCCIÓN','CONSTRUCCIÓN', 'DISEÑO', 'GARANTIA', 'SERVICIO POSTVENTA']" placeholder="Seleccione un estado" />
                            </div>
                          
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Alcance del proyecto</span>
                                <Dropdown v-model="form.alcance"  :options="['ADQUISICÓN Y ENTREGA', 'CO DESARROLL DISEÑO Y CONSTRUCCIÓN', 'CO PRODUCCIÓN', 'CONSTRUCCIÓN', 'DISEÑO BUQUE', 'DISEÑO Y CONSTRUCCIÓN', 'SERVICIOS INDUSTRIALES']" placeholder="Seleccione un alcance" />
                            </div>

                            <TextInput label="Nombre del Buque" v-model="form.nombre_buque" sugerencia="Escriba el nombre del proyecto"></TextInput>
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