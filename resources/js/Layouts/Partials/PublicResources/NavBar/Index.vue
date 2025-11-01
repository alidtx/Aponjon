<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import MenuItem from '@/Layouts/MenuItem.json';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean
});
</script>

<template>
  <nav v-if="canLogin" class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center py-4">

        <Link :href="route('home')">
        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
        </Link>

        <div class="hidden md:flex items-center space-x-8">
          <a v-for="(item, index) in MenuItem.HomeMenus" :key="index" :href="item.href"
            class="text-dark hover:text-primary font-medium">
            {{ item.name }}
          </a>
        </div>

        <div class="hidden md:flex items-center space-x-4">

          <Link v-if="$page.props.auth.user" :href="route('dashboard')"
            class="flex items-center space-x-2 px-4 py-2 text-dark font-medium hover:text-primary rounded-md ring-1 ring-transparent transition">

          <img :src="$page.props.auth.user.avatar || '/img/avatars/avatar.png'" alt="User Avatar"
            class="w-8 h-8 rounded-full object-cover border border-gray-300" />

          <span>আমার একাউন্ট</span>
          </Link>

          <template v-else>
            <Link :href="route('login')"
              class="px-4 py-2 text-dark font-medium hover:text-primary rounded-md ring-1 ring-transparent transition">
            লগইন
            </Link>

            <Link v-if="canRegister" :href="route('register')"
              class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 font-medium">
            রেজিস্টার
            </Link>
          </template>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-dark">
          <i class="fas fa-bars text-xl"></i>
        </button>

      </div>
    </div>
  </nav>
</template>
