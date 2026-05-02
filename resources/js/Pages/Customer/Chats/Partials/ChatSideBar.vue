<script setup>

</script>


<template>
  <div class="w-80 text-white p-4 ">
                        <div
                            class="w-full h-full md:w-80 bg-white/90 backdrop-blur-sm border-r border-slate-200/80 flex flex-col shrink-0">
                            <div class="p-5 border-b border-slate-200/80 bg-white/60">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-lg shadow-indigo-200">
                                            <i class="fas fa-comment-dots text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <h2
                                                class="text-lg font-bold bg-primary bg-clip-text text-transparent">
                                                 Chat</h2>
                                            <div class="flex items-center gap-1 mt-0.5">
                                                <span class="relative flex h-2 w-2">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                <span id="connectionStatus"
                                                    class="text-[11px] text-slate-500 font-medium">Real-time</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 transition flex items-center justify-center text-slate-500">
                                        <i class="fas fa-sliders-h text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1 min-h-0 overflow-y-auto p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h3
                                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                                        <i class="fas fa-circle-users text-xs"></i> Online — <span id="onlineCount"
                                            class="text-indigo-600">0</span>
                                    </h3>
                                    <i
                                        class="fas fa-search text-slate-300 text-xs cursor-pointer hover:text-slate-500"></i>
                                </div>

                                <div id="usersList" class="space-y-2">
                                    <div
                                        class="flex items-center justify-between p-2 rounded-xl bg-indigo-50/50 border border-indigo-100">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-primary flex items-center justify-center shadow-md">
                                                    <i class="fas fa-user-astronaut text-white text-sm"></i>
                                                </div>
                                                <span
                                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-700" id="currentUserName">You
                                                </p>
                                                <p class="text-xs text-green-600 flex items-center gap-1">
                                                    <span
                                                        class="w-1.5 h-1.5 bg-green-500 rounded-full inline-block"></span>
                                                    online
                                                </p>
                                            </div>
                                        </div>
                                        <i class="fas fa-ellipsis-h text-slate-300 text-xs"></i>
                                    </div>
                                </div>
                                <div
                                    class="mt-6 p-3 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100">
                                    <div class="flex items-center gap-2 text-indigo-700 mb-1">
                                        <i class="fas fa-bolt text-xs"></i>
                                        <span class="text-xs font-semibold"> Active</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed">
                                        WebSocket connection • Presence channel • Real-time messaging
                                    </p>
                                    <div class="flex gap-2 mt-2">
                                        <span
                                            class="text-[10px] bg-white/60 px-2 py-0.5 rounded-full text-indigo-600">🔐
                                            Encrypted</span>
                                        <span class="text-[10px] bg-white/60 px-2 py-0.5 rounded-full text-indigo-600">⚡
                                            Low
                                            latency</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

</template>