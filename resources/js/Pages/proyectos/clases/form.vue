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


    var form = useForm({
        name: null,
        type: null,
        empresa_diseñadora: null,
        material_casco: null,
        eslora: null,
        manga: null,
        calado_diseño: null,
        puntal: null,
        full_load: null,
        light_ship: null,
        potencia_total_kw: null,
        tipo_propulsion: null,
        autonomias: null,
        alcance: null,
        tripulacion_maxima: null,
        velocidad: null,
        GT: null,
        CGT: null,
        render: null,
        bollard_pull: null,
        clasificacion: null,
        construido: null,
        imagen: null,
    });

    const displayModal =  ref(false);
    
    // const { validate } = usePreValidate(form, {
    //     method: "post",
    //     url: route("equipos.store"),
    //     });


    const props = defineProps({
        
    });
    

    const submit = () => {
        form.post(route('clases.store'),{
            onSuccess: () => {
                alert('Holaa')
               // Inertia.get(route('equipos.index'))
            }
        })
    }
    /* End functions */ 
</script>

<template>
    <AppLayout>
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-auto">
                    <div class="flex justify-between mx-auto p-4 space-x-2">
                        <div>
                        <Link type="button" :href="route('clases.index')">
                            <Button icon="pi pi-chevron-left" class=" p-button-info p-button-sm" />
                        </Link>
                        <span class="text-2xl text-blue-400 mt-1 font-bold ">Crear Clase</span>
                        </div>
                        <Button icon="pi pi-upload" class=" p-button-success  p-button-sm" @click="displayModal = true" label="Importar"/>
                      
                    </div> 
                    <form @focusout="validate" @submit.prevent="submit" class="pb-4">
                        <div class="grid md:grid-cols-3 grid-cols-1 my-2 gap-6 px-6">
                            <TextInput label="Nombre" v-model="form.name" sugerencia="Escriba el nombre de la clase"></TextInput>

                            <TextInput label="Tipo de buque" v-model="form.type" sugerencia="Escriba el tipo de buque"></TextInput>

                            <TextInput label="Empresa Diseñadora" v-model="form.empresa_diseñadora" sugerencia="Escriba el nombre de la empresa diseñadora"></TextInput>    

                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Material Casco</span>
                                <Dropdown v-model="form.material_casco" :editable="true" :options="['ACERO', 'ALUMINIO', 'MATERIALES COMPUESTOS']" placeholder="Seleccione o escriba el material del casco" />
                            </div>

                            <NumberInput label="Eslora" v-model="form.eslora" sugerencia="Escriba el Valor de la Eslora" suffix=" m"></NumberInput>

                            <NumberInput label="Manga" v-model="form.manga" sugerencia="Escriba el Valor de la Manga" suffix=" m"></NumberInput>
                            <NumberInput label="Calado de Diseño" v-model="form.calado_diseño" sugerencia="Escriba el Valor del Calado de diseño"></NumberInput> 

                            <NumberInput label="Puntal" v-model="form.puntal" sugerencia="Escriba el Valor del puntal"></NumberInput> 

                            <NumberInput label="Full Load" v-model="form.full_load" sugerencia="Escriba el Valor del Full Load"></NumberInput>

                            <NumberInput label="Ligth Ship" v-model="form.light_ship" sugerencia="Escriba el Valor del Ligth Ship" suffix=" Ton"></NumberInput> 

                            <NumberInput label="Potencia" v-model="form.potencia_total_kw" sugerencia="Escriba el Valor de la potencia" suffix=" Kw"></NumberInput> 
                        
                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                <span>Tipo de Propulsión</span>
                                <Dropdown v-model="form.tipo_propulsion" :options="['AZUMITAL', 'CONVENCIONAL', 'MOTOR FUERA DE BORDA', 'PUMP JET', 'RUDDER PROPELLER', 'WATER JET']" placeholder="Seleccione un tipo de propulsion" />
                            </div>   

                            <NumberInput label="Velocidad Maxima" v-model="form.velocidad" sugerencia="Escriba el Valor de la Velocidad Maxima" suffix=" Km/h"></NumberInput> 

                            <NumberInput label="Autonomía" v-model="form.autonomias" sugerencia="Escriba el Valor de la autonomía" suffix=" días"></NumberInput> 

                            <NumberInput label="Alcance" v-model="form.alcance" sugerencia="Escriba el Valor del alcance" suffix=" mi"></NumberInput> 
                            
                            <NumberInput label="Tripulación Maxima" v-model="form.tripulacion_maxima" sugerencia="Escriba el Valor de la Tripulación" ></NumberInput> 

                            <NumberInput label="GT" v-model="form.GT" sugerencia="Escriba el GT" ></NumberInput> 
                            
                            <NumberInput label="CGT" v-model="form.CGT" sugerencia="Escriba el CGT" ></NumberInput> 

                            <NumberInput label="Bollard pull" v-model="form.bollard_pull" sugerencia="Escriba el Valor de la Tripulación" ></NumberInput> 

                            <TextInput label="Clasificacion" v-model="form.clasificacion" sugerencia="Escriba la Clasificación"></TextInput>   

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
        <Dialog header="Carga Masiva" position="topright" v-model:visible="displayModal" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
            <form @submit.prevent="submit">
                <FileUpload name="files[]" :url="route('clases.upload')" @upload="onAdvancedUpload($event)" :multiple="true" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
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