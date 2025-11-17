<script setup>
import { ref } from 'vue';

const services = ref([
    { id: 1, name: 'ইলেকট্রিক কাজ', icon: 'fas fa-tools', price: 'শুরু ৳৩০০ থেকে' },
    { id: 2, name: 'প্লাম্বিং কাজ', icon: 'fas fa-faucet', price: 'শুরু ৳২৫০ থেকে' },
    { id: 3, name: 'ক্লিনিং সার্ভিস', icon: 'fas fa-broom', price: 'শুরু ৳৫০০ থেকে' },
    { id: 4, name: 'অ্যাসেম্বলি সার্ভিস', icon: 'fas fa-puzzle-piece', price: 'শুরু ৳৪০০ থেকে' },
    { id: 5, name: 'পেইন্টিং কাজ', icon: 'fas fa-paint-roller', price: 'শুরু ৳৮০০ থেকে' },
    { id: 6, name: 'এসি সার্ভিস', icon: 'fas fa-wind', price: 'শুরু ৳৬০০ থেকে' },
    { id: 7, name: 'কার্পেন্টারি', icon: 'fas fa-hammer', price: 'শুরু ৳৪০০ থেকে' },
    { id: 8, name: 'ইলেকট্রনিক্স', icon: 'fas fa-tv', price: 'শুরু ৳৩৫০ থেকে' },
    { id: 9, name: 'গার্ডেনিং', icon: 'fas fa-leaf', price: 'শুরু ৳৩০০ থেকে' },
    { id: 10, name: 'মোবাইল রিপেয়ার', icon: 'fas fa-mobile-alt', price: 'শুরু ৳২০০ থেকে' }
]);

const scrollContainer = ref(null);

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
            <div ref="scrollContainer" 
                 class="flex space-x-4 overflow-x-auto scrollbar-hide scroll-smooth py-2"
                 style="scrollbar-width: none; -ms-overflow-style: none;">
                <div v-for="service in services" :key="service.id"
                    class="service-option flex-shrink-0 w-48 border-2 border-gray-200 rounded-lg p-4 hover:border-primary cursor-pointer transition-all hover:shadow-md">
                    <div class="flex flex-col items-center text-center">
                        <i :class="service.icon + ' text-2xl text-primary mb-3'"></i>
                        <h4 class="font-bold text-dark text-sm mb-1">{{ service.name }}</h4>
                        <p class="text-xs text-gray-600">{{ service.price }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>