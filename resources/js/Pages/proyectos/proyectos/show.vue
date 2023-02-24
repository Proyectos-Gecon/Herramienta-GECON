<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Panel from 'primevue/panel';
import ProgressBar from 'primevue/progressbar';
import BackButton from '@/Components/customs/BackButton.vue';
<<<<<<< HEAD
import GaugeChart from '@/Components/customs/GaugeChart.vue';
import CurvaS from '@/Components/customs/CurvaS.vue'


const props = defineProps({
    proyecto: Object,
    avance: Array,
    avance_actual: Object
=======


const value1 = ref(100);

const props = defineProps({
    proyecto: Object
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
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
<<<<<<< HEAD
                       {{ props.proyecto.observacions }}
=======
                        This is a simple example of a Landing Page you can build using
                        Tailwind Starter Kit. It features multiple CSS components
                        based on the Tailwindcss design system.
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
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
<<<<<<< HEAD
                                {{  props.proyecto.contrato.cliente != null ? props.proyecto.contrato.cliente.nombre_cliente :''}}
=======
                                {{ props.proyecto.contrato.cliente.nombre_cliente }}
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
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
<<<<<<< HEAD

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
=======
            <section class="relative py-2">
            <div
                class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;"
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
                    class="text-gray-100 fill-current"
                    points="2560 0 2560 100 0 100"
                ></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4 -mt-12 py-36">
                <div class="items-center flex flex-wrap">
                <div class="w-full md:w-4/12 ml-auto mr-auto px-4 z-20">
                    <img
                    alt="..."
                    class="max-w-full rounded-lg shadow-lg"
                    src="https://source.unsplash.com/random/800x800?estadisticas"
                    />
                </div>
                <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                    <div class="md:pr-12">
                    <div class="text-indigo-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-white"
                    >
                        <i class="fas fa-ship text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-semibold">Estados del proyecto</h3>
                    
                    <ul class="list-none mt-6">
                        <li class="py-2 text-lg text-gray-500">
                            <div class="p-fluid p-input-filled">
                                <div class="flex justify-between">
                                    <h5>Ingenieria</h5>
                                    <h5>100%</h5>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-5">
                                <div class="bg-blue-600 h-6 text-sm align-self-center font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 100%"> </div>
                                </div>
                            </div>
                        </li>
                        <li class="py-2 text-lg text-gray-500">
                            <div class="p-fluid p-input-filled">
                                <div class="flex justify-between">
                                    <h5>Ingenieria de Taller</h5>
                                    <h5>50%</h5>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-5">
                                <div class="bg-green-600 h-6 text-sm align-self-center font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                        </li>
                        <li class="py-2 text-lg text-gray-500">
                            <div class="p-fluid p-input-filled">
                                <div class="flex justify-between">
                                    <h5>Costrucción</h5>
                                    <h5>80%</h5>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-5">
                                <div class="bg-gray-600 h-6 text-sm align-self-center font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
                </div>
            </div>
            </section>
           
            <section class="pb-20 relative block bg-gray-900">
            <div
                class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;"
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
                    class="text-gray-900 fill-current"
                    points="2560 0 2560 100 0 100"
                ></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-24">
                <div class="w-full lg:w-6/12 px-4">
                    <h2 class="text-4xl font-semibold text-gray-50">Nuestro Equipo</h2>
                    <p class="text-lg leading-relaxed m-4 text-white">
                        Detras de cada proyecto esta una muestra de la calidad humana de nuestros colaboradores
                    </p>
                </div>
                </div>
                <div class="flex flex-wrap">
                <div class="w-full md:w-6/12 lg:w-6/12 lg:mb-0 mb-12 px-4">
                    <div class="px-6">
                    <!-- <img
                        alt="..."
                        src="../assets/img/team-1-800x800.jpg"
                        class="shadow-lg rounded-full max-w-full mx-auto"
                        style="max-width: 120px;"
                    /> -->
                    <div class="pt-2 text-center">
                        <h5 class="text-2xl font-bold text-white"  v-if="props.proyecto.contrato_id != null">{{ props.proyecto.contrato.gerente }}</h5>
                        <p class="mt-1 text-sm text-gray-100 uppercase font-semibold">
                        Gerente de Proyecto
                        </p>
                        
                    </div>
                    </div>
                </div>
                <div class="w-full md:w-6/12 lg:w-6/12 lg:mb-0 mb-12 px-4">
                    <div class="px-6">
                    <!-- <img
                        alt="..."
                        src="../assets/img/team-2-800x800.jpg"
                        class="shadow-lg rounded-full max-w-full mx-auto"
                        style="max-width: 120px;"
                    /> -->
                    <div class="pt-2 text-center">
                        <h5 class="text-2xl font-bold text-white"  v-if="props.proyecto.contrato_id != null">{{ props.proyecto.contrato.supervisor }}</h5>
                        <p class="mt-1 text-sm text-gray-100 uppercase font-semibold">
                       Supervisor del proyecto
                        </p>
                        <!-- <div class="mt-6">
                        <button
                            class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-google"></i></button
                        ><button
                            class="bg-blue-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        </div> -->
                    </div>
                    </div>
                </div>
                <!-- <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                    <div class="px-6">
                    <img
                        alt="..."
                        src="../assets/img/team-3-800x800.jpg"
                        class="shadow-lg rounded-full max-w-full mx-auto"
                        style="max-width: 120px;"
                    /> 
                    <div class="pt-6 text-center">
                        <h5 class="text-xl font-bold">Alexa Smith</h5>
                        <p class="mt-1 text-sm text-gray-500 uppercase font-semibold">
                        UI/UX Designer
                        </p>
                        <div class="mt-6">
                        <button
                            class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-google"></i></button
                        ><button
                            class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-twitter"></i></button
                        ><button
                            class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-instagram"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div> -->
                <!-- <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                    <div class="px-6">
                  
                    <div class="pt-6 text-center">
                        <h5 class="text-xl font-bold">Jenna Kardi</h5>
                        <p class="mt-1 text-sm text-gray-500 uppercase font-semibold">
                        Founder and CEO
                        </p>
                        <div class="mt-6">
                        <button
                            class="bg-pink-500 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-dribbble"></i></button
                        ><button
                            class="bg-red-600 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-google"></i></button
                        ><button
                            class="bg-blue-400 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-twitter"></i></button
                        ><button
                            class="bg-gray-800 text-white w-8 h-8 rounded-full outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                        >
                            <i class="fab fa-instagram"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div> -->
                </div>
            </div>
            </section>
            
>>>>>>> f82e0c238973723076e229fc0475b03f794db4ac
        </main>
    </AppLayout>
  </template>