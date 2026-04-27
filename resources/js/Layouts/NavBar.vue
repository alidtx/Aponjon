<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import NotificationIcon from '@/Components/Icons/NotificationIcon.vue';
import DropDownIcon from '@/Components/Icons/DropDownIcon.vue';
import UserDropdown from '@/Components/UserDropdown.vue';
import MessageIcon from '@/Components/Icons/MessageIcon.vue';
import DropdownNavItem from '@/Components/DropdownNavItem.vue';

const props = defineProps({
    name: String,
    items: Array
});

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
                <div v-if="$slots.default" class="flex items-center space-x-4">
                    <slot />
                </div>
                <div v-else class="flex items-center space-x-4">
                    <MessageIcon />
                    <NotificationIcon />
                    <UserDropdown :name="props.name">
                        <template #icon>
                            <DropDownIcon />
                        </template>
                        <template #items>
                            <DropdownNavItem
                                v-for="item in props.items"
                                :key="item.label"
                                :href="item.route"
                                :method="item.method"
                                :label="item.label"
                                :icon="item.icon"
                            />
                        </template>
                    </UserDropdown>
                </div>
            </div>
        </div>
    </nav>
</template>