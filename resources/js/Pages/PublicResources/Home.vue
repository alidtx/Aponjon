<script setup>
import { Head } from '@inertiajs/vue3'
import PublicDefaultLayout from '@/Layouts/PublicDefaultLayout.vue';
import Hero from '@/Layouts/Partials/PublicResources/Sections/Hero.vue';
import Service from '@/Layouts/Partials/PublicResources/Sections/Service.vue';
import HowItWork from '@/Layouts/Partials/PublicResources/Sections/HowItWork.vue';
import TaskerRegistration from '@/Layouts/Partials/PublicResources/Sections/TaskerRegistration.vue';
import Testimonial from '@/Layouts/Partials/PublicResources/Sections/Testimonials.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

</script>



<template>
            <Head title="Home" />
            <PublicDefaultLayout
            :canLogin="canLogin"
            :canRegister="canRegister"
            >
             <Hero/>   
             <Service/>   
             <HowItWork/>   
             <TaskerRegistration/>   
             <Testimonial/>   
            </PublicDefaultLayout>
</template>

