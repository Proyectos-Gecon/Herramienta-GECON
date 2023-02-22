<template>
    <div>
         <div class="flex space-x-2 p-2 col-span-1 md:col-span-2 text-base md:text-xl">
            <div class="flex align-items-center">
              <i class="fa-solid fa-user-check mr-1"></i>
              <span>{{ presentes }} Personas Presentes </span>
            </div>
            <div class="flex align-items-center">
              <i class="fa-solid fa-user-xmark mr-1"></i>
              <span>{{ noPresentes }} Personas NO Presentes </span>
            </div>
            <div class="flex align-items-center" >
              <i class="fa-solid fa-users-slash mr-1"></i>
              <span>{{ NoRegistrados }} Personas NO Registradas </span>
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
                         {{ personal }}
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
                              (costoMes) / 1000000
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
                              (costoMes)/ 20000000
                          )
                          }}
                          Millones
                      </p>
                  </div>
                  </div>
              </div>
          </div>
    </div>
</template>

<script setup>

import { onMounted, ref } from "vue";

const props = defineProps({
    fecha: Date 
})

var costoMes =  ref(0)
var personal = ref(0)
var presentes = ref(0)
var noPresentes = ref(0) 
var NoRegistrados = ref(0)

var loading  = ref(false)

 onMounted(async () => {
    console.log(props.fecha)
    getData(props.fecha)
})

const getData = async (fecha) => { 
    loading.value = true 
    await axios.get(route('personal.getResumen', fecha)).then((res) => {

        costoMes.value = parseInt(res.data.costos);
        personal.value = parseInt(res.data.personal);
        presentes.value = parseInt(res.data.presentes);
        noPresentes.value = parseInt(res.data.noPresentes);
        NoRegistrados.value = parseInt(res.data.NoRegistrados);

        consola.log(presentes.value)
        loading.value = false
       
    })
}

const formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "USD",
  // These options are needed to round to whole numbers if that's what you want.
  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
  maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});


</script>