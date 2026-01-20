<script setup>
defineProps({
    loading: {
        type: Boolean,
        required: true
    }
})
</script>


<template>
    <transition name="page-loader">
        <div v-if="loading" class="fixed inset-0 bg-white bg-opacity-90 z-50 flex items-center justify-center"
            style="backdrop-filter: blur(2px);">
            <div class="text-center">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-full border-4 border-blue-200"></div>
                    <div
                        class="absolute inset-0 rounded-full border-4 border-blue-500 border-t-transparent animate-spin">
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-700 font-medium text-lg">অনুগ্রহ করে অপেক্ষা করুন...</p>
                    <p class="text-gray-500 text-sm">টাস্ক লোড হচ্ছে</p>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.page-loader-enter-active,
.page-loader-leave-active {
    transition: opacity 0.3s ease;
}

.page-loader-enter-from,
.page-loader-leave-to {
    opacity: 0;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>