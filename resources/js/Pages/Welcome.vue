<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import MenuHeader from "@/Components/customs/MenuHeader.vue";
import Dialog from "primevue/dialog";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { ref } from "vue";
import InputText from "primevue/inputtext";
import Password from 'primevue/password';
import { usePage } from '@inertiajs/inertia-vue3'
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import TextInput from '@/Components/customs/TextInput.vue';
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "primevue/usetoast";
const toast = useToast();

var asignaciones = ref([])

const form = useForm({
    identificacion: '',
});
const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  userLogin: Number,
  asignaciones: Object
});



const buscar = () => {
  
  if(form.identificacion){
    Inertia.visit(route('buscarAsignaciones', form.identificacion),
      { 
        method: 'get',
       
        preserveScroll: true,
        onError: (errors) => {
          toast.add({severity:'info', summary: 'Asignaciones', detail:errors.msg, life: 5000});
        },
      }
      )
      return
    }
    toast.add({severity:'error', summary: 'Buscar Asignaciones', detail:'Escriba una Identificacion', life: 3000});
}


</script>

<template>
  	<Toast />
  <Head title="Welcome" />
  <div class="bg-white dark:bg-gray-900">
    <MenuHeader :userLogin="props.userLogin"></MenuHeader>
    <div class="relative pt-40 pb-20 lg:pt-44 dark:bg-gray-900">
      <div class="relative xl:container m-auto px-6 md:px-12 lg:px-4 mb-2">
        <h1
          class="
            z-20
            sm:mx-auto sm:w-10/12
            md:w-2/3
            font-black
            text-blue-900 text-4xl text-center
            sm:text-5xl
            md:text-6xl
            lg:w-auto lg:text-left
            xl:text-7xl
            dark:text-white
          "
        >
          Servicio Digitales <br class="lg:block hidden" />
          <span
            class="
              relative
              text-transparent
              bg-clip-text bg-gradient-to-r
              from-blue-600
              to-cyan-500
              dark:from-blue-400 dark:to-cyan-300
            "
            >COTECMAR</span
          >.
        </h1>
        <div class="lg:flex">
          <div
            class="
              relative
              mt-8
              z-20
              md:mt-16
              space-y-8
              sm:w-10/12
              md:w-2/3
              lg:ml-0
              sm:mx-auto
              text-center
              lg:text-left lg:mr-auto lg:w-7/12
            "
          >
            <p class="sm:text-lg text-gray-700 dark:text-gray-300 lg:w-11/12">
             Gestiona tus actividades desde nuestra aplicación, utiliza las funciones que se han diseñado pensando en todos los colaboradores de la corporación.
            </p>
            <span class="block font-semibold text-gray-500 dark:text-gray-400">Ponemos todo nuestro empeño en tus necesidades.</span>
          </div>
          <div class="mt-4 md:-mt-64 lg:absolute -right-20 lg:w-6/12">
            <div class="relative w-full mx-auto">
              <div
                aria-hidden="true"
                class="
                  absolute
                  scale-75
                  md:scale-110
                  inset-0
                  m-auto
                  w-full
                  h-full
                  md:w-96 md:h-5
                  rounded-full
                  rotate-45
                  bg-gradient-to-r
                  from-sky-500
                  to-cyan-300
                  blur-3xl
                "
              ></div>
              <img
                src="images/principal.gif"
                class="relative w-10/12 rounded-2xl z-10"
                alt="wath illustration"
                loading="lazy"
                width="200"
                height="200"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="bg-blue-100 shadow-md shadow-blue-100 rounded-2xl dark:bg-gray-900 z-20 px-6 md:px-12 lg:px-4 -mt-20 md:mt-36">
              <div class="container p-2 mx-auto">
                  <div class="lg:flex lg:items-center">
                    <div class="hidden lg:flex lg:items-center lg:w-1/2 lg:justify-center">
                          <img class="w-[28rem] h-[28rem] object-cover xl:w-[34rem] xl:h-[34rem] rounded-full" src="images/funcionalidades.gif" alt="">
                      </div>
                      <div class="w-full space-y-12 lg:w-1/2 mt-20">
                          <div>
                              <h1 class="text-3xl font-semibold text-gray-800 capitalize lg:text-4xl dark:text-white">Explora todas <br> Nuestras Funciones</h1>
                          
                              <div class="mt-2">
                                  <span class="inline-block w-40 h-1 rounded-full bg-blue-500"></span>
                                  <span class="inline-block w-3 h-1 ml-1 rounded-full bg-blue-500"></span>
                                  <span class="inline-block w-1 h-1 ml-1 rounded-full bg-blue-500"></span>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Gestión de Personal</h1>

                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                    Gestiona todas las actividades, la información y la planilla de tu equipo de trabajo de forma facil y rapida desde nuestra aplicación.
                                  </p>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                </svg>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Almacen de Herramientas</h1>

                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                      Gestionar las herramientas y equipos de las gerencias nunca habia sido tan facil, verifica el inventario, realiza asignaciones y mucho mas. 
                                  </p>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <i class="fas fa-ship text-xl"></i>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Proyectos de Construcción</h1>
                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                      Gestión de proyectos de construcción, reportes, control de avance, indicadores control de avance y muchas funcionalidades mas.
                                  </p>
                              </div>
                          </div>
                      </div>

                      
                  </div>

                  <hr class="border-gray-200 my-12 dark:border-gray-700">
                  
              </div>
      </div>
      <div class="bg-white shadow-md shadow-blue-100 rounded-2xl dark:bg-gray-900 z-20 px-6 md:px-12 lg:px-4 -mt-10">
              <div class="container p-2 mx-auto">
                  <div class="lg:flex lg:items-center">
                      <div class="w-full space-y-12 lg:w-1/2 mt-20">
                          <div>
                              <h1 class="text-3xl font-semibold text-gray-800 capitalize lg:text-4xl dark:text-white">Almacen de  <br> Herramientas</h1>
                          
                              <div class="mt-2">
                                  <span class="inline-block w-40 h-1 rounded-full bg-blue-500"></span>
                                  <span class="inline-block w-4 h-1 ml-1 rounded-full bg-blue-500"></span>
                                  <span class="inline-block w-2 h-1 ml-1 rounded-full bg-blue-500"></span>
                                  <span class="inline-block w-1 h-1 ml-1 rounded-full bg-blue-500"></span>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Asignaciones</h1>

                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                    Registra y gestiona las herramientas asignadas al personal Operativo, 
                                  </p>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                                </svg>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Inventarios</h1>

                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                      Mantener el inventario de herramientas nunca habia sido tan facil, registra e identifica los equipos y consumibles de la gerencia
                                  </p>
                              </div>
                          </div>

                          <div class="md:flex md:items-start md:-mx-4">
                              <span class="inline-block p-2 text-blue-500 bg-blue-100 rounded-xl md:mx-4 dark:text-white dark:bg-blue-500">
                                <i class="fa-solid fa-chart-pie text-xl"></i>
                              </span>

                              <div class="mt-4 md:mx-4 md:mt-0">
                                  <h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">Reportes</h1>
                                  <p class="mt-3 text-gray-500 dark:text-gray-300">
                                     Descarga y analiza reportes desde la misma aplicación.
                                  </p>
                              </div>
                          </div>
                      </div>
                      <div class="flex-1 items-center w-full justify-center px-auto">
                          <img class="w-[26rem] h-[26rem] object-cover rounded-full" src="images/buscar.gif" alt="">
                          <form @submit.prevent="buscar">
                              <div class="p-inputgroup">
                                  <InputText placeholder="Identificación" v-model="form.identificacion"/>
                                  <Button icon="pi pi-search" type="submit" class="p-button-warning"/>
                              </div>
                        </form>
                      </div>
                  </div>
                  
              </div>
      </div>
 

    </div>
  </div>
</template>
<style lang="scss" scoped>
    ::v-deep(.login-dialog.p-dialog) {
        .p-dialog-content {
            background: #212121;
        }

    }

</style>
