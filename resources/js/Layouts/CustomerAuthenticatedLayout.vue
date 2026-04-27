<script setup>
import NavBar from './NavBar.vue';
import { usePage } from '@inertiajs/vue3';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import UserSettingsIcon from '@/Components/Icons/UserSettingsIcon.vue';
import LogOutIcon from '@/Components/Icons/LogOutIcon.vue';
import SideBar from '@/Pages/Customer/Partials/SideBar.vue';
import Footer from './Footer.vue'; 


const page = usePage();
const auth = page.props.auth;
const user = auth?.user;

const menuItems = [
    {
        label: 'প্রোফাইল এডিট করুন',
        route: route('customer.profile.edit', user?.id),
        icon: EditIcon
    },
    {
        label: 'প্রোফাইল সেটিংস করুন',
        route: route('customer.edit.customer.profile.settings'),
        icon: UserSettingsIcon
    },
    {
        label: 'লগআউট',
        route: route('logout'),
        icon: LogOutIcon,
        method: 'post',
        as: 'button',
        danger: true
    },
];
</script>


<template>
 <div class="min-h-screen flex flex-col">
    <NavBar 
        :name="user?.name"
        :items="menuItems"
    />   
    <div class="flex-1 max-w-7xl mx-auto px-4 py-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <SideBar/>
            <slot />
        </div>
    </div>
    <Footer />
</div>
</template>