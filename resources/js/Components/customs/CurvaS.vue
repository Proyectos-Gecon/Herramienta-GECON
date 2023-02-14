<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';

const props = defineProps({
    proyecto: Number
})

var label = ref([])
const ejecutado = ref ([])
const planeado = ref([])

onMounted(() => {
    axios.get(route('getDataProyecto', props.proyecto)).then(res => {
        label.value = res.data.labels.map(x => 'WK '+ x.substring(0,2)+'-'+x.substring(3,2))
        planeado.value = res.data.planeado
        ejecutado.value = res.data.ejecutado
    })
})

</script>
<template>
<h1>{{ label[1] }}</h1>    
</template>