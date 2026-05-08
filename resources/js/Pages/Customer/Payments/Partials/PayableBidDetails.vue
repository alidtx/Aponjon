<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'


const props = defineProps({
    payableBids: {
        type: Object,
        default: () => null,
    },
})


const task          = computed(() => props.payableBids)
const isProcessing  = ref(false)
const showModal     = ref(false)
const paymentAmount = ref(0)


const formatBudget = (amount) => {
    if (amount == null) return '৳ ০'
    return new Intl.NumberFormat('bn-BD', {
        style: 'currency',
        currency: 'BDT',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount)
}

const formatDate = (date) => {
    if (!date) return 'N/A'
    return new Date(date).toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}


const STATUS_MAP = {
    paid:       { label: 'পরিশোধিত',    icon: 'fa-circle-check',     tw: 'bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20' },
    pending:    { label: 'বাকি',         icon: 'fa-clock',            tw: 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' },
    processing: { label: 'প্রক্রিয়াধীন', icon: 'fa-spinner fa-pulse', tw: 'bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20' },
}

const paymentStatus = computed(() =>
    STATUS_MAP[task.value?.payment_status] ?? {
        label: 'অনিষ্পন্ন', icon: 'fa-hourglass',
        tw: 'bg-slate-500/10 text-slate-400 ring-1 ring-slate-500/20',
    }
)

const isPaid = computed(() => task.value?.payment_status === 'paid')

const payableAmount = computed(() =>
    task.value?.settled_amount ?? task.value?.amount ?? task.value?.task?.budget ?? 0
)


const openModal = () => {
    paymentAmount.value = payableAmount.value
    showModal.value = true
}

const confirmPayment = () => {
    isProcessing.value = true
    router.post(`/payments/process/${task.value.id}`, {
        amount: paymentAmount.value,
        dispute_id: task.value.id,
    }, {
        onSuccess: () => { isProcessing.value = false; showModal.value = false },
        onError:   () => { isProcessing.value = false },
    })
}

const closeModal = () => {
    showModal.value = false
    paymentAmount.value = 0
}
</script>

<template>

    <div v-if="!task" class="flex flex-col items-center justify-center gap-4 py-20 text-slate-500">
        <div class="spinner"></div>
        <p class="text-sm">লোড হচ্ছে...</p>
    </div>

    <div v-else class="card-stagger flex flex-col gap-5">
        <div class="flex items-start justify-between gap-4 pb-5 border-b border-white/[0.06]">
            <div class="flex flex-col gap-1.5 min-w-0">
                <span class="flex items-center gap-1.5 text-xs text-slate-500 tracking-wide">
                    <i class="fas fa-hashtag text-[10px]"></i>
                    টাস্ক নম্বর: {{ task.task?.task_number || 'N/A' }}
                </span>
                <h2 class="text-xl font-bold text-slate-100 leading-snug">
                    {{ task.task?.title || 'N/A' }}
                </h2>
            </div>
            <span :class="['flex-shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold', paymentStatus.tw]">
                <i :class="['fas text-[11px]', paymentStatus.icon]"></i>
                {{ paymentStatus.label }}
            </span>
        </div>
        <div class="hero-card relative overflow-hidden rounded-2xl p-8 text-center">
            <div class="pointer-events-none absolute -top-16 left-1/2 -translate-x-1/2
                        w-80 h-52 bg-blue-500/20 blur-3xl rounded-full"></div>
            <div class="relative z-10 flex flex-col items-center gap-5">
                <p class="text-[11px] text-slate-400 uppercase tracking-widest">
                    পরিশোধযোগ্য অর্থের পরিমাণ
                </p>
                <p class="text-5xl font-black text-white tracking-tight leading-none">
                    {{ formatBudget(payableAmount) }}
                </p>

                <button
                    v-if="!isPaid"
                    @click="openModal"
                    :disabled="isProcessing"
                    class="inline-flex items-center gap-3 px-7 py-3 rounded-xl font-bold text-sm
                           text-white bg-blue-500 hover:bg-blue-400 hover:-translate-y-0.5
                           shadow-lg shadow-blue-500/30 hover:shadow-blue-400/40
                           disabled:opacity-50 disabled:cursor-not-allowed
                           transition-all duration-200"
                >
                    <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/20 text-[10px]">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'এখনই পরিশোধ করুন' }}
                </button>

                <div v-else class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                                   text-emerald-400 bg-emerald-500/10 ring-1 ring-emerald-500/20">
                    <i class="fas fa-circle-check"></i>
                    পেমেন্ট সম্পন্ন হয়েছে
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="glass-tile rounded-xl p-4 flex flex-col items-center gap-2 text-center">
                <i class="fas fa-coins text-emerald-400 text-base"></i>
                <span class="text-[10px] text-slate-500 uppercase tracking-wider">মূল বাজেট</span>
                <span class="text-base font-bold text-slate-100">
                    {{ formatBudget(task.amount ?? task.task?.budget) }}
                </span>
            </div>
            <div class="glass-tile rounded-xl p-4 flex flex-col items-center gap-2 text-center">
                <i class="fas fa-handshake text-blue-400 text-base"></i>
                <span class="text-[10px] text-slate-500 uppercase tracking-wider">নিষ্পত্তিকৃত অর্থ</span>
                <span class="text-base font-bold text-blue-400">
                    {{ formatBudget(task.settled_amount) }}
                </span>
            </div>
            <div class="glass-tile rounded-xl p-4 flex flex-col items-center gap-2 text-center">
                <i class="fas fa-calendar-check text-violet-400 text-base"></i>
                <span class="text-[10px] text-slate-500 uppercase tracking-wider">সমাপ্তির তারিখ</span>
                <span class="text-xs font-semibold text-slate-200 leading-snug">
                    {{ formatDate(task.updated_at ?? task.created_at) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div v-if="task.tasker" class="glass-tile rounded-xl p-5">
                <h4 class="section-label mb-4">
                    <i class="fas fa-user-check"></i> টাস্কারের তথ্য
                </h4>
                <div class="flex items-center gap-4">
                    <img
                        v-if="task.tasker.avatar"
                        :src="task.tasker.avatar"
                        alt="avatar"
                        class="w-12 h-12 rounded-full object-cover ring-2 ring-blue-500/20 flex-shrink-0"
                    />
                    <div v-else class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center
                                       bg-blue-500/10 ring-2 ring-blue-500/20 text-blue-400 text-lg">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex flex-col gap-0.5 min-w-0">
                        <p class="font-semibold text-slate-100 truncate">{{ task.tasker.name }}</p>
                        <p class="text-xs text-amber-400 flex items-center gap-1">
                            <i class="fas fa-star text-[10px]"></i>
                            {{ task.tasker.tasker_profile?.rating ?? 0 }} / 5
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                            {{ task.tasker.tasker_profile?.full_address || 'ঠিকানা নেই' }}
                        </p>
                    </div>
                </div>
            </div>
            <div v-if="task.task?.description" class="glass-tile rounded-xl p-5">
                <h4 class="section-label mb-4">
                    <i class="fas fa-clipboard-list"></i> কাজের বিবরণ
                </h4>
                <p class="text-sm text-slate-400 leading-relaxed line-clamp-5">
                    {{ task.task.description }}
                </p>
            </div>
        </div>
        <div class="glass-tile rounded-xl p-5">
            <h4 class="section-label mb-4">
                <i class="fas fa-receipt"></i> লেনদেন সংক্রান্ত তথ্য
            </h4>

            <div class="divide-y divide-white/[0.04]">
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-slate-500">বিতর্ক আইডি</span>
                    <span class="text-sm font-mono text-slate-300">#{{ task.id }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-slate-500">ট্রানজেকশন আইডি</span>
                    <span class="text-sm font-mono text-slate-300">{{ task.transaction_id || 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-slate-500">পেমেন্ট পদ্ধতি</span>
                    <span class="text-sm text-slate-300">{{ task.payment_method || 'N/A' }}</span>
                </div>
                <div v-if="task.payment_date" class="flex justify-between items-center py-3">
                    <span class="text-sm text-slate-500">পেমেন্টের তারিখ</span>
                    <span class="text-sm text-slate-300">{{ formatDate(task.payment_date) }}</span>
                </div>
            </div>
            <div v-if="task.settled_amount"
                 class="flex justify-between items-center mt-3 px-4 py-3.5
                        rounded-xl bg-emerald-500/5 ring-1 ring-emerald-500/15">
                <span class="text-sm font-semibold text-slate-300">নিষ্পত্তিকৃত অর্থ</span>
                <span class="text-lg font-black text-emerald-400">{{ formatBudget(task.settled_amount) }}</span>
            </div>
        </div>
    </div>

    <Teleport to="body">
        <Transition name="modal">
            <div
                v-if="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4
                       bg-black/60 backdrop-blur-md"
                @click.self="closeModal"
            >
                <div class="modal-box w-full max-w-sm rounded-2xl p-7 text-center">

                    <div class="w-14 h-14 rounded-full mx-auto mb-5 flex items-center justify-center
                                bg-blue-500/10 ring-1 ring-blue-500/20">
                        <i class="fas fa-shield-halved text-2xl text-blue-400"></i>
                    </div>

                    <h3 class="text-lg font-bold text-slate-100 mb-1">পেমেন্ট নিশ্চিত করুন</h3>
                    <p class="text-sm text-slate-500 mb-6">
                        আপনি নিচের অর্থ টাস্কারকে পরিশোধ করতে যাচ্ছেন
                    </p>

                    <div class="glass-tile rounded-xl p-4 mb-6 text-left flex flex-col gap-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">টাস্ক নম্বর</span>
                            <span class="font-mono text-slate-300">{{ task.task?.task_number }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">টাস্কার</span>
                            <span class="text-slate-300">{{ task.tasker?.name }}</span>
                        </div>
                        <div class="border-t border-white/[0.06] pt-3 flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-300">পরিশোধযোগ্য অর্থ</span>
                            <span class="text-2xl font-black text-blue-400">{{ formatBudget(paymentAmount) }}</span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button
                            @click="closeModal"
                            class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-slate-400
                                   bg-white/5 hover:bg-white/10 ring-1 ring-white/[0.07]
                                   transition-all duration-150"
                        >
                            বাতিল
                        </button>
                        <button
                            @click="confirmPayment"
                            :disabled="isProcessing"
                            class="flex-1 py-2.5 rounded-xl text-sm font-bold text-white
                                   bg-blue-500 hover:bg-blue-400
                                   shadow-lg shadow-blue-500/25
                                   disabled:opacity-50 disabled:cursor-not-allowed
                                   transition-all duration-150"
                        >
                            <i v-if="isProcessing" class="fas fa-spinner fa-pulse mr-1.5"></i>
                            {{ isProcessing ? 'প্রক্রিয়াধীন...' : 'নিশ্চিত করুন' }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>

.spinner {
    width: 36px; height: 36px;
    border: 3px solid rgba(79, 142, 247, 0.15);
    border-top-color: #4f8ef7;
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.hero-card {
    background: linear-gradient(135deg, #1a2340 0%, #1d1b38 100%);
    border: 1px solid rgba(79, 142, 247, 0.15);
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4);
}

.glass-tile {
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(255, 255, 255, 0.06);
}

.modal-box {
    background: #181b26;
    border: 1px solid rgba(255, 255, 255, 0.07);
    box-shadow: 0 24px 80px rgba(0, 0, 0, 0.65);
}


.section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    color: #60a5fa;   
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin: 0;
}

.card-stagger > * {
    animation: fadeUp 0.35s ease both;
}
.card-stagger > *:nth-child(1) { animation-delay: 0ms; }
.card-stagger > *:nth-child(2) { animation-delay: 55ms; }
.card-stagger > *:nth-child(3) { animation-delay: 105ms; }
.card-stagger > *:nth-child(4) { animation-delay: 150ms; }
.card-stagger > *:nth-child(5) { animation-delay: 190ms; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.modal-enter-active,
.modal-leave-active { transition: opacity 0.2s ease; }
.modal-enter-from,
.modal-leave-to     { opacity: 0; }

.modal-enter-active .modal-box {
    animation: scaleIn 0.22s ease both;
}
@keyframes scaleIn {
    from { transform: scale(0.93); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
</style>