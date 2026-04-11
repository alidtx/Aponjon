<script setup>

</script>



<template>

    <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-dark mb-6">অ্যাসাইনড টাস্কস</h2>
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-8">
                <button class="py-2 px-1 border-b-2 border-primary text-primary font-medium">
                    চলমান (৫)
                </button>
                <button class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                    সম্পন্ন (৪৫)
                </button>
                <button class="py-2 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                    শিডিউলড (৩)
                </button>
            </nav>
        </div>
        <div class="space-y-4">
            <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-dark">বাসার ইলেকট্রিক ওয়্যারিং</h3>
                        <p class="text-gray-600 text-sm">রহিমা আক্তার • ধানমন্ডি, ঢাকা</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                        আজ ২:০০ PM
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-dark">মূল্য: ৳২,৫০০</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-gray-600">আপনার আয়: ৳২,২৫০</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i> আনুমানিক: ৩ ঘন্টা
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span>যোগাযোগ: ০১৭XX-XXXXXX</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            <i class="fas fa-phone mr-1"></i>কল
                        </button>
                        <button class="px-3 py-1 bg-primary text-white rounded hover:bg-blue-700 text-sm">
                            শুরু করুন
                        </button>
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg font-bold text-dark">অফিস এসি সার্ভিসিং</h3>
                        <p class="text-gray-600 text-sm">আহমেদ হাসান • গুলশান, ঢাকা</p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        আগামীকাল ১১:০০ AM
                    </span>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-sm">
                        <span class="font-medium text-dark">মূল্য: ৳১,২০০</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-gray-600">আপনার আয়: ৳১,০৮০</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i> আনুমানিক: ২ ঘন্টা
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span>যোগাযোগ: ০১৮XX-XXXXXX</span>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 text-sm">
                            রিসchedules
                        </button>
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                            বাতিল
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>