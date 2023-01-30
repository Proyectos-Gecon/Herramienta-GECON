<script setup>
import { Head, Link, 
 } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {  useForm } from '@inertiajs/inertia-vue3';


defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <section class="h-full gradient-form bg-gray-200 md:h-screen">
  <div class="container py-12 px-auto h-full">
    <div class="flex justify-center items-center flex-wrap h-full g-6 text-gray-800">
      <div class="xl:w-10/12">
        <div class="block bg-white shadow-lg rounded-lg">
          <div class="lg:flex lg:flex-wrap g-0">
            <div class="lg:w-6/12 px-4 md:px-0">
              <div class="md:p-12 md:mx-6">
                <div class="text-center">
                  <img
                    class="mx-auto w-40"
                    src="https://www.cotecmar.com/sites/default/files/media/imagenes/2021-12/CotecmarLogo.png"
                    alt="logo"
                  />
                 
                </div>
                <form  @submit.prevent="submit">
                  <p class="mb-4 mt-4">Por favor Inicia sesión con tu cuenta</p>
                  <div class="mb-4">
                    <input
                      type="text"
                      v-model="form.username"
                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                      id="exampleFormControlInput1"
                      placeholder="Username"
                    />
                  </div>
                  <div class="mb-4">
                    <input
                      type="password"
                      v-model="form.password"
                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                      id="exampleFormControlInput1"
                      placeholder="Password"
                    />
                  </div>
                  <div class="text-center pt-1 mb-12 pb-1">
                    <button
                      class="inline-block px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-full mb-3"
                      type="submit"
                      data-mdb-ripple="true"
                      data-mdb-ripple-color="light"
                      style="
                        background: linear-gradient(
                          to right,
                          #33A8CD,
                          #BAEBF1,
                          #BACBF1,
                          #4327F3
                        );
                      "
                    >
                      Entrar
                    </button>
                  </div>
                  
                </form>
              </div>
            </div>
            <div
              class="lg:w-6/12 flex items-center lg:rounded-r-lg rounded-b-lg lg:rounded-bl-none"
              style="
                background: linear-gradient(to right,  #BACBF1,
                          #BAEBF1,
                          #BACBF1,
                          #33A8CD
                          );
              "
            >
              <div class="text-gray-700 px-4 py-6 md:p-12 md:mx-6 ">
                <h4 class="text-xl font-bold mb-6">COTECMAR</h4>
                <p class="text-base">
                    COTECMAR es una organización innovadora que trabaja dentro del campo de investigación científica y tecnológica, apoyando el desarrollo de la industria marítima colombiana.

                    Nuestra experiencia considera desde el Diseño avanzado y Construcción de plataformas navales personalizadas a las necesidades de cada cliente; hasta la reparación y mantenimiento de embarcaciones con los mas altos estándares de calidad, tecnicismo y capacidad de respuesta en tiempos oportunos de atención.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>     
</template>
