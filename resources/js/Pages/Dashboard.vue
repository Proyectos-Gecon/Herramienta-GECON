<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import Welcome from '@/Components/Welcome.vue';
import Chart from 'primevue/chart';
import Message from 'primevue/message';
import { permisos } from '@/composable/Permisions.js'
import SplitButton from 'primevue/splitbutton';
import Barras from '@/charts/Barras.vue'
import CardMedium from '@/Components/customs/CardMedium.vue';
import ResumenPersonal from '@/Components/customs/ResumenPersonal.vue';
const can = (array) => {
    
    var {val} = permisos(array)
    return val
}
const fecha = (fecha) => {
   
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
const formatter = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'USD',
  // These options are needed to round to whole numbers if that's what you want.
  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
  maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});


const props  = defineProps({
    labesDivision: Array,
    noPresentesDivision: Array,
    presentesDivision: Array,
    usersContratosPorTerminar: Array,
    totalPresentes: Number,
    totalNoPresentes: Number,
    fecha: Date,
    absentismos: Array,
    proyectos: Array,
    divisiones: Array,
    noRegistrados: Number,
    costoMes: Array
})
const initialValue = 0;

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

let presentes = []
let noPresentes = []

for (var f in props.noPresentesDivision) {
  presentes.push( props.presentesDivision[f])
  noPresentes.push(props.noPresentesDivision[f])
}

const series = [
{
        name: 'No Presentes',
        data: noPresentes
    }
,{
        name: 'Presentes',
        data: presentes
    }
]

</script>
<template>
    <AppLayout title="Dashboard">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
                            <ul
                            class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
                            >
                            <li>
                                <span class="text-500 no-underline line-height-3"
                                >{{ props.fecha }}</span>
                            </li>
                            </ul>
                            <div class="flex align-items-start justify-between">
                            <div>
                                <div class="font-medium text-3xl text-900">{{$page.props.user.name}}</div>
                                <div class="flex align-items-center text-700 flex-wrap">
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="fa fa-ship mr-2"></i> {{ props.proyectos.length }} Proyectos en construcci??n
                                 
                                </div>
                          
                                </div>
                            </div>
                            <div class="mt-3 lg:mt-0 space-x-2">
                                <SplitButton label="GECON" class="p-button-raised p-button-text p-button-info mb-2" :model="items"></SplitButton>
                            </div>
                            </div>
                        </div>
                   <span v-if="$page.props.user.roles.length == 0">
                    <Message severity="warn" :closable="false">Espere hasta que le Asignemos un ROL</Message>
                   </span>
               
                   <div class=" grid grid-cols-1 md:grid-cols-3 gap-6 px-2" v-if="can(['read activos'])">

                    <ResumenPersonal :fecha="props.fecha" class="col-span-3"></ResumenPersonal>

                    <Barras :stacked="true" :horizontal="false" :series="series" :categories="props.labesDivision"></Barras>
                                         
                    <div class="text-center font-bold text-xl space-y-4">
                        <div class="overflow-auto max-h-96 text-center text-sm">
                            <h1 class="font-bold font-roboto text-xl">Contratos a t??rmino fijo a vencer</h1>
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
                    <div class="text-center font-bold text-xl py-2 space-y-4 border border-blue-200 rounded-lg">
                        <div class="overflow-auto max-h-96 text-center text-sm">
                            <h1 class="font-bold font-roboto text-xl">Costos por divisi??n</h1>
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-900 mt-2 overflow-y-auto">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Divisi??n</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                           Parte</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Costo Mes</th>
                                        <th
                                            class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-sm whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                            Costo A??o</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="division in props.divisiones" :key="division.division" >
                                    
                                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                <h6 class="mb-0 leading-normal text-size-sm">{{division.division}}</h6>
                                            </td>

                                            <td
                                                class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap">
                                                <span class="font-semibold leading-tight text-size-xs">{{ division.cantidad }}</span>
                                            </td>
                                            <td
                                                class="p-2 leading-normal text-center align-middle bg-transparent border-b text-size-sm whitespace-nowrap">
                                                <span class="font-semibold leading-tight text-size-xs"> {{ formatter.format((division.sum_salarios *1.6)/1000000) }} M</span>
                                            </td>
                                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                                <div class="w-3/4 mx-auto">
                                                        <span class="font-semibold leading-tight text-size-xs"> {{formatter.format(((division.sum_salarios *1.6)/1000000)*12) }}M</span>
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
        
    </AppLayout>
</template>
