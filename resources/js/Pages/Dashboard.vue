<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import Welcome from '@/Components/Welcome.vue';
import Chart from 'primevue/chart';
import Message from 'primevue/message';
import { permisos } from '@/composable/Permisions.js'
import SplitButton from 'primevue/splitbutton';


const can = (array) => {
    
    var {val} = permisos(array)
    return val
}
const fecha = (fecha) => {
    console.log(fecha);

   return (fecha.substring(0,4)+'-'+fecha.substring(4,6)+'-'+fecha.substring(6,8))
    var fechaFin    = new Date().getTime();
    var diff = fechaFin - new Date(fecha.substring(0,4)+'-'+fecha.substring(4,6)+'-'+fecha.substring(6,8)).getTime();
    return diff/(1000*60*60*24);
}
const items=  [
				{
					label: 'Update',
					icon: 'pi pi-refresh',
					command: () => {
						this.$toast.add({severity:'success', summary:'Updated', detail:'Data Updated', life: 3000});
					}
				},
		]

const props  = defineProps({
    labesDivision: Array,
    noPresentesDivision: Array,
    presentesDivision: Array,
    PresentesArea: Array,
    noPresenteArea: Array,
    usersContratosPorTerminar: Array
})
const basicData = {
    labels: props.labesDivision,
    datasets: [
    {
            label: 'Presentes',
            data: props.presentesDivision,
            backgroundColor: '#ADCD33'
        }
        ,{
            label: 'No presentes',
            data: props.noPresentesDivision,
            backgroundColor: '#E83D3D'
        }
        
    ]
}

const dataArea =  {
  
    datasets: [
        {
            label: 'Presentes',
            data: props.PresentesArea,
            
        },
        {
            label: 'no Presentes',
            data: props.noPresenteArea
        }
    ]
}

const options= {
	responsive: true,
	hoverMode: 'index',
    plugins: {

    },
	scales: {
    y: {
        stacked: true,
        ticks: {
            color: '#495057'
        },
        grid: {
            color: '#ebedef'
        },
    
    },
    x: {
        stacked: true,
        ticks: {
            color: '#495057'
        },
        grid: {
            color: '#ebedef'
        }
    },
    
	}
}

</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
                            <ul
                            class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
                            >
                            <li>
                                <span class="text-500 no-underline line-height-3 cursor-pointer"
                                >Dashboard General</span>
                            </li>
                            </ul>
                            <div class="flex align-items-start justify-between">
                            <div>
                                <div class="font-medium text-3xl text-900">{{$page.props.user.name}}</div>
                                <!-- <div class="flex align-items-center text-700 flex-wrap">
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="fa fa-ship mr-2"></i>
                                 
                                </div>
                          
                                </div> -->
                            </div>
                            <div class="mt-3 lg:mt-0 space-x-2">
                                <SplitButton label="GECON" class="p-button-raised p-button-text p-button-info mb-2" :model="items"></SplitButton>
                            </div>
                            </div>
                        </div>
                   <span v-if="$page.props.user.roles.length == 0">
                    <Message severity="warn" :closable="false">Espere hasta que le Asignemos un ROL</Message>
                   </span>

                   <div class=" grid grid-cols-3 mt-10 gap-6" v-if="can(['read activos'])">
                    <div class="text-center font-bold text-xl space-y-4">
                        <h1>Parte Por división</h1>
                        <Chart type="bar" :data="basicData" :names="['Presentes', 'No Presentes']" :options="options"/>
                    </div>
                    
                    <div class="text-center font-bold text-xl space-y-4">
                        <h1>Parte Por Area de Trabajo</h1>
                        <Chart type="bar" :data="dataArea" />
                    </div>
                    <div class="text-center font-bold text-xl space-y-4">
                        <div class="overflow-scroll text-center text-sm">
                            <h1 class="font-bold font-roboto text-xl">Contratos a término fijo a vencer</h1>
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-900 mt-2 overflow-y-auto">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Persona</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Tipo de contrato</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Fin contrato</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Prorrogas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="user in usersContratosPorTerminar" :key="user.ID" >
                                    
                                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                <h6 class="mb-0 leading-normal text-size-sm">{{user.APELLIDOS_NOMBRES}}</h6>
                                            </td>

                                            <td
                                                class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap">
                                                <span class="font-semibold leading-tight text-size-xs">{{ user.PTEXT }}</span>
                                            </td>
                                            <td
                                                class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap">
                                                <span class="font-semibold leading-tight text-size-xs">{{ fecha(user.CTEDT) }}</span>
                                            </td>
                                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                <div class="w-3/4 mx-auto">
                                                        <span class="font-semibold leading-tight text-size-xs">{{user.CTTYP}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   </div>
                </div>
                
            </div>
        </div>
    </AppLayout>
</template>
