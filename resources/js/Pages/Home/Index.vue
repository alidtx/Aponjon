<script setup>
import { Head } from '@inertiajs/vue3'
import PublicDefaultLayout from '@/Layouts/PublicDefaultLayout.vue';
import Hero from './Sections/Hero.vue';
import Service from './Sections/Service.vue';
import HowItWork from './Sections/HowItWork.vue';
import TaskerRegistration from './Sections/TaskerRegistration.vue';
import Testimonial from './Sections/Testimonials.vue';
import { provide } from 'vue'

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    siteConfig:{
      type:Object,
    },
    user:{
      type:Object,
      required:true
    }
});

provide('siteConfig', props.siteConfig)

</script>



<template>
            <Head title="হোম"/>
            <PublicDefaultLayout
            :canLogin="canLogin"
            :canRegister="canRegister"
            :user="props.user"
            >
             <Hero/>   
             <Service/>   
             <HowItWork/>   
             <TaskerRegistration/>   
             <Testimonial/>   
            </PublicDefaultLayout>
</template>

