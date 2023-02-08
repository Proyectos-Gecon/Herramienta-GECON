<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
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

const props = defineProps({
  userLogin: Number
})
const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const displayPosition = ref(false);

var position = ref('top');

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
    <header>
      <nav
        class="
          fixed
          z-20
          w-full
          bg-white/90
          dark:bg-gray-900/80
          backdrop-blur
          navbar
          shadow-2xl shadow-gray-600/5
          border-b border-gray-100
          dark:border-gray-800
          peer-checked:navbar-active
          dark:shadow-none
        "
      >
        <div class="xl:container m-auto px-6 md:px-12 lg:px-6">
          <div
            class="
              flex flex-wrap
              items-center
              justify-between
              gap-6
              md:py-3 md:gap-0
              lg:py-5
            "
          >
            <div class="w-full items-center flex justify-between mt-8 md:mt-0">
              <a class="relative z-10" href="#" aria-label="logo">
                <ApplicationLogo></ApplicationLogo>
              </a>
            </div>
            <div
              class="-mt-10
                w-full
                justify-end
                items-center
                bg-white
                dark:bg-gray-800
                space-y-0
                p-0
                m-0
                flex
                md:flex-nowrap
                bg-transparent
                lg:shadow-none
                dark:shadow-none dark:border-gray-700
                lg:border-0
              "
            >
              <div class="text-gray-600 dark:text-gray-300 lg:pr-4 ">
                <ul class="tracking-wide font-medium text-sm  space-y-0 hidden md:flex">
                  <li>
                    <a
                      href="#"
                      class="
                        block
                        px-4
                        transition
                        hover:text-primary
                        dark:hover:text-primaryLight
                      "
                    >
                      <span>Inicio</span>
                    </a>
                  </li>
                </ul>
              </div>

              <div
                class="
                  w-full
                  space-y-2
                  border-primary/10
                  dark:border-gray-700
                  flex flex-col
                  -ml-1
                  sm:flex-row
                  lg:space-y-0
                  md:w-max
                  lg:border-l
                  px-2
                "
              >
                <a
                  @click="
                    if(props.userLogin != null){
                      Inertia.get(route('dashboard'))
                    }
                    position = 'topright';
                    displayPosition = ref(true);
                  "
                  href="#"
                  class="
                    relative
                    flex
                    h-9
                    -mt-10
                    md:mt-0
                    ml-auto
                    items-center
                    justify-center
                    px-6
                    before:absolute
                    before:inset-0
                    before:rounded-full
                    before:bg-sky-600
                    dark:before:bg-sky-400
                    before:transition before:duration-300
                    hover:before:scale-105
                    active:duration-75 active:before:scale-95
                  "
                >
                  <span
                    class="
                      relative
                      text-sm
                      font-semibold
                      text-white
                      dark:text-gray-900
                    "
                    >Entrar</span
                  >
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <Dialog
    class="login-dialog"
    header="Login"
      v-model:visible="displayPosition"
      :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
      :style="{ width: '50vw' }"
      :position="position"
      :modal="true"
    >
      <section>
        <div class="relative flex flex-col min-w-0 break-words w-full py-2">
          <form @submit.prevent="submit">
            <div class="relative w-full mb-3">
                <div class="field col-12 md:col-4">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-user"></i>
                        </span>
                        <span class="p-float-label p-input-filled">
                            <InputText id="inputgroup" type="text" v-model="form.username" />
                            <label for="inputgroup">Nombre de Usuario</label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="relative w-full mb-3">
                <div class="field col-12 md:col-4">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-lock"></i>
                        </span>
                        <span class="p-float-label p-input-filled">
                            <InputText id="inputgroup" type="password" v-model="form.password" />
                            <label for="inputgroup">Contraseña</label>
                        </span>
                    </div>
                </div>
            </div>
            <div>
              <label class="inline-flex items-center cursor-pointer"
                ><input
                  id="customCheckLogin"
                  v-model="form.remember"
                  type="checkbox"
                  class="
                    form-checkbox
                    border-0
                    rounded
                    text-blue-700
                    ml-1
                    w-5
                    h-5
                    transition-all
                    duration-150
                  "
                /><span class="ml-2 text-sm font-semibold text-blueGray-600"
                  >Remember me</span
                ></label
              >
            </div>
            <div class="text-center mt-2 p-fluid">
                <Button type="submit" class="vimeo p-0" aria-label="Vimeo">
                <span class="px-3">Entrar</span>
                </Button>
            </div>
          </form>
        </div>
      </section>
    </Dialog>
</template>