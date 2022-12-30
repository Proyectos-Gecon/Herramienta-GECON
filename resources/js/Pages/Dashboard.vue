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
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates eos aliquam quod expedita inventore veritatis voluptatum nisi, molestias quibusdam consequatur, explicabo perspiciatis cum voluptatibus hic, eum fuga in esse vel.
                    Veritatis rem libero cupiditate fugit aut assumenda enim! A natus sit aspernatur provident voluptatum quidem. Voluptates suscipit distinctio harum neque reprehenderit nihil eligendi nobis? Ut omnis qui tempora veniam accusamus!
                    Provident tenetur nulla perferendis alias soluta veniam dolores, accusamus repudiandae debitis molestias quae nemo fugit optio autem, cumque hic! Possimus, ipsam illum? Necessitatibus repellendus veniam quam non autem dignissimos hic.
                    Corporis voluptatem veritatis inventore deleniti eius odit dolor dolores. Quis aspernatur perspiciatis fugit nulla esse adipisci quasi, exercitationem accusantium cumque officia quae impedit quas harum, eveniet corrupti recusandae commodi! Eaque?
                    Maiores nesciunt ducimus labore sint beatae eius. Dolorem beatae quas cum officia exercitationem ratione, modi incidunt pariatur neque, sequi excepturi distinctio ab vitae corporis eius. Vitae distinctio nemo aperiam modi!
                    Reiciendis praesentium repellat aliquam minus vel ex doloremque porro molestiae, velit tenetur atque impedit quod consectetur odio commodi consequatur placeat, mollitia eveniet optio iusto provident culpa. Facere sit exercitationem tenetur?
                    Nemo incidunt dicta libero tenetur iste, fuga nisi, placeat explicabo iure, dolorum totam quae nulla rerum dolore tempora! In sunt quos illo non eveniet saepe ut culpa earum? Magni, adipisci.
                    Modi, itaque nam quibusdam accusantium doloribus iusto temporibus deleniti libero, ipsa numquam harum labore mollitia, qui perspiciatis consequuntur voluptatum excepturi ducimus alias! Asperiores laborum, quaerat rem perferendis eos incidunt quidem!
                    Minus reprehenderit pariatur quisquam delectus alias blanditiis, quod ipsam excepturi iusto ipsum veritatis eaque cumque minima sunt assumenda nisi velit corporis modi. Voluptatibus repellat non aliquid labore dolorem accusantium minus.
                    Dolor eos illo aliquid tenetur, suscipit architecto qui aspernatur deserunt! Molestiae illum at consequuntur quam cum ex! Rem, aliquid alias vitae quae dignissimos illo, obcaecati corporis voluptatum nostrum minus recusandae!
                </div>
            </div>
        </div>
    </AppLayout>
</template>
