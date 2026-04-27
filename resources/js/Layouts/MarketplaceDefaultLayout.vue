<script setup>
import NavBar from './NavBar.vue';
import Footer from './Footer.vue';
</script>

<template>
    <NavBar>

        <div class="flex items-center space-x-4">
            <a href="post-task.html" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                <i class="fas fa-plus mr-2"></i>টাস্ক পোস্ট করুন
            </a>
            <a href="tasker-dashboard.html" class="text-dark hover:text-primary">
                টাস্কার হোন
            </a>
        </div>

    </NavBar>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <slot />
    </div>
    <Footer />
</template>