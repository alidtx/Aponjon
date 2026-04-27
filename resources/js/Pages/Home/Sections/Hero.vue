<script setup>

</script>

<template>
  <section id="home" class="hero-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">আপনার কাজ আমাদের <span class="text-accent">দায়িত্ব</span></h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                বাংলাদেশের প্রথম হাইপারলোকাল টাস্ক ও এর্যান্ড সার্ভিস। আপনার দৈনন্দিন কাজগুলো আমরা করিয়ে দেব সহজেই।
            </p>
            <div class="bg-white rounded-xl p-6 shadow-2xl max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-dark text-left mb-2 font-medium">আপনি কোন সেবা চান?</label>
                        <select class="w-full p-3 border border-gray-300 rounded-lg text-dark">
                            <option>সেবা নির্বাচন করুন</option>
                            <option>বাড়ি পরিষ্কার</option>
                            <option>ইলেকট্রিক কাজ</option>
                            <option>প্লাম্বিং কাজ</option>
                            <option>ফার্নিচার অ্যাসেম্বলি</option>
                            <option>কুরিয়ার সার্ভিস</option>
                            <option>অন্যান্য</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-dark text-left mb-2 font-medium">লোকেশন</label>
                        <div class="flex">
                            <input type="text" placeholder="আপনার এলাকা লিখুন" class="flex-1 p-3 border border-gray-300 rounded-l-lg text-dark">
                            <button class="bg-primary text-white px-6 rounded-r-lg hover:bg-blue-700">
                                <i class="fas fa-map-marker-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="md:self-end">
                        <button class="w-full md:w-auto bg-accent text-white px-8 py-3 rounded-lg hover:bg-orange-600 font-medium">
                            টাস্ক পোস্ট করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>