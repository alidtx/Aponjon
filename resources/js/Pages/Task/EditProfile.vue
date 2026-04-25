<script setup>
import TaskerDefaultLayout from '@/Layouts/TaskerDefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import Form from './Partials/Form.vue';


const props = defineProps({

    districts: {
        type: Object,
        default: () => ({})
    },
    zilas: {
        type: Object,
        default: () => ({})
    },
    loggedInUser: {
        type: Object,
        default: () => ({})
    }

})
</script>



<template>
    <TaskerDefaultLayout>
        <Head title="এডিট টাস্কার প্রোফাইল" />
        <div class="lg:col-span-3">
            <Form :districts="districts" :zilas="zilas" :loggedInUser="loggedInUser" />
        </div>  
     </TaskerDefaultLayout>   
</template>