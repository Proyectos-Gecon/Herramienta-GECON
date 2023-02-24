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
    import Header from "@/Components/customs/Header.vue";

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
        supervisor: props.proyecto != null ? props.proyecto.supervisor:null,
        gerente: props.proyecto != null ? props.proyecto.gerente:null,
        observacions:  props.proyecto != null ? props.proyecto.observacions:null,
        costo_materiales_presupuesto:  props.proyecto != null ? props.proyecto.costo_materiales_presupuesto:null,
        costo_mdo_presupuesto:  props.proyecto != null ? props.proyecto.costo_mdo_presupuesto:null,
        costo_servicios_presupuesto:  props.proyecto != null ? props.proyecto.costo_servicios_presupuesto:null,
    });

    var displayModal =  ref(false);
    var displayModalAvance =  ref(false);
    
    const { validate } = usePreValidate(form, {
        method: "post",
        url: route("proyectos.store"),
    });

    const archivo = useForm({
        file: null,
        proyecto: props.proyecto != null ? props.proyecto.id:null
    })

    const props =  defineProps({
        clases: Array,
        contratos: Array,
        doubling: Boolean,
        proyecto: Object,
        gerentes: Array
    });
    
    const formAvance = useForm({
        fecha: new Date(),
        avance_real: 0,
        avance_real_costo: 0,
        costo_material: 0,
        costo_mano_obra: 0,
        costo_servicio: 0,
    })

    const urlUpload = ref(null);
    const titleModal = ref(null)
    const cargarAvance = () => {
        archivo.post(route('avanceSemanal.store'))
    }

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

    const submitAvance = () => {
        formAvance.get(route('avanceSemanal.create'))
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
                  
                    <Header :title="props.proyecto == null ? 'Crear  Proyecto':(props.doubling ? 'Duplicar  Proyecto':'Editar  Proyecto') ">
                        <div class="flex space-x-2">
                            <Button icon="pi pi-upload"   class=" p-button-help  p-button-sm" 
                            @click="displayModal = true;
                            urlUpload = 'estructura.upload';
                            titleModal = 'Importar Estructura SAP'
                            " label="Importar Estructura"/>

                            <Button icon="pi pi-upload"   class=" p-button-help  p-button-sm" 
                            @click="displayModal = true;
                            urlUpload = 'estructura.upload';
                            titleModal = 'Importar Cronograma'
                            " label="Importar Cronograma"/>

                            <Button icon="pi pi-upload"   class=" p-button-help  p-button-sm" 
                            @click="displayModal = true;
                            urlUpload = 'estructura.upload';
                            titleModal = 'Importar Presupuesto'
                            " label="Importar Presupuesto"/>
                           
                        </div>
                        
                        <div class="flex space-x-2">
                            <Button icon="pi pi-plus" class=" p-button-success  p-button-sm" @click="displayModalAvance = true" label="Avance de la Semana"/>
                            <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar Avance"/>
                        </div>
                    </Header>
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

                            <TextInput label="Supervisor" v-model="form.supervisor" sugerencia="Escriba el nombre del Supervisor"></TextInput> 
                            
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Gerente</span>
                                <Dropdown v-model="form.gerente" :filter="true" :editable="true" optionValue="APELLIDOS_NOMBRES" optionLabel="APELLIDOS_NOMBRES" :options="props.gerentes" placeholder="Seleccione o escriba el nombre del Gerente" />
                            </div>

                            <NumberInput label="Presupuesto Materiales" v-model="form.costo_materiales_presupuesto" sugerencia="Escriba el Valor del Presupuesto Materiales" suffix=" $"></NumberInput> 

                            <NumberInput label="Presupuesto Mano de Obra" v-model="form.costo_mdo_presupuesto" sugerencia="Escriba el Valor del Presupuesto Mano de Obra" suffix=" $"></NumberInput> 
                            
                            <NumberInput label="Presupuesto Servicios" v-model="form.costo_servicios_presupuesto" sugerencia="Escriba el Valor del Presupuesto Servicios" suffix=" $"></NumberInput> 
                            <div class="col-span-1 md:col-span-2">
                                <TextInput label="Descripción del Proyecto" v-model="form.observacions" :error="form.errors.siglas_proyecto" sugerencia="Escriba la descripción"></TextInput>
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
        <Dialog :header="titleModal" position="topright" v-model:visible="displayModal" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
                    <form class="space-y-3" action="#"  @submit.prevent="cargarAvance" enctype="multipart/form-data">
                        <FileUpload name="file" :url="route(urlUpload, props.proyecto.id)" @upload="onAdvancedUpload($event)" :multiple="false" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
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
        <Dialog header="Avance de la Semana" v-model:visible="displayModalAvance" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <div class="mx-2">
                    <form class="space-y-3" action="#"  @submit.prevent="submitAvance">
                        <div class="grid grid-cols-1 space-y-4">
                            <div class="p-fluid p-input-filled border-0">
                                <span class="text-lg font-semibold">Fecha</span>
                                <Calendar inputId="icon" v-model="formAvance.fecha" :showIcon="true"  :maxDate="new Date()"/>
                            </div>
                            <NumberInput label="Avance Real Esfuerzo" v-model="formAvance.avance_real" sugerencia="Digite el valor del avance Ejecutado en el formato (0.0)"></NumberInput> 

                            <NumberInput label="Avance Real Costo" v-model="formAvance.avance_real_costo" sugerencia="Digite el valor del avance Ejecutado en el formato (0.0)"></NumberInput> 

                            <NumberInput label="Costo Ejecutado Materiales" v-model="formAvance.costo_material" sugerencia="Escriba el Valor del Costo Ejecutado Materiales" suffix=" $"></NumberInput> 

                            <NumberInput label="Costo Ejecutado Mano de Obra" v-model="formAvance.costo_mano_obra" sugerencia="Escriba el Valor del Costo Ejecutado Mano de Obra" suffix=" $"></NumberInput> 
                            
                            <NumberInput label="Costo Ejecutado Servicios" v-model="formAvance.costo_servicio" sugerencia="Escriba el Valor del Costo Ejecutado Servicios" suffix=" $"></NumberInput> 
                        </div>
                        <div>
                            <button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-full tracking-wide font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Guardar
                        </button>
                        </div>
                </form>
            </div>
        </Dialog>
        
    </AppLayout>
</template>