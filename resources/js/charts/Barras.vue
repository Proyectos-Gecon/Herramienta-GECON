<script setup>
import { Inertia } from '@inertiajs/inertia';


const props = defineProps({
    stacked: Boolean,
    series: Array,
    categories: Array,
    horizontal: Boolean,
    id: String
})

const selecData =  (e, chart, opts) => {
    Inertia.get(route('parte.index', {
        estado: opts.w.globals.labels[opts.dataPointIndex]
    }));
}

const options= {
    chart: {
          id: props.id,
          stacked: props.stacked,
         
        },
        plotOptions: {
            bar: {
                horizontal: props.horizontal
            }
        },
        xaxis: {
          categories: props.categories
        },
        colors: ['#636465','#067CBB'],       
    }
</script>
<template>
    <div :id="id">
        <apexchart  type="bar" :options="options" :series="series" @dataPointSelection="selecData"></apexchart>
    </div>
</template>