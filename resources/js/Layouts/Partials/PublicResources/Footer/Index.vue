<script setup>
import MenuItem from '@/Layouts/MenuItem.json';
import { usePage } from '@inertiajs/vue3';
const page = usePage()
const siteConfig = page.props.siteConfig



</script>


<template>

    <footer class="bg-dark text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-white"></i>
                        </div>
                        <span class="text-xl font-bold">আপন<span class="text-primary">জন</span></span>
                    </div>
                    <p class="text-gray-400 mb-4">বাংলাদেশের বিশ্বস্ত হাইপারলোকাল টাস্ক ও এর্যান্ড সার্ভিস প্ল্যাটফর্ম
                    </p>
                    <div class="flex space-x-4">
                        <a :href="siteConfig.social_link.facebook.url" target="_blank" class="text-gray-400 hover:text-white"><i :class="siteConfig.social_link.facebook.icon" ></i></a>
                        <a :href="siteConfig.social_link.linkedin.url" class="text-gray-400 hover:text-white"><i :class="siteConfig.social_link.linkedin.icon"></i></a>
                        <a :href="siteConfig.social_link.instagram.url" class="text-gray-400 hover:text-white"><i :class="siteConfig.social_link.instagram.icon"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">দ্রুত লিংক</h3>
                    <ul class="space-y-2">
                        <li v-for="(item, index) in MenuItem.HomeMenus" :key="index">
                            <a :href="item.href" class="text-gray-400 hover:text-white">
                                {{ item.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold mb-4">সাপোর্ট</h3>
                    <ul class="space-y-2">
                        <li><a :href="siteConfig.supports.help_center.url" target="_blank" class="text-gray-400 hover:text-white">{{ siteConfig.supports.help_center.label }}</a></li>
                        <li><a :href="siteConfig.supports.contact.url" target="_blank" class="text-gray-400 hover:text-white">{{siteConfig.supports.contact.label}}</a></li>
                        <li><a :href="siteConfig.supports.privacy.url" target="_blank" class="text-gray-400 hover:text-white">{{siteConfig.supports.privacy.label}}</a></li>
                        <li><a :href="siteConfig.supports.terms.url" target="_blank" class="text-gray-400 hover:text-white">{{siteConfig.supports.terms.label}}</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4">যোগাযোগ</h3>
                    <div class="space-y-2 text-gray-400">
                        <p class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            {{ siteConfig.address.head_office.address_line }}
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            {{ siteConfig.support_phone }}
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            {{ siteConfig.support_email }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ new Date().getFullYear() }} {{ siteConfig.name }}. সকল স্বত্ব সংরক্ষিত।</p>
            </div>
        </div>
    </footer>

</template>