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
  costoMes: Array,
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
                dateFormat="mm/dd/yy"
                :showIcon="true"
                v-on:date-select="selectFecha"
                placeholder="Seleccione una fecha"
              />
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-4">
          <div class="flex space-x-2 p-2 col-span-1 md:col-span-2">
            <div class="flex align-items-center text-xl">
              <i class="fa-solid fa-user-check mr-1"></i>
              <span>{{ props.totalPresentes }} Personas Presentes </span>
            </div>
            <div class="flex align-items-center text-xl">
              <i class="fa-solid fa-user-xmark mr-1"></i>
              <span>{{ props.totalNoPresentes }} Personas NO Presentes </span>
            </div>
            <div class="flex align-items-center text-xl" >
              <i class="fa-solid fa-users-slash mr-1"></i>
              <span>{{ props.noRegistrados }} Personas NO Registradas </span>
            </div>
          </div>
            <div class="grid col-span-1 md:col-span-3 gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <div class="min-w-0 rounded-lg border border-gray-400 shadow-xs overflow-hidden bg-white dark:bg-gray-800">
                    <div class="p-4 flex items-center">
                    <div class="p-3 rounded-full text-orange-500 dark:text-orange-100 bg-orange-100 dark:bg-orange-500 mr-4">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                        ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Personal
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ countPersonal }}
                        </p>
                    </div>
                    </div>
                </div>
                <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 border border-gray-400">
                    <div class="p-4 flex items-center">
                    <div
                        class="p-3 rounded-full text-green-500 dark:text-green-100 bg-green-100 dark:bg-green-500 mr-4"
                    >
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"
                        ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Costo Mes
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{
                            formatter.format(
                                (props.costoMes[0].sum_salarios * 1.6) / 1000000
                            )
                            }}
                            Millones
                        </p>
                    </div>
                    </div>
                </div>
                <div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 border border-gray-400">
                    <div class="p-4 flex items-center">
                    <div
                        class="p-3 rounded-full text-green-500 dark:text-green-100 bg-green-100 dark:bg-green-500 mr-4"
                    >
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                        <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"
                        ></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Costo Dia
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{
                            formatter.format(
                                (props.costoMes[0].sum_salarios * 1.6) / 30000000
                            )
                            }}
                            Millones
                        </p>
                    </div>
                    </div>
                </div>
            </div>
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
