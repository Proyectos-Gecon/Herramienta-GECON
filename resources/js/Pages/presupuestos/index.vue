<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTableCustom from "@/Components/customs/DataTableCustom";
import Dropdown from 'primevue/dropdown';
import { useForm } from '@inertiajs/inertia-vue3';
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';
import Button from 'primevue/button';

const props = defineProps({
    proyectos: Array
})

const displayModal = ref(false)
const form = useForm({
    proyecto: null,
})
</script>
<template>
    <AppLayout title="Divisiones">
        <div class="py-4">
            <div class="w-full mx-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-4 overflow-x-auto">
                    <div class="flex justify-between mx-4">
                        <Dropdown v-model="form.proyecto" :filter="true" optionLabel="name" optionValue="id" :options="props.proyectos" placeholder="Seleccione un proyecto" />
                        <Button icon="pi pi-upload" class="p-button-success  p-button-sm" v-if="form.proyecto != null" @click="displayModal = true" label="Importar Avance"/>
                    </div>
                    <table class="w-full divide-y mt-4 divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Actividad
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Grafo
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Avance
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                 presupuestados Materiales
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                 Ejecutados Materiales
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Presupuesto MDO
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Ejecutado MDO
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Presupuesto Servicios
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Ejecutados Servicios
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                PRESUPUESTO TOTAL 
                            </th>
                            <th scope="col"
                                class="px-2 py-3 bg-gray-200 text-center text-xs font-blod text-black uppercase tracking-wider">
                                Ejecutado TOTAL 
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-1 font-extrabold whitespace-normal">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-md font-extrabold text-gray-900">
                                               fsdfasdf
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-1 font-extraboldtext-center whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-md text-cnter font-extrabold text-gray-900">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-1 font-extraboldtext-center whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-md text-cnter font-extrabold text-gray-900">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-1 font-extraboldtext-center whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-md text-cnter font-extrabold text-gray-900">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-1 font-extraboldtext-center whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4">
                                            <div class="text-md text-cnter font-extrabold text-gray-900">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                                <tr>
                                    <td class="px-4 py-1 font-extrabold whitespace-normal">
                                        <div class="flex items-center">

                                            <div class="ml-4">
                                                <div class="text-md font-bold  text-gray-700">
                                                  sdfsf
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-1 font-bold text-center whitespace-nowrap">
                                        <div class="flex items-center">

                                            <div class="ml-4">
                                                <div class="text-md text-cnter font-bold  text-gray-700">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-1 font-bold text-center whitespace-nowrap">
                                        <div class="flex items-center">

                                            <div class="ml-4">
                                                <div class="text-md text-cnter font-bold  text-gray-700">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-1 font-bold text-center7whitespace-nowrap">
                                        <div class="flex items-center">

                                            <div class="ml-4">
                                                <div class="text-md text-cnter font-bold  text-gray-700">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-1 font-bold text-center7whitespace-nowrap">
                                        <div class="flex items-center">

                                            <div class="ml-4">
                                                <div class="text-md text-center font-bold  text-gray-700">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                           
                                    <tr>
                                        <td class="px-4 py-1 font-extrabold whitespace-normal">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md font-medium  text-gray-900">
                                                     dfsdf
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        $
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-center font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                        <tr>
                                            <td class="px-4 py-1 font-extrabold whitespace-normal">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md font-medium  text-gray-900">
                                                          sfsfd
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            $
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-center font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                  
                                    <tr>
                                        <td class="px-4 py-1 font-extrabold whitespace-normal">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md font-medium  text-gray-900">
                                                      fghfgh
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        $
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-cnter font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                            <div class="flex items-center">

                                                <div class="ml-4">
                                                    <div class="text-md text-center font-medium  text-gray-900">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                  
                                        <tr>
                                            <td class="px-4 py-1 font-extrabold whitespace-normal">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            $
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-cnter font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                <div class="flex items-center">

                                                    <div class="ml-4">
                                                        <div class="text-md text-center font-medium  text-gray-900">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                     
                                            <tr>
                                                <td class="px-4 py-1 font-extrabold whitespace-normal">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-md font-medium  text-gray-900">
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-md text-cnter font-medium  text-gray-900">
                                                                $
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-md text-cnter font-medium  text-gray-900">
                                                                $
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-md text-cnter font-medium  text-gray-900">
                                                                $
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-1 font-medium text-center whitespace-nowrap">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div
                                                                class="text-md text-center font-medium  text-gray-900">
                                                                $
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Dialog header="Cargar Costo Ejecutado" position="topright" v-model:visible="displayModal" :withCredentials="true" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :modal="true">
                    <form class="space-y-3" action="#"  @submit.prevent="cargarAvance" enctype="multipart/form-data">
                        <FileUpload name="file" :url="route('avance.upload', form.proyecto)" @upload="onAdvancedUpload($event)" :multiple="false" accept=".xml,.xlsx,.csv" :maxFileSize="1000000">
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