<script setup>
import { ref, computed, watch } from 'vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    serviceCategories: {
        type: Object,
        default: () => []
    },
    modelValue: {
        type: [String, Number],
        default: null
    },
    error: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['update:modelValue'])
const services = computed(() => props.serviceCategories.data || props.serviceCategories || [])
const scrollContainer = ref(null);
const selectedService = ref(props.modelValue);
const hasInteracted = ref(false);

watch(() => props.modelValue, (newValue) => {
    selectedService.value = newValue;
});

watch(() => props.error, (newError) => {
    if (newError) {
        hasInteracted.value = false;
    }
});

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
    selectedService.value = serviceId;
    hasInteracted.value = true;
    emit('update:modelValue', serviceId);
};

const shouldShowError = computed(() => {
    return props.error && !hasInteracted.value;
});
</script>

<template>
    <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-xl font-bold text-dark">সেবা নির্বাচন করুন <span class="text-red-500 text-sm font-medium">*</span></h3>
            <div class="flex space-x-2">
                <button 
                    type="button" 
                    @click="scrollLeft"
                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors"
                >
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button 
                    type="button" 
                    @click="scrollRight"
                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors"
                >
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>

        <div class="relative">
            <!-- Error Display -->
            <InputError v-if="shouldShowError" class="mb-4" :message="error" />
            
            <div 
                ref="scrollContainer" 
                class="flex space-x-4 overflow-x-auto scrollbar-hide scroll-smooth py-2"
                style="scrollbar-width: none; -ms-overflow-style: none;"
            >
                <div 
                    v-if="services.length > 0" 
                    v-for="service in services" 
                    :key="service.id"
                    @click="selectService(service.id)" 
                    :class="[
                        'service-option flex-shrink-0 w-48 border-2 rounded-lg p-4 cursor-pointer transition-all duration-300 hover:shadow-md',
                        selectedService === service.id
                            ? 'border-primary bg-blue-50 shadow-md'
                            : 'border-gray-200 hover:border-primary',
                        shouldShowError && !selectedService ? 'border-red-300 bg-red-50' : ''
                    ]"
                >
                    <div class="flex flex-col items-center text-center">
                        <i :class="service.icon + ' text-2xl text-primary mb-3'"></i>
                        <h4 class="font-bold text-dark text-sm mb-1">{{ service.name }}</h4>
                    </div>
                    <div v-if="shouldShowError && !selectedService" class="absolute top-2 right-2">
                        <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                    </div>
                </div>
                
                <div v-else class="flex-shrink-0 w-full text-center py-8 text-gray-500">
                    কোনো সেবা পাওয়া যায়নি
                </div>
            </div>
        </div>
        
        <input type="hidden" name="category_id" :value="selectedService">
        
        <div v-if="selectedService && services.length > 0" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm">
                <i class="fas fa-check-circle mr-2"></i>
                নির্বাচিত সেবা: 
                <strong>{{ services.find(s => s.id === selectedService)?.name }}</strong>
            </p>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.service-option {
    transition: all 0.3s ease;
    position: relative; 
}
.border-red-300 {
    border-color: #fca5a5;
    transition: border-color 0.3s ease;
}

.bg-red-50 {
    background-color: #fef2f2;
}
</style>