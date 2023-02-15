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
        proyecto: Object
    });
    
    const formAvance = useForm({
        fecha: new Date(),
        avance_real: 0,
        avance_real_costo: 0,
        costo_material: 0,
        costo_mano_obra: 0,
        costo_servicio: 0,
    })

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
                        <Button icon="pi pi-plus" class=" p-button-success  p-button-sm" @click="displayModalAvance = true" label="Avance de la Semana"/>
                        <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar Avance"/>
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
        <Dialog header="Carga de Avances Semanales" position="topright" v-model:visible="displayModal" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <div class="mx-2">
                    <form class="space-y-3" action="#"  @submit.prevent="cargarAvance">
                        <div class="grid grid-cols-1 space-y-2">
                            <div class="items-center justify-center w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Subir Archivo</label>
                                <input  @input="archivo.file = $event.target.files[0]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Archivos de Excel</p>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-full tracking-wide font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Subir
                        </button>
                        </div>
                </form>
            </div>
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