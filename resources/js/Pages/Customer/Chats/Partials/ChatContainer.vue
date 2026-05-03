<script setup>
import { ref, watch, nextTick, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    selectedUser: Object,
    messages: Array,
    authUser: Object
})

const emit = defineEmits(['message-sent'])

const newMessage = ref('')
const messagesContainer = ref(null)
const isTyping = ref(false)
let typingTimeout = null

watch(() => props.selectedUser, () => {
    scrollToBottom()
})

watch(() => props.messages, () => {
    scrollToBottom()
}, { deep: true })

function scrollToBottom() {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
        }
    })
}

async function sendMessage() {
    if (!newMessage.value.trim() || !props.selectedUser) return
    
    try {
        await axios.post('/chats/send', {
            receiver_id: props.selectedUser.id,
            message: newMessage.value
        })
        
        newMessage.value = ''
        emit('message-sent')
    } catch (error) {
        console.error('Error sending message:', error)
    }
}

function handleTyping() {
    
}

function formatTime(date) {
    if (!date) return ''
    const d = new Date(date)
    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
}

function handleKeyPress(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault()
        sendMessage()
    }
}
</script>

<template>
    <div class="flex-1 p-4">
        <div class="flex-1 flex flex-col min-w-0 min-h-0 bg-white/50 backdrop-blur-sm h-full">
            
            <div class="px-5 py-4 border-b border-slate-200/80 bg-white/60 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center shadow-md text-white font-semibold">
                            {{ selectedUser ? selectedUser.name.charAt(0).toUpperCase() : '?' }}
                        </div>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">{{ selectedUser?.name || 'Select a chat' }}</h3>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="fas fa-circle text-[6px] text-green-500"></i>
                            <span>Active now</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-8 h-8 rounded-lg hover:bg-slate-100 transition flex items-center justify-center text-slate-500">
                        <i class="fas fa-phone-alt text-sm"></i>
                    </button>
                    <button class="w-8 h-8 rounded-lg hover:bg-slate-100 transition flex items-center justify-center text-slate-500">
                        <i class="fas fa-video text-sm"></i>
                    </button>
                </div>
            </div>
            
            <div ref="messagesContainer" class="flex-1 min-h-0 overflow-y-auto p-5 space-y-3 messages-scroll bg-gradient-to-b from-slate-50/30 to-white/30">
                <div v-if="!selectedUser" class="flex flex-col items-center justify-center text-center py-12">
                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                        <i class="fas fa-comments text-slate-400 text-3xl"></i>
                    </div>
                    <p class="text-slate-500 text-base font-medium">Select a conversation</p>
                    <p class="text-slate-400 text-sm mt-1">Choose a user to start chatting</p>
                </div>
                
                <div v-else-if="messages.length === 0" class="flex flex-col items-center justify-center text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                        <i class="fas fa-comment text-slate-400 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 text-sm font-medium">No messages yet</p>
                    <p class="text-slate-300 text-xs mt-1">Send a message to start the conversation! 👋</p>
                </div>
                
                <div v-else>
                    <div 
                        v-for="message in messages" 
                        :key="message.id"
                        :class="[
                            'flex',
                            message.sender_id === authUser.id ? 'justify-end' : 'justify-start'
                        ]"
                    >
                        <div 
                            :class="[
                                'max-w-[70%] rounded-2xl px-4 py-2',
                                message.sender_id === authUser.id 
                                    ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' 
                                    : 'bg-white border border-slate-200 text-slate-700'
                            ]"
                        >
                            <p class="text-sm break-words">{{ message.message }}</p>
                            <div 
                                :class="[
                                    'text-[10px] mt-1',
                                    message.sender_id === authUser.id ? 'text-indigo-200' : 'text-slate-400'
                                ]"
                            >
                                {{ formatTime(message.created_at) }}
                                <i v-if="message.sender_id === authUser.id" class="fas fa-check ml-1" :class="{ 'text-green-300': message.is_read }"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-5 py-1 h-6 text-xs text-indigo-500 flex items-center gap-1.5 transition-all duration-200 shrink-0">
                <span v-if="isTyping">{{ selectedUser?.name }} is typing...</span>
            </div>

            <div class="p-4 bg-white/80 backdrop-blur-sm border-t border-slate-200/80 shrink-0">
                <div class="flex items-end gap-2 bg-slate-50 rounded-2xl px-4 py-2 shadow-sm border border-slate-200 focus-within:ring-2 focus-within:ring-indigo-300 focus-within:border-transparent transition">
                    <button class="text-slate-400 hover:text-indigo-500 transition text-xl pb-1">
                        <i class="far fa-smile-wink"></i>
                    </button>
                    <textarea 
                        v-model="newMessage"
                        @keypress="handleKeyPress"
                        @input="handleTyping"
                        rows="1" 
                        placeholder="Type your message..."
                        :disabled="!selectedUser"
                        class="flex-1 bg-transparent border-0 focus:ring-0 outline-none text-slate-700 placeholder:text-slate-400 text-sm py-2 resize-none max-h-32"
                    ></textarea>
                    <button class="text-slate-400 hover:text-indigo-500 transition pb-1">
                        <i class="fas fa-paperclip text-sm"></i>
                    </button>
                    <button 
                        @click="sendMessage"
                        :disabled="!newMessage.trim() || !selectedUser"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl p-2 px-4 text-sm font-medium transition shadow-md shadow-indigo-200 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span class="hidden sm:inline">Send</span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-2 px-2">
                    <div class="text-[10px] text-slate-400 flex items-center gap-1">
                        <i class="fas fa-lock text-[8px]"></i>
                        <span>End-to-end encrypted via TLS</span>
                    </div>
                    <div class="text-[10px] text-slate-400">
                        <i class="far fa-keyboard"></i> Press ↵ to send
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>