<script setup>

const props = defineProps({
    stacked: Boolean,
    series: Array,
    categories: Array
})

const options= {
    chart: {
          id: 'vuechart-example',
          stacked: props.stacked,
          
        },
        xaxis: {
          categories: props.categories
        },
        colors: ['#FC6881','#3EEE73'],       
    }
</script>
<template>
      <apexchart  type="bar" :options="options" :series="series"></apexchart>
</template>