<script setup>
import NavBar from './NavBar.vue';
import Footer from './Footer.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    items: {
        type: Array,
        default: () => []
    },
    showChat: {
        type: Boolean,
        default: true
    },
    showNotifications: {
        type: Boolean,
        default: true
    }
});

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <NavBar
            :name="user?.name"
            :items="props.items"
            :show-chat="props.showChat"
            :show-notifications="props.showNotifications"
        />
        <div class="flex-1">
            <slot />
        </div>
        <Footer />
    </div>
</template>
