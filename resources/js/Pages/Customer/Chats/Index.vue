<script setup>
import { Head } from '@inertiajs/vue3'
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import ChatSideBar from './Partials/ChatSideBar.vue';
import ChatContainer from './Partials/ChatContainer.vue';
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    chatUsers: Array,
    authUser: Object,
   selectedUserId: Number
})

const selectedUser = ref(null)
const messages = ref([])
const echoInstance = ref(null)

function openChat(user) {
    selectedUser.value = user
    fetchMessages(user.id)
    markMessagesAsRead(user.id)
}

async function fetchMessages(userId) {
    try {
        const response = await axios.get(route('customer.chats.messages',userId))
        messages.value = response.data
    } catch (error) {
        console.error('Error fetching messages:', error)
    }
}

async function markMessagesAsRead(userId) {
    try {
        await axios.post(route('customer.chats.mark-as-read', userId))

        const chatUser = props.chatUsers.find(u => u.id === userId)
        if (chatUser) {
            chatUser.unread_count = 0
        }
    } catch (error) {
        console.error('Error marking messages as read:', error)
    }
}

function handleNewMessage(message) {
    if (selectedUser.value && 
        (message.sender_id === selectedUser.value.id || message.receiver_id === selectedUser.value.id)) {
        messages.value.push(message)
    
        if (message.sender_id === selectedUser.value.id) {
            markMessagesAsRead(selectedUser.value.id)
        }
    }
    const chatUser = props.chatUsers.find(u => u.id === message.sender_id)
    if (chatUser) {
        chatUser.last_message = message
        if (selectedUser.value?.id !== message.sender_id) {
            chatUser.unread_count = (chatUser.unread_count || 0) + 1
        }
    }
}

onMounted(() => {
 
    if (window.Echo && props.authUser) {

        const channelName = `chat.${props.authUser.id}`
        
        echoInstance.value = window.Echo
            .private(channelName)
            .listen('.MessageSent', (e) => { 
                
                if (e && e.message) {
                    handleNewMessage(e.message)
                }
            })
            .subscribed(() => {
            
            })
    }
})
onMounted(() => {

    if (props.selectedUserId) {
        const user = props.chatUsers.find(
            u => u.id == props.selectedUserId
        )

        if (user) {
            openChat(user)
        }
    }

})

onUnmounted(() => {
    if (echoInstance.value) {
        echoInstance.value.stopListening('MessageSent')
    }
})
</script>

<template>
    <CustomerAuthenticatedLayout>
        <Head title="চ্যাঁট রুম" />
        <div class="lg:col-span-3">
            <div class="flex h-screen">
                <div class="w-full max-w-7xl mx-auto flex-1 min-h-0 bg-white/95 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden flex flex-col md:flex-row transition-all duration-300 border border-white/20">
                    <ChatSideBar 
                        :chat-users="chatUsers" 
                        :auth-user="authUser"
                        :selected-user="selectedUser"
                        @select-user="openChat"
                    />
                    <ChatContainer 
                        :selected-user="selectedUser"
                        :messages="messages"
                        :auth-user="authUser"
                        @message-sent="fetchMessages(selectedUser.id)"
                    />
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