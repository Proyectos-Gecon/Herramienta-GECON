<script setup>
import Sidebar from 'primevue/sidebar';
import Button from 'primevue/button';

const visibleLeft= false;

</script>
<template>
 <Button icon="pi pi-arrow-right" @click="visibleLeft = true" class="mr-2" />

 <Sidebar v-model:visible="visibleLeft" :baseZIndex="10000">
    <h3>Left Sidebar</h3>
</Sidebar>
</template>