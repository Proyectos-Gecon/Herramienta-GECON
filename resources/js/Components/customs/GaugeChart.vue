<template>
    <div id="canvas-holder" style="width:100%">
    <canvas ref="chart" class="w-full"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
var gradient = '';

const props = defineProps({
  value: Number,
  title: String
})


const chart = ref()

// var ctx =  chart._value.;
// 
onMounted(() => {
  var ctx = chart.value.getContext('2d')
  var grd = ctx.createLinearGradient(0, 0, 170, 0);
  grd.addColorStop(0.6, "red");
  grd.addColorStop(1, "yellow");
  
  ctx.fillStyle = grd;
  ctx.fillRect(20, 20, 150, 100);
  var config = {
  type: 'gauge',
  data: {
    //labels: ['Success', 'Warning', 'Warning', 'Error'],
    datasets: [{
      value: props.value,
      minValue: 0,
      data: [0,1,2],
      backgroundColor: [grd, grd,'#8BF934'],
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: props.title
      },
    layout: {
      padding: {
        bottom: 30
      }
    },
    needle: {
      // Needle circle radius as the percentage of the chart area width
      radiusPercentage: 2,
      // Needle width as the percentage of the chart area width
      widthPercentage: 3.2,
      // Needle length as the percentage of the interval between inner radius (0%) and outer radius (100%) of the arc
      lengthPercentage: 80,
      // The color of the needle
      color: 'rgba(0, 0, 0, 1)'
    },
    
  }
};


  new Chart(ctx, config);
})

</script>
