<script setup>
import { onMounted } from 'vue'

const props  = defineProps({
    series: Array,
    labels: Array,
    names: Array,
})
var data = [];

const options = {
        series: series,
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
        },
        plotOptions: {
          bar: {
            horizontal: true,
             barHeight: '80%',
          },
        },
        xaxis: {
          categories: props.labels,
        },
        yaxis: {
           position: "rigth",
            labels: {
              offsetY: 0
            },
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
        },
        fill: {
          opacity: 1
        },
        dataLabels: {
          enabled: true,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        colors: [
        "#F32822",
        "#7CDC5E",
        '#F3F156'
        ],
        };
        onMounted(() => {
            var chartBarrar = new ApexCharts(document.querySelector("#chartBarrar"), options);
            chartBarrar.render();
        })
</script>
<template>
    <div class="py-6 -pl-2 bg-gray-50 rounded-xl shadow-lg">
        <div  id="chartBarrar"> </div>
    </div>
</template>