<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'


onMounted(() => {
    initFlowbite()
})

</script>

<template>
    <div id="accordion-collapse" data-accordion="collapse"
        class="mt-4 rounded-lg border border-yellow-200 overflow-hidden bg-yellow-50">
        <h2 id="accordion-collapse-heading-special">
            <button type="button"
                class="flex items-center justify-between w-full p-4 font-medium text-yellow-800 hover:bg-yellow-100 gap-3"
                data-accordion-target="#accordion-collapse-body-special" aria-expanded="false"
                aria-controls="accordion-collapse-body-special">
                <span>বিশেষ নির্দেশনা</span>
                <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0 text-yellow-700" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m5 15 7-7 7 7" />
                </svg>
            </button>
        </h2>

        <div id="accordion-collapse-body-special" class="hidden border-t border-yellow-200"
            aria-labelledby="accordion-collapse-heading-special">
            <div class="p-4">
                <ul class="list-disc pl-5 space-y-1 text-yellow-700">
                    <li>স্থানীয় ইলেকট্রিক সাপ্লাই কোম্পানির রেগুলেশন অনুসরণ করতে হবে</li>
                    <li>সব কাজের ছবি তুলে রাখতে হবে</li>
                    <li>সামগ্রী সরবরাহ করা হবে না, শুধুমাত্র শ্রম</li>
                    <li>কাজ শেষ হবার পর ইলেকট্রিক বিল্ডিং কোড সার্টিফিকেট প্রয়োজন</li>
                </ul>
            </div>
        </div>
    </div>
</template>