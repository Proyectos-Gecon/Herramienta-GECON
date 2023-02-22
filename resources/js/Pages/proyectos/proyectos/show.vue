<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Panel from 'primevue/panel';
import ProgressBar from 'primevue/progressbar';
import BackButton from '@/Components/customs/BackButton.vue';
import GaugeChart from '@/Components/customs/GaugeChart.vue';
import CurvaS from '@/Components/customs/CurvaS.vue'


const props = defineProps({
    proyecto: Object,
    avance: Array,
    avance_actual: Object
})



</script>

<template>
    <AppLayout title="Proyecto">
        <div class="fixed z-30 rounded-full top-20 right-2 p-2 ">
            <BackButton></BackButton>
        </div>
        <main>
            <div
            class="relative pt-16 pb-32 flex content-center items-center justify-center"
            style="min-height: 75vh;"
            >
            <div
                class="absolute top-0 w-full h-full bg-center bg-cover"
                style='background-image: url("https://www.cotecmar.com/sites/default/files/media/imagenes/2022-03/BICM_BANNER.jpg");'
            >
                <span
                id="blackOverlay"
                class="w-full h-full absolute opacity-75 bg-black"
                ></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                    <div class="pr-12">
                    <h1 class="text-white font-semibold text-5xl">
                        {{ props.proyecto.name }}  {{ props.proyecto.siglas_proyecto != null ? '/'+props.proyecto.siglas_proyecto:'' }}
                    </h1>
                    <p class="mt-4 text-lg text-gray-300">
                       {{ props.proyecto.observacions }}
                    </p>
                    </div>
                </div>
                </div>
            </div>
            <div
                class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
                style="height: 70px;"
            >
                <svg
                class="absolute bottom-0 overflow-hidden"
                xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="none"
                version="1.1"
                viewBox="0 0 2560 100"
                x="0"
                y="0"
                >
                <polygon
                    class="text-gray-300 fill-current"
                    points="2560 0 2560 100 0 100"
                ></polygon>
                </svg>
            </div>
            </div>
            <section class="pb-20 bg-gray-300 -mt-24">
            <div class="container mx-auto px-4" >
                <div class="flex flex-wrap" >
                <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center" v-if="props.proyecto.contrato_id != null">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                    <div class="px-4 py-5 flex-auto">
                        <h6 class="text-xl font-bold">Contrato</h6>
                        <p class="mt-2 mb-4 text-gray-600 font-semibold">
                        {{ props.proyecto.contrato.contrato_id }}
                        </p>
                        <p class="mt-2 mb-4 text-gray-600">
                            $ {{ props.proyecto.contrato.precio_venta }} Millones
                        </p>
                    </div>
                    </div>
                </div>
                <div class="w-full md:w-4/12 px-4 text-center" v-if="props.proyecto.clase_id != null">
                    <div
                    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
                    >
                    <div class="px-4 py-5 flex-auto">

                        <h6 class="text-xl font-bold">Clase</h6>
                        <p class="mt-2 mb-4 text-gray-600 font-semibold">
                            {{ props.proyecto.clase.name }}
                        </p>
                        <p class="mt-2 mb-4 text-gray-600">
                            {{ props.proyecto.clase.type }}
                        </p>
                      
                    </div>
                    </div>
                </div>
                    <div class="pt-6 w-full md:w-4/12 px-4 text-center" v-if="props.proyecto.contrato_id != null">
                        <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg"
                        >
                        <div class="px-4 py-5 flex-auto">
                        
                            <h6 class="text-xl font-bold">Cliente</h6>
                            <p class="mt-2 mb-4 text-gray-600 font-semibold">
                                {{  props.proyecto.contrato.cliente != null ? props.proyecto.contrato.cliente.nombre_cliente :''}}
                            </p>
                            <p class="mt-2 mb-4 text-gray-600">
                                {{ props.proyecto.contrato.cliente.pais }}
                            </p>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mt-12 py-12">
                    <div class="w-full md:w-6/12 px-4 mr-auto ml-auto space-y-2 mb-10">
                        <div
                        class="text-gray-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-gray-100"
                        >
                        <i class="fas fa-info text-xl"></i>
                        </div>
                        <h3 class="text-3xl font-semibold leading-normal">
                        Caracteristicas
                        </h3>
                    
                        <Panel header="Dimensiones" :toggleable="true">
                            <template #icons>
                                <button class="p-panel-header-icon p-link mr-2" @click="toggle">
                                </button>
                            
                            </template>
                            <p  v-if="props.proyecto.clase_id != null">
                                <table class="min-w-full text-center">
                                    <tbody>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Eslora total
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.eslora }} m
                                        </td>
                                    
                                        </tr>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Puntal: 
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.puntal }} m
                                        </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Manga:
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.manga }} m
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </p>
                        </Panel>
                        <Panel header="Desempeño" :toggleable="true">
                            <template #icons>
                                <button class="p-panel-header-icon p-link mr-2" @click="toggle">
                                </button>
                            
                            </template>
                            <p  v-if="props.proyecto.clase_id != null">
                                <table class="min-w-full text-center">
                                    <tbody>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Velocidad Maxima
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.velocidad }} nudos
                                        </td>
                                    
                                        </tr>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Alcance: 
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.alcance }} millas
                                        </td>
                                        </tr>
                                        <tr class="bg-white border-b">
                                        
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            Autonomía:
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ props.proyecto.clase.autonomias }} días
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </p>
                        </Panel>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <div
                        class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blue-500"
                        >
                        <img
                            alt="..."
                            src="https://source.unsplash.com/random/800x400?ship,contract"
                            class="w-full align-middle rounded-t-lg"
                        />
                        <blockquote class="relative p-8 mb-4">
                            <svg
                            preserveAspectRatio="none"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 583 95"
                            class="absolute left-0 w-full block"
                            style="height: 95px; top: -94px;"
                            >
                            <polygon
                                points="-30,95 583,95 583,65"
                                class="text-blue-500 fill-current"
                            ></polygon>
                            </svg>
                            <h4 class="text-xl font-bold text-white">
                                
                            </h4>
                            <p class="text-md font-light mt-2 text-white uppercase" v-if="props.proyecto.contrato_id != null">
                                {{ props.proyecto.contrato.objeto }}
                            </p>
                        </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            </section>

            <section class="relative p-8 bg-white" v-if="props.avance.length > 0">
            <div class="text-center">
                <h3 class="text-3xl font-semibold leading-normal">
                        Estado del Proyeto
                </h3>
            </div>
            <div class="bg-white">
                <div class="mx-2 py-2 grid grid-cols-5 gap-4 mb-2">
                <div class="bg-white rounded-xl shadow-xl shadow-slate-400 text-center p-4">
                    <h5>Semana de Reporte</h5>
                    <h5>WK - {{props.avance_actual.semana_format}}</h5>
                    
                </div>
                <div class="bg-bray-200 rounded-xl shadow-xl text-blue-500 text-xl shadow-slate-400 text-center pt-4">
                    <h5>Avance Planeado</h5>
                    <h5>{{props.avance_actual.avance_planeado}} %</h5>
                    <div class="w-full rounded-b-full bg-gray-400 h-2 mt-2">
                    <div class="bg-blue-500 rounded-b-full h-2 text-sm align-self-center font-medium opacity-60 text-blue-100 text-center p-0.5 leading-none " style="width: {{props.avance_actual.avance_planeado}}%"></div>
                    </div>
                </div>
                <div class="bg-bray-200 rounded-xl shadow-xl text-teal-500 text-xl shadow-slate-400 text-center pt-4">
                    <h5>Avance Real</h5>
                    <h5>{{props.avance[0].avance_real *100}} %</h5>
                    <div class="w-full rounded-b-full bg-gray-400 h-2 mt-2">
                    <div class="bg-teal-500 rounded-b-full h-2 text-sm align-self-center font-medium opacity-60 text-blue-100 text-center p-0.5 leading-none " style="width: {{props.avance_actual.avance_real *100}}%"></div>
                    </div>
                </div>
               
                <div class="bg-green-100 rounded-xl shadow-xl shadow-slate-400 text-center p-4">
                    <h5>CPI</h5>
                    <h5>{{props.avance_actual.CPI}}</h5>
                </div>
                <div class="bg-green-100 rounded-xl shadow-xl shadow-slate-400 text-center p-4">
                    <h5>SPI</h5>
                    <h5>{{props.avance_actual.SPI}}</h5>
                </div>
            </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mx-5">
                    
                    <GaugeChart :value="props.avance_actual.CPI" title="CPI"></GaugeChart>
                    <GaugeChart :value="props.avance_actual.SPI" title="SPI"></GaugeChart>
                    <div class="mt-12">
                        <div class="bg-bray-200 rounded-xl shadow-xl text-teal-500 text-xl shadow-slate-400 text-center pt-4">
                        <h5>Materiales</h5>
                        <div class="fexl justify-between">
                            <span>
                                {{ props.proyecto.costo_materiales_presupuesto }}
                            </span>
                        </div>
                        <div class="w-full rounded-b-full bg-gray-400 h-2 mt-2">
                        <div class="bg-teal-500 rounded-b-full h-2 text-sm align-self-center font-medium opacity-60 text-blue-100 text-center p-0.5 leading-none " style="width: {{props.avance[0].avance_real *100}}%"></div>
                        </div>
                    </div>
                    </div>
                    <div class="col-span-3">
                         <CurvaS :proyecto="props.avance[0].proyecto_id"></CurvaS>
                    </div>
                   
                </div>
            </div>
            
            </section>
           
            
            
        </main>
    </AppLayout>
  </template>