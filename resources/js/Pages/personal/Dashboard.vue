<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "primevue/breadcrumb";
import Welcome from "@/Components/Welcome.vue";
import Chart from "primevue/chart";
import Message from "primevue/message";
import { permisos } from "@/composable/Permisions.js";
import SplitButton from "primevue/splitbutton";
import Barras from "@/charts/Barras.vue";
import CardMedium from "@/Components/customs/CardMedium.vue";
import Calendar from "primevue/calendar";
import { Inertia } from "@inertiajs/inertia";
import Divider from 'primevue/divider';
import ContratosVencer from "@/Components/ContratosVencer.vue";
import Fieldset from 'primevue/fieldset';
import ResumenPersonal from "@/Components/customs/ResumenPersonal.vue";
const can = (array) => {
  var { val } = permisos(array);
  return val;
};
const fecha = (fecha) => {
  return (
    fecha.substring(0, 4) +
    "-" +
    fecha.substring(4, 6) +
    "-" +
    fecha.substring(6, 8)
  );
  var fechaFin = new Date().getTime();
  var diff =
    fechaFin -
    new Date(
      fecha.substring(0, 4) +
        "-" +
        fecha.substring(4, 6) +
        "-" +
        fecha.substring(6, 8)
    ).getTime();
  return diff / (1000 * 60 * 60 * 24);
};

const formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD",
  // These options are needed to round to whole numbers if that's what you want.
  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
  maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

const props = defineProps({
  labesDivision: Array,
  noPresentesDivision: Array,
  presentesDivision: Array,
  totalPresentes: Number,
  totalNoPresentes: Number,
  fecha: Date,
  noRegistrados: Number,
  proyectos: Array,
  absentismos: Array,
  divsiones: Array,
  tipoContratos: Array
});

const fechaDashboard = ref(props.fecha);

const selectFecha = () => {
  Inertia.get(
    route("personal.dashboard", {
      fecha: fechaDashboard,
    })
  );
};

let presentes = [];
let noPresentes = [];
let AbsentismosLabel = props.absentismos.map(function (obj) {
  return obj.estado;
});
let AbsentismosCount = props.absentismos.map(function (obj) {
  return obj.cantidad;
});

for (var f in props.noPresentesDivision) {
  presentes.push(props.presentesDivision[f]);
  noPresentes.push(props.noPresentesDivision[f]);
}

const series = [
  {
    name: "No Presentes",
    data: noPresentes,
  },
  {
    name: "Presentes",
    data: presentes,
  },
];

const initialValue = 0;
const countPersonal = props.divsiones.reduce(
  (accumulator, currentValue) => accumulator + parseInt(currentValue.cantidad),
  initialValue
);
</script>
<template>
  <AppLayout title="Dashboard">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-4">
        <div class="surface-section w-full px-4 py-5 md:px-6 lg:px-8">
          <ul
            class="list-none p-0 m-0 flex align-items-center font-medium mb-3"
          >
            <li>
              <span class="text-500 no-underline line-height-3">{{
                props.fecha
              }}</span>
            </li>
          </ul>
          <div class="flex align-items-start justify-between">
            <div>
              <div class="font-medium text-3xl text-900">
                Dashboard Personal
              </div>
            </div>
            <div class="mt-3 lg:mt-0 space-x-2">
              <Calendar
                inputId="icon"
                :maxDate="new Date()"
                v-model="fechaDashboard"
                dateFormat="mm-dd-yy"
                :showIcon="true"
                v-on:date-select="selectFecha"
                placeholder="Seleccione una fecha"
              />
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-4">
          
          <ResumenPersonal :fecha="fechaDashboard" class="col-span-3"></ResumenPersonal>
          <div
            class="
              grid grid-cols-1
              md:grid-cols-2
              border
              border-gray-400
              rounded-2xl
              shadow-lg
              max-h-80
              px-4
              pt-1
              md:px-8
              overflow-y-auto
              gap-2
              col-span-1
              md:col-span-2
            "
          >
            <div
              class="p-1 hover:scale-105 duration-500"
              v-on:click="alert(proyecto.casco)"
              v-for="proyecto in props.proyectos"
              :key="proyecto.proyecto"
            >
              <div
                class="
                  flex
                  items-center
                  justify-between
                  py-2
                  px-12
                  border-2 border-indigo-300
                  rounded-lg
                  bg-white
                  shadow-blue-100 shadow-md
                "
              >
                <div>
                  <h2 class="text-gray-900 text-md font-bold">
                    {{ proyecto.proyecto }}
                  </h2>
                  <h3 class="mt-2 text-sm font-bold text-blue-500 text-left">
                    {{
                      new Intl.NumberFormat("de-DE", {
                        style: "currency",
                        currency: "USD",
                      }).format(proyecto.costo)
                    }}
                  </h3>
                </div>
                <div
                  class="
                    w-16
                    h-16
                    rounded-full
                    flex
                    justify-center
                    items-center
                  "
                >
                  <div>
                    <h1 class="text-black text-2xl">{{ proyecto.cantidad }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <Barras
              id="division"
              :stacked="true"
              :horizontal="false"
              :series="series"
              :categories="props.labesDivision"
            ></Barras>
          </div>
          <div>
            <Barras
              :stacked="false"
              :horizontal="true"
              :series="[{ name: 'Personas', data: AbsentismosCount }]"
              :categories="AbsentismosLabel"
            ></Barras>
          </div> 
        </div>
        
        <Fieldset legend="Tablas" :toggleable="true">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 rounded-2xl p-4">
            <div class="text-center font-bold text-xl space-y-4 border border-gray-400 rounded-lg">
                <h1 class="font-bold font-roboto text-xl">
                  Contratos a término fijo a vencer
                </h1>
                <div>
                    <ContratosVencer></ContratosVencer>
                </div>
            </div>
          <div
            class="
              text-center
              font-bold
              text-xl
              space-y-4
              border border-gray-400
              rounded-lg
            "
          >
            <h1 class="font-bold font-roboto text-xl">Costos por división</h1>
            <div class="overflow-auto max-h-96 text-center text-sm">
              <table
                class="
                  items-center
                  w-full
                  mb-0
                  align-top
                  border-gray-200
                  text-slate-900
                  mt-2
                  overflow-y-auto
                "
              >
                <thead class="align-bottom">
                  <tr>
                    <th
                      class="
                        px-6
                        py-3
                        font-bold
                        tracking-normal
                        text-left
                        uppercase
                        align-middle
                        bg-transparent
                        border-b
                        letter
                        border-b-solid
                        text-sm
                        whitespace-nowrap
                        border-b-gray-200
                        text-slate-400
                        opacity-70
                      "
                    >
                      División
                    </th>
                    <th
                      class="
                        px-6
                        py-3
                        font-bold
                        tracking-normal
                        text-left
                        uppercase
                        align-middle
                        bg-transparent
                        border-b
                        letter
                        border-b-solid
                        text-sm
                        whitespace-nowrap
                        border-b-gray-200
                        text-slate-400
                        opacity-70
                      "
                    >
                      Parte
                    </th>
                    <th
                      class="
                        px-6
                        py-3
                        font-bold
                        tracking-normal
                        text-center
                        uppercase
                        align-middle
                        bg-transparent
                        border-b
                        letter
                        border-b-solid
                        text-sm
                        whitespace-nowrap
                        border-b-gray-200
                        text-slate-400
                        opacity-70
                      "
                    >
                      Costo Mes
                    </th>
                    <th
                      class="
                        px-6
                        py-3
                        font-bold
                        tracking-normal
                        text-center
                        uppercase
                        align-middle
                        bg-transparent
                        border-b
                        letter
                        border-b-solid
                        text-sm
                        whitespace-nowrap
                        border-b-gray-200
                        text-slate-400
                        opacity-70
                      "
                    >
                      Costo Año
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="division in props.divsiones"
                    :key="division.division"
                  >
                    <td
                      class="
                        p-2
                        align-middle
                        bg-transparent
                        border-b
                        whitespace-nowrap
                      "
                    >
                      <h6 class="mb-0 leading-normal text-size-sm">
                        {{ division.division }}
                      </h6>
                    </td>

                    <td
                      class="
                        p-2
                        leading-normal
                        text-center
                        align-middle
                        bg-transparent
                        border-b
                        text-size-sm
                        whitespace-nowrap
                      "
                    >
                      <span class="font-semibold leading-tight text-size-xs">{{
                        division.cantidad
                      }}</span>
                    </td>
                    <td
                      class="
                        p-2
                        leading-normal
                        text-center
                        align-middle
                        bg-transparent
                        border-b
                        text-size-sm
                        whitespace-nowrap
                      "
                    >
                      <span class="font-semibold leading-tight text-size-xs">
                        {{
                          formatter.format(
                            (division.sum_salarios * 1.6) / 1000000
                          )
                        }}
                        M</span
                      >
                    </td>
                    <td
                      class="
                        p-2
                        align-middle
                        bg-transparent
                        border-b
                        whitespace-nowrap
                      "
                    >
                      <div class="w-3/4 mx-auto">
                        <span class="font-semibold leading-tight text-size-xs">
                          {{
                            formatter.format(
                              ((division.sum_salarios * 1.6) / 1000000) * 12
                            )
                          }}M</span
                        >
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </Fieldset>
      
      </div>
    </div>
  </AppLayout>
</template>
