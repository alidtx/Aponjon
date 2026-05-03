<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import ChatSideBar from './Partials/ChatSideBar.vue';
import ChatContainer from './Partials/ChatContainer.vue';
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'




const props = defineProps({
    chatUsers: Array,
    authUser: Object
})

const selectedUser = ref(null)
const messages = ref([])

function openChat(user) {
    selectedUser.value = user
}

onMounted(() => {
    window.Echo.private(`chat.${props.authUser.id}`)
        .listen('MessageSent', (e) => {
            messages.value.push(e.message)
        })
})
</script>

<template>
    <CustomerAuthenticatedLayout>

        <Head title="চ্যাট রুম" />
        <div class="lg:col-span-3">
            <div class="flex h-screen">
                <div class="w-full max-w-7xl mx-auto flex-1 min-h-0 bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row transition-all duration-300 border border-white/20">
                    <ChatSideBar/>
                    <ChatContainer/>
                </div>
            </div>

        </div>
    </CustomerAuthenticatedLayout>
</template>

<style scoped>

.messages-scroll::-webkit-scrollbar {
    width: 5px;
}

.messages-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.messages-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.messages-scroll::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>