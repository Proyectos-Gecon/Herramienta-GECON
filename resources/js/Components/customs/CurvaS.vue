<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Line from '@/charts/Line.vue';

const props = defineProps({
    proyecto: Number
})

const label =ref([])
const ejecutado = ref ([])
const planeado = ref([])


axios.get(route('getDataProyecto', props.proyecto)).then((res) => {
    label.value = res.data.labels
    planeado.value = res.data.planeado.map(x => Number.parseFloat(x*100).toFixed(2))
    ejecutado.value = res.data.ejecutado.map(x => Number.parseFloat(x*100).toFixed(2))
}); 
const  series= [
            {
              name: "Avance Planeado",
              data: planeado
            },{
                name: "Avance Ejecutado",
                data: ejecutado
            }
           
          ];
 const chartOptions= {
            chart: {
              height: 350,
              type: 'line',
              dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
              },
              toolbar: {
                show: true
              }
            },
            colors: ['#77B6EA', '#545454'],
            dataLabels: {
              enabled: true,
            },
            stroke: {
              curve: 'smooth'
            },
            title: {
              text: 'Curva S',
              align: 'left'
            },
            xaxis: {
                categories: label,
            },
            yaxis: {
              min: 0,
              max: 100
            },
            legend: {
              position: 'top',
              horizontalAlign: 'right',
              floating: true,
              offsetY: -25,
              offsetX: -5
            }
          };
</script>
<template>
    <div id="chart">
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
      </div>
</template>