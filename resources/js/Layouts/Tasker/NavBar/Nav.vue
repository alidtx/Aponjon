<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import NotificationIcon from '@/Components/Icons/NotificationIcon.vue';
</script>


<template>
    <nav class="bg-white shadow-lg ">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <Link :href="route('home')">
                            <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                    </Link>
                </div>
                <div class="flex items-center space-x-4">
                    <NotificationIcon/>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex cursor-pointer items-center justify-start rounded-full border border-transparent p-0.5 transition duration-300 hover:bg-gray-50 focus:border-primary-500 focus:outline-none md:w-[125px] md:gap-2">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-primary-200">
                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=0D8F81&color=fff&size=32"
                                    alt="Profile" class="h-full w-full rounded-full object-cover">
                            </div>

                            <strong
                                class="line-clamp-1 w-auto font-inter text-sm font-medium text-gray-700 md:w-[50px]">
                                <span class="hidden md:block">John Doe</span>
                            </strong>

                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" fill="none"
                                class="hidden w-4 shrink-0 text-gray-500 transition-transform duration-200 md:flex"
                                :class="{ 'rotate-180': open }">
                                <path fill="currentColor"
                                    d="M4.24 6.114.416 1.651A1 1 0 0 1 1.175 0h7.65a1 1 0 0 1 .76 1.65L5.759 6.115a1 1 0 0 1-1.518 0Z">
                                </path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 z-50 mt-2 drop-shadow-xl w-[280px] ltr:origin-top-right rtl:origin-top-left end-0"
                            style="display: none;">

                            <div class="rounded-lg border border-gray-200 p-2 bg-white">
                                <div class="space-y-px">

                                    <div class="mb-1 rounded border border-gray-200 bg-gray-50 p-3 text-center">
                                        <p class="font-inter text-xs text-gray-500">Available Balance (BDT)</p>
                                        <strong class="font-inter text-lg font-medium text-gray-900">10,500.00</strong>
                                    </div>
                                    <a href="profile.html"
                                        class="flex w-full items-center text-nowrap rounded-md p-2 font-inter text-gray-700 transition duration-300 ease-in-out hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                            class="mr-2 w-5 text-gray-500">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M10.133 9.058a1.516 1.516 0 0 0-.275 0A3.683 3.683 0 0 1 6.3 5.367c0-2.042 1.65-3.7 3.7-3.7a3.696 3.696 0 0 1 .133 7.392ZM5.967 12.133c-2.017 1.35-2.017 3.55 0 4.892 2.291 1.533 6.05 1.533 8.341 0 2.017-1.35 2.017-3.55 0-4.892-2.283-1.525-6.041-1.525-8.341 0Z">
                                            </path>
                                        </svg>
                                        <span class="text-sm">User Profile</span>
                                    </a>

                                    <a href="tasker-profile.html"
                                        class="flex w-full items-center text-nowrap rounded-md p-2 font-inter text-gray-700 transition duration-300 ease-in-out hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                            class="mr-2 w-5 text-gray-500">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="10" stroke-width="1.5"
                                                d="M1.895 16.993h16.21M15.732 17v-3.286M2.705 16.993V5.225C2.705 3.745 3.442 3 4.908 3h4.59c1.467 0 2.197.744 2.197 2.225v11.768M5.43 6.86H9.08M5.43 9.624H9.08m-1.842 7.369V14.23m8.51-5.424c-.899 0-1.62.722-1.62 1.621V12.1c0 .899.721 1.621 1.62 1.621.9 0 1.621-.722 1.621-1.621v-1.673c0-.899-.722-1.62-1.62-1.62Z">
                                            </path>
                                        </svg>
                                        <span class="text-sm">Tasker Profile</span>
                                    </a>

                                    <a href="my-tasks.html"
                                        class="flex w-full items-center text-nowrap rounded-md p-2 font-inter text-gray-700 transition duration-300 ease-in-out hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                            class="mr-2 w-5 text-gray-500">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M6.5 3h8c2 0 3 1 3 3v8c0 2-1 3-3 3h-8c-2 0-3-1-3-3V6c0-2 1-3 3-3Z">
                                            </path>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5" d="M8 11h4M8 7h4"></path>
                                        </svg>
                                        <span class="text-sm">My Tasks</span>
                                    </a>

                                    <a href="change-password.html"
                                        class="flex w-full items-center text-nowrap rounded-md p-2 font-inter text-gray-700 transition duration-300 ease-in-out hover:bg-gray-100">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20"
                                            xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 text-gray-500">
                                            <path
                                                d="M5.91332 14.3885L7.75296 16.2289M16.2313 12.3401C14.5837 13.9804 12.2241 14.4846 10.1525 13.8364L6.38523 17.5972C6.11328 17.8772 5.57738 18.0453 5.19346 17.9893L3.44979 17.7492C2.8739 17.6692 2.33801 17.1251 2.25002 16.549L2.01007 14.8046C1.95408 14.4205 2.13804 13.8844 2.40199 13.6124L6.16127 9.8516C5.52139 7.77118 6.0173 5.4107 7.66498 3.77036C10.0245 1.40988 13.8558 1.40988 16.2233 3.77036C18.5909 6.13084 18.5909 9.97963 16.2313 12.3401ZM13.1999 7.99523C13.1999 8.6581 12.6628 9.19547 12.0001 9.19547C11.3375 9.19547 10.8004 8.6581 10.8004 7.99523C10.8004 7.33235 11.3375 6.79498 12.0001 6.79498C12.6628 6.79498 13.1999 7.33235 13.1999 7.99523Z"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.5"></path>
                                        </svg>
                                        <span class="text-sm">Change Password</span>
                                    </a>
                                    <div class="border-t border-gray-200 my-1"></div>

                                    <form method="POST" action="logout.html">
                                        <button type="submit"
                                            class="flex w-full items-center text-nowrap rounded-md p-2 font-inter text-red-600 transition duration-300 ease-in-out hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                                class="mr-2 w-5 text-red-500">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12.61 6.26C12.35 3.236 10.793 2 7.381 2h-.11C3.508 2 2 3.504 2 7.26v5.48C2 16.495 3.507 18 7.272 18h.109c3.385 0 4.943-1.218 5.221-4.193M7.474 9.992h9.583m-1.878-2.816L18 9.992l-2.821 2.815">
                                                </path>
                                            </svg>
                                            <span class="text-sm">Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>