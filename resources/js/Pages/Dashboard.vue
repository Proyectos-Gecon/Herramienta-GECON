<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from 'primevue/breadcrumb';
import Welcome from '@/Components/Welcome.vue';

const home= {icon: 'pi pi-home', to: '/'};

const items =  [
                {label: 'Computer'},
                {label: 'Notebook'},
                {label: 'Accessories'},
                {label: 'Backpacks'},
                {label: 'Item'}
            ]
</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   Bienvenido..! 
                   <span v-if="$page.props.user.roles.length == 0">
                       Espere hasta que le Asignemos un ROL
                   </span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
