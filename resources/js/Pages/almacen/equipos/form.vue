<script setup>
    import { ref} from "vue";
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Button from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import InputText from "primevue/inputtext";
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import Dropdown from 'primevue/dropdown';
    import InputNumber from 'primevue/inputnumber';
    import Calendar from 'primevue/calendar';
    import { Inertia } from '@inertiajs/inertia';
    import TextInput from '@/Components/customs/TextInput.vue';
    import NumberInput from '@/Components/customs/NumberInput.vue';
    import { usePreValidate } from "@/composable/UsePrevalidate";
    import Header from "@/Components/customs/Header.vue";

    
    var form = useForm({
        almacen_id: null,
        categoria_id: null,
        serial: null,
        codigo_SAP: null,
        valor_compra: null,
        marca: null,
        fecha_ingreso: null,
        observaciones: null,
    });
    
    const { validate } = usePreValidate(form, {
        method: "post",
        url: route("equipos.store"),
        });


    const props = defineProps({
        grupos: Array,
        subgrupos: Array,
        categorias: Array,
        almacenes: Array,
    });
    
    //Variables reactivas
    var grupo = ref(null)
    var subGrupo = ref(null)
    var subgrupos = ref([])
    var categorias = ref([])
    var loading = ref(false)

    /* Funcions */
    const selectedGrupo = (event) => {
            loading = true;
            subgrupos = props.subgrupos.filter(subgrupo => subgrupo.categoria_id == grupo.value)
            subGrupo = ref(null)
            categorias = ref([])
            form.categoria_id = null
            loading = false;
    }

    const selectedSubGrupo = (event) => {
            loading = true;
            categorias = props.categorias.filter(subgrupo => subgrupo.categoria_id == subGrupo.value)
            loading = false;
    }

    const submit = () => {
        form.post(route('equipos.store'),{
            onSuccess: () => {
                Inertia.get(route('equipos.index'))
            }
        })
    }
    /* End functions */ 
</script>

<template>
    <AppLayout>
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-w-full py-auto">
                    <Header :title="props.equipo != null ? 'Editar Equipos':'Crear Equipos'">
                    
                    </Header>
                    <form @focusout="validate" @submit.prevent="submit" class="pb-4">
                        <div class="grid md:grid-cols-2 grid-cols-1 my-2 gap-6 px-6">
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Almacen</span>
                            <Dropdown v-model="form.almacen_id" optionValue="id"  :options="props.almacenes" optionLabel="nombre_almacen"  :filter="true" placeholder="Seleccionar Almacen"   :error="form.errors.almacen_id != null" />
                            <small id="username2-help" class="p-error">{{
                                form.errors.almacen_id
                            }}</small>
                        </div>
                        
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Grupo</span>
                            <Dropdown v-model="grupo" optionValue="id" :options="props.grupos" @change="selectedGrupo(value)" optionLabel="name"  :filter="true" placeholder="Seleccionar Grupo" />
                        </div>
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Sub Grupo</span>
                            <Dropdown v-model="subGrupo" optionValue="id" :options="subgrupos" emptyMessage="Seleccione un Grupo"   :loading="loading" @change="selectedSubGrupo(value)" optionLabel="name"  :filter="true" placeholder="Seleccionar Sub Grupo" />
                        </div>
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Categoria/Descripción</span>
                            <Dropdown required v-model="form.categoria_id" optionValue="id" :emptyMessage="subGrupo == null ? 'Seleccionar Sub Grupo':'No hay categorias para este Sub Grupo'"   :options="categorias" :loading="loading"  optionLabel="name"  :filter="true" placeholder="Seleccionar Categoria" />
                        </div>
                        <TextInput label="Serial" v-model="form.serial">
                        </TextInput>
                        <TextInput label="Codigo de SAP" v-model="form.codigo_SAP">
                        </TextInput>
                        
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Valor de Compra</span>
                            <InputNumber inputId="currency-us" v-model="form.valor_compra" mode="currency" placeholder="Escriba el Valor de compra" currency="USD" locale="en-US" />
                        </div>      
                      
                        <TextInput label="Marca" v-model="form.marca">
                        </TextInput>
                    
                        <div class="p-fluid p-input-filled border-0 space-y-2 ">
                            <span>Fecha de Ingreso</span>
                            <Calendar  v-model="form.fecha_ingreso" dateFormat="dd/mm/yy" :maxDate="new Date()" :showIcon="true" :manualInput="true" />
                        </div>    
                        <div class="p-fluid p-input-filled border-0 space-y-2">
                            <span>Observaciones</span>
                            <InputText v-model="form.observaciones" placeholder="Escriba Aqui alguna Observación"></InputText>
                        </div>
                        </div>
                        <div class="px-[2%] text-end">
                            <Button
                            label="Guardar"
                            type="submit"
                            icon="pi pi-save"
                            iconPos="left"
                            />
                            </div>
                    </form>
                </div>
            </div>
         
        </div>
    </AppLayout>
</template>