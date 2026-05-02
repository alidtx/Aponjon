<script setup>

</script>


<template>
   <div class="flex-1 p-4">
                        <div class="flex-1 flex flex-col min-w-0 min-h-0 bg-white/50 backdrop-blur-sm h-full">
                            <div
                                class="px-5 py-4 border-b border-slate-200/80 bg-white/60 flex items-center justify-between shrink-0">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-primary  flex items-center justify-center shadow-md">
                                            <i class="fas fa-hashtag text-white text-lg"></i>
                                        </div>
                                        <span
                                            class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-base">#general ·  Chatroom</h3>
                                        <div class="flex items-center gap-2 text-xs text-slate-400">
                                            <i class="fas fa-globe-asia text-[10px]"></i>
                                            <span>Public group</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                            <span id="memberCount">0 members</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button
                                        class="w-8 h-8 rounded-lg hover:bg-slate-100 transition flex items-center justify-center text-slate-500">
                                        <i class="fas fa-phone-alt text-sm"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 rounded-lg hover:bg-slate-100 transition flex items-center justify-center text-slate-500">
                                        <i class="fas fa-video text-sm"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 rounded-lg hover:bg-slate-100 transition flex items-center justify-center text-slate-500">
                                        <i class="fas fa-ellipsis-v text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="messagesContainer"
                                class="flex-1 min-h-0 overflow-y-auto p-5 space-y-3 messages-scroll bg-gradient-to-b from-slate-50/30 to-white/30">
                                <div class="flex justify-center my-4">
                                    <div
                                        class="bg-slate-100/80 backdrop-blur-sm text-slate-500 text-xs px-4 py-1.5 rounded-full shadow-sm flex items-center gap-2 border border-slate-200">
                                        <i class="fas fa-plug text-indigo-400 text-[10px]"></i>
                                        <span>🔌 Reverb WebSocket active — start chatting</span>
                                    </div>
                                </div>

                                <div id="emptyState"
                                    class="flex flex-col items-center justify-center text-center py-12 opacity-70">
                                    <div
                                        class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-comment text-slate-400 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm font-medium">No messages yet</p>
                                    <p class="text-slate-300 text-xs mt-1">Be the first to say hello! 👋</p>
                                </div>
                            </div>
                            <div id="typingIndicatorBar"
                                class="px-5 py-1 h-6 text-xs text-indigo-500 flex items-center gap-1.5 transition-all duration-200 shrink-0">
                                <!-- Typing indicators appear here dynamically -->
                            </div>

                            <div class="p-4 bg-white/80 backdrop-blur-sm border-t border-slate-200/80 shrink-0">
                                <div
                                    class="flex items-end gap-2 bg-slate-50 rounded-2xl px-4 py-2 shadow-sm border border-slate-200 focus-within:ring-2 focus-within:ring-indigo-300 focus-within:border-transparent transition">
                                    <button id="emojiBtn"
                                        class="text-slate-400 hover:text-indigo-500 transition text-xl pb-1">
                                        <i class="far fa-smile-wink"></i>
                                    </button>
                                    <textarea id="messageInput" rows="1" placeholder="Type your message..."
                                        class="flex-1 bg-transparent border-0 focus:ring-0 outline-none text-slate-700 placeholder:text-slate-400 text-sm py-2 resize-none max-h-32"></textarea>
                                    <button id="attachBtn" class="text-slate-400 hover:text-indigo-500 transition pb-1">
                                        <i class="fas fa-paperclip text-sm"></i>
                                    </button>
                                    <button id="sendBtn"
                                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl p-2 px-4 text-sm font-medium transition shadow-md shadow-indigo-200 flex items-center gap-2">
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