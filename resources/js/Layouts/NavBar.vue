<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import NotificationIcon from '@/Components/Icons/NotificationIcon.vue';
import DropDownIcon from '@/Components/Icons/DropDownIcon.vue';
import { MenuItem } from '@headlessui/vue'
import UserDropdown from '@/Components/UserDropdown.vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import LogOutIcon from '@/Components/Icons/LogOutIcon.vue';
import MessageIcon from '@/Components/Icons/MessageIcon.vue';

const page = usePage();
const auth = page.props.auth;
const user = auth?.user;
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
                    <MessageIcon />
                    <NotificationIcon />
                    <UserDropdown name="Ali Rimon">

                        <template #icon>
                            <DropDownIcon />
                        </template>

                        <template #items>
                            <MenuItem v-slot="{ active }">
                            <Link :href="route('tasker.profile.edit', user?.id)" :class="[
                                active ? 'bg-primary text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm'
                            ]">
                                <EditIcon class="mr-2 h-5 w-5 text-violet-400" />
                                আপনার প্রোফাইল
                            </Link>
                            </MenuItem>

                            <MenuItem v-slot="{ active }">
                            <Link :href="route('logout')" method="post" as="button" :class="[
                                active ? 'bg-primary text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm'
                            ]">
                                <LogOutIcon class="mr-2 h-5 w-5 text-violet-400" />
                                লগ আউট করুন
                            </Link>
                            </MenuItem>
                        </template>

                    </UserDropdown>
                </div>
            </div>
        </div>
    </nav>
</template>