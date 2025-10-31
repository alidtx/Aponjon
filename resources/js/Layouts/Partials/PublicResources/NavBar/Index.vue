<script setup>

</script>


<template>
         <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                        <i class="fas fa-hands-helping text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-dark">Shei<span class="text-primary">Shohoj</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-dark hover:text-primary font-medium">হোম</a>
                    <a href="#services" class="text-dark hover:text-primary font-medium">সেবাসমূহ</a>
                    <a href="#how-it-works" class="text-dark hover:text-primary font-medium">কিভাবে কাজ করে</a>
                    <a href="#taskers" class="text-dark hover:text-primary font-medium">টাস্কার</a>
                    <a href="#about" class="text-dark hover:text-primary font-medium">আমাদের সম্পর্কে</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <button class="px-4 py-2 text-dark font-medium hover:text-primary">লগইন</button>
                    <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
                        রেজিস্টার
                    </button>
                    <button class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-orange-600 font-medium">
                        টাস্কার হোন
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-dark">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>
</template>