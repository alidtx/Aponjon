<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    chatUsers: Array,
    authUser: Object,
    selectedUser: Object
})

const emit = defineEmits(['select-user'])

const searchQuery = ref('')

const filteredUsers = computed(() => {
    if (!searchQuery.value) return props.chatUsers
    return props.chatUsers.filter(user => 
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
})

function formatTime(date) {
    if (!date) return ''
    const d = new Date(date)
    const now = new Date()
    const diff = now - d
    
    if (diff < 86400000) { 
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    } else {
        return d.toLocaleDateString([], { month: 'short', day: 'numeric' })
    }
}
</script>

<template>
    <div class="w-80 text-white p-4">
        <div class="w-full h-full md:w-80 bg-white/90 backdrop-blur-sm border-r border-slate-200/80 flex flex-col shrink-0">
            <div class="p-5 border-b border-slate-200/80 bg-white/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                            <i class="fas fa-comment-dots text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Chat
                            </h2>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[11px] text-slate-500 font-medium">Real-time</span>
                            </div>
                        </div>
                    </div>
                    <button class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 transition flex items-center justify-center text-slate-500">
                        <i class="fas fa-sliders-h text-sm"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-4 border-b border-slate-200/80">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        v-model="searchQuery"
                        type="text" 
                        placeholder="Search conversations..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                    >
                </div>
            </div>
            
            <div class="flex-1 min-h-0 overflow-y-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-circle-users text-xs"></i> Messages — 
                        <span class="text-indigo-600">{{ filteredUsers.length }}</span>
                    </h3>
                </div>

                <div class="space-y-2">
                    <div 
                        v-for="user in filteredUsers" 
                        :key="user.id"
                        @click="emit('select-user', user)"
                        :class="[
                            'flex items-center justify-between p-3 rounded-xl cursor-pointer transition-all duration-200',
                            selectedUser?.id === user.id ? 'bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 shadow-sm' : 'hover:bg-slate-50 border border-transparent'
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center shadow-md text-white font-semibold">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-700">{{ user.name }}</p>
                                <p class="text-xs text-slate-500 truncate max-w-[150px]">
                                    {{ user.last_message?.message || 'No messages yet' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[10px] text-slate-400">{{ formatTime(user.last_message?.created_at) }}</span>
                            <span v-if="user.unread_count > 0" class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                {{ user.unread_count }}
                            </span>
                        </div>
                    </div>
                    
                    <div v-if="filteredUsers.length === 0" class="text-center py-8">
                        <i class="fas fa-inbox text-slate-300 text-3xl mb-2"></i>
                        <p class="text-slate-400 text-sm">No conversations yet</p>
                    </div>
                </div>

                <div class="mt-6 p-3 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100">
                    <div class="flex items-center gap-2 text-indigo-700 mb-1">
                        <i class="fas fa-bolt text-xs"></i>
                        <span class="text-xs font-semibold">Active Connection</span>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        WebSocket active • Real-time messaging
                    </p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-[10px] bg-white/60 px-2 py-0.5 rounded-full text-indigo-600">🔐 Encrypted</span>
                        <span class="text-[10px] bg-white/60 px-2 py-0.5 rounded-full text-indigo-600">⚡ Low latency</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>