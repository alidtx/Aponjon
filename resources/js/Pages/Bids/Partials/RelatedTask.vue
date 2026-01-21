<script setup>

</script>

<template>

 <!-- Similar Tasks Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-dark mb-6">একই ধরনের টাস্কসমূহ</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Similar Task 1 -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-urgent hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-dark mb-2">ফ্ল্যাটের জন্য নতুন ইলেকট্রিক সেটআপ</h3>
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <span>উত্তরা, ঢাকা</span>
                        <i class="fas fa-clock ml-3 mr-1"></i>
                        <span>২ ঘন্টা আগে</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">নতুন ফ্ল্যাটে পুরো ইলেকট্রিক সিস্টেম সেটআপ করতে হবে।</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-dark">৳৪,০০০</span>
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">জরুরি</span>
                    </div>
                </div>
            </div>
            
            <!-- Similar Task 2 -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-normal hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-dark mb-2">অফিসের ইলেকট্রিক মেরামত</h3>
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <span>ধানমন্ডি, ঢাকা</span>
                        <i class="fas fa-clock ml-3 mr-1"></i>
                        <span>১ দিন আগে</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">অফিসের ইলেকট্রিক সিস্টেমে সমস্যা, মেরামত প্রয়োজন।</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-dark">৳২,৫০০</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">সাধারন</span>
                    </div>
                </div>
            </div>
            
            <!-- Similar Task 3 -->
            <div class="bg-white rounded-lg shadow-md border-l-4 border-emergency hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-dark mb-2">জরুরি কারেন্ট সমস্যা</h3>
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <span>বনানি, ঢাকা</span>
                        <i class="fas fa-clock ml-3 mr-1"></i>
                        <span>৪৫ মিনিট আগে</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-4">পুরো বিল্ডিংয়ে কারেন্ট নেই, জরুরি মেরামত প্রয়োজন।</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-dark">৳৩,০০০</span>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">ইমার্জেন্সি</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>