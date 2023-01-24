require ('./bootstrap');
import NProgress from 'nprogress'
import { createApp, h } from 'vue';
import Toast from 'primevue/toast';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import VueApexCharts from "vue3-apexcharts";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config'; 
import ConfirmationService from 'primevue/confirmationservice';
import ToggleButton from 'vue-js-toggle-button';
import { Head, Link } from '@inertiajs/inertia-vue3'
import ToastService from 'primevue/toastservice';
import 'primevue/resources/themes/mdc-light-indigo/theme.css'
import 'primevue/resources/primevue.min.css'
import 'primeicons/primeicons.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue, {ripple: true})
            .use(ConfirmationService)
            .use(ToggleButton)
            .use(ToastService)
            .use(Toast)
            .use(VueApexCharts)
            .mount(el);
    },
});

// InertiaProgress.init({ includeCSS: true, delay: 250,color: '#3DB4E8' });

Inertia.on('start',  () => NProgress.start())

Inertia.on('finish', () => NProgress.done())
