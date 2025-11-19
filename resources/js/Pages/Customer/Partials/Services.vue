<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    serviceCategories: {
        type: Object,
        default: () => []
    }
})

const services = computed(() => props.serviceCategories.data || [])
const scrollContainer = ref(null);
const selectedService = ref(null);
const scrollLeft = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy({ left: -300, behavior: 'smooth' });
    }
};

const scrollRight = () => {
    if (scrollContainer.value) {
        scrollContainer.value.scrollBy({ left: 300, behavior: 'smooth' });
    }
};
const selectService = (serviceId) => {
    console.log(serviceId);
    selectedService.value = serviceId;
};
</script>

<template>
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-dark">সেবা নির্বাচন করুন</h3>
            <div class="flex space-x-2">
                <button @click="scrollLeft"
                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button @click="scrollRight"
                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>

        <div class="relative">
            <div ref="scrollContainer" class="flex space-x-4 overflow-x-auto scrollbar-hide scroll-smooth py-2"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                <div v-if="services.length > 0" v-for="service in services" :key="service.id"
                    @click="selectService(service.id)" :class="[
                        'service-option flex-shrink-0 w-48 border-2 rounded-lg p-4 cursor-pointer transition-all hover:shadow-md',
                        selectedService === service.id
                            ? 'border-primary bg-blue-50 shadow-md'
                            : 'border-gray-200 hover:border-primary'
                    ]">
                    <div class="flex flex-col items-center text-center">
                        <i :class="service.icon + ' text-2xl text-primary mb-3'"></i>
                        <h4 class="font-bold text-dark text-sm mb-1">{{ service.name }}</h4>
                    </div>
                </div>
                <div v-else class="flex-shrink-0 w-full text-center py-8 text-gray-500">
                    কোনো সেবা পাওয়া যায়নি
                </div>
            </div>
        </div>
        <input type="hidden" name="selected_service" :value="selectedService">
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.service-option {
    transition: all 0.3s ease;
}
</style>