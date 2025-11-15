<script setup>
import { usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, watch, computed } from 'vue';

const otpValues = ref(Array(6).fill('')); 
const countdown = ref('02:00');
const showResendButton = ref(false);
const timer = ref(null);
const timeLeft = ref(2 * 60);
const page = usePage();
const contact = page.props.contact;
const form = useForm({
    otp: '',
});

watch(otpValues, (newVal) => {
    form.otp = newVal.join('');
}, { deep: true });

const isOtpCompleted = computed(() => {
    return otpValues.value.every(digit => digit !== '') && 
           otpValues.value.join('').length === 6;
});

const handleInput = (event, index) => {
    const value = event.target.value;
    if (!/^\d*$/.test(value)) {
        otpValues.value[index] = '';
        return;
    }
    otpValues.value[index] = value;
    if (value.length === 1 && index < 5) {
        const nextInput = document.querySelector(`#otp-${index + 1}`);
        if (nextInput) nextInput.focus();
    }
};

const handleKeydown = (event, index) => {
    if (event.key === 'Backspace' && !otpValues.value[index] && index > 0) {
        const prevInput = document.querySelector(`#otp-${index - 1}`);
        if (prevInput) prevInput.focus();
    }
};

const handlePaste = (event) => {
    event.preventDefault();
    const pasteData = event.clipboardData.getData('text').trim();
    if (pasteData.length === 6 && /^\d+$/.test(pasteData)) {
        const digits = pasteData.split('');
        digits.forEach((char, index) => {
            otpValues.value[index] = char;
        });
    }
};

const startCountdown = () => {
    showResendButton.value = false;
    timeLeft.value = 2 * 60;

    if (timer.value) {
        clearInterval(timer.value);
    }

    timer.value = setInterval(() => {
        const minutes = Math.floor(timeLeft.value / 60);
        const seconds = timeLeft.value % 60;
        countdown.value = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (timeLeft.value <= 0) {
            clearInterval(timer.value);
            showResendButton.value = true;
        }
        timeLeft.value--;
    }, 1000);
};

const resendOTP = () => {
    otpValues.value = Array(6).fill('');
    startCountdown();
    form.post(route('otp.resend'),{
       onSuccess: () => {
            
        },
    })
    const firstInput = document.querySelector('#otp-0');
    if (firstInput) firstInput.focus();
};

const submitOTP = () => {
    form.otp = otpValues.value.join('');
    form.post(route('otp.verify.submit'), {
        onSuccess: () => {
            
        },
        onError: (errors) => {
            // Clear OTP on error and focus first input
            otpValues.value = Array(6).fill('');
            const firstInput = document.querySelector('#otp-0');
            if (firstInput) firstInput.focus();
        }
    });
};

onMounted(() => {
    startCountdown();
});

onUnmounted(() => {
    if (timer.value) {
        clearInterval(timer.value);
    }
});
</script>

<template>
    <GuestLayout>
        <Head title="ওটিপি" />
        <div class="text-center mb-2">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                </Link>
            </div>
            <h1 class="text-3xl font-bold text-dark">ওটিপি যাচাইকরণ</h1>
            <p class="text-gray-600 mt-2">আপনার মোবাইলে পাঠানো ৬-সংখ্যার কোডটি লিখুন</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="mb-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-mobile-alt text-4xl text-primary"></i>
                </div>
                <p class="text-gray-700">
                    আমরা <span class="font-semibold">{{ contact }}</span> নম্বরে একটি ওটিপি পাঠিয়েছি
                </p>
            </div>

            <form id="otpForm" @submit.prevent="submitOTP">
                <div class="mb-6">
                    <label class="block text-dark font-medium mb-3 text-center">৬-সংখ্যার ওটিপি কোড</label>
                    <div class="flex justify-between space-x-2 px-4">
                        <input 
                            v-for="(digit, index) in otpValues" 
                            :key="index" 
                            :id="`otp-${index}`"
                            v-model="otpValues[index]"
                            type="text" 
                            maxlength="1"
                            class="w-full h-10 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent transition-colors duration-200"
                            @input="(e) => handleInput(e, index)" 
                            @keydown="(e) => handleKeydown(e, index)"
                            @paste="handlePaste" 
                        />
                    </div>
                    <p class="error text-center text-red-500 py-2 xl:text-sm">
                        {{ form.errors.otp }}
                    </p>
                </div>

                <div class="mb-6 text-center">
                    <p v-if="!showResendButton" class="text-gray-600">
                        কোড পাননি? <span class="text-primary font-medium">{{ countdown }}</span> পরে আবার চেষ্টা করুন
                    </p>
                    <button v-if="showResendButton" type="button" @click="resendOTP"
                        class="text-primary font-medium hover:underline mt-2 transition-colors duration-200">
                        কোড পুনরায় পাঠান
                    </button>
                </div>

                <button 
                    type="submit" 
                    :disabled="!isOtpCompleted"
                    class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-700 font-medium transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed"
                >
                    যাচাই করুন
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-gray-600">
                    ভুল নম্বর ব্যবহার করেছেন?
                    <Link :href="route('login')"
                        class="text-primary font-medium hover:underline transition-colors duration-200">
                    ফিরে যান
                    </Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>