<script setup>
import CustomerAuthenticatedLayout from '@/Layouts/CustomerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import { onMounted, ref, defineAsyncComponent } from 'vue'



const PendingBidsTab = defineAsyncComponent(() => import('./Tabs/PendingBidsTab.vue'))
const AcceptedBidsTab = defineAsyncComponent(() => import('./Tabs/AcceptedBidsTab.vue'))
const InProgressBidsTab = defineAsyncComponent(() => import('./Tabs/InProgressBidsTab.vue'))
const CompletedBidsTab = defineAsyncComponent(() => import('./Tabs/CompletedBidsTab.vue'))

const categories = ['কাজের আবেদন গুলো', 'গৃহীত কাজগুলো','চলামান কাজ গুলো','কমপ্লিটেড কাজ গুলো']

const loading = ref(false)
const pendingBid = ref([])
const bidAccepted = ref([])
const bidInprogress = ref([])
const taskCompleted = ref([])
const perPage = ref(5)
const error = ref(null)

const tabsLoaded = ref({
  pending: true,
  bidAccepted: false,
  bidInprogress: false,
  completed: false
})

const waitingForAcceptance = async () => {
  loading.value = true
  try {
    const response = await axios.get(route('customer.bids.waiting'))
    pendingBid.value = response.data.data
  } catch (err) {
    error.value = 'Failed to fetch pending bids list.'
  } finally {
    loading.value = false
  }
}

const accepted = async () => {
  if (tabsLoaded.value.bidAccepted) return

  loading.value = true
  try {
    const response = await axios.get(route('customer.bids.accepted'))
    bidAccepted.value = response.data.data
    tabsLoaded.value.bidAccepted = true
  } catch (err) {
    error.value = 'Failed to fetch bid in progress list.'
  } finally {
    loading.value = false
  }
}

const InProgress = async () => {
  if (tabsLoaded.value.bidInprogress) return

  loading.value = true
  try {
    const response = await axios.get(route('customer.bids.in-progress'))
    bidInprogress.value = response.data.data
    tabsLoaded.value.bidInprogress = true
  } catch (err) {
    error.value = 'Failed to fetch bid in progress list.'
  } finally {
    loading.value = false
  }
}

const Taskcompleted = async () => {
  if (tabsLoaded.value.completed) return

  loading.value = true
  try {
    const response = await axios.get(route('customer.tasks.completed'))
    taskCompleted.value = response.data.data
    tabsLoaded.value.completed = true
  } catch (err) {
    error.value = 'Failed to fetch task completed list.'
  } finally {
    loading.value = false
  }
}

const handleTabChange = (index) => {
  if (index === 1 && !tabsLoaded.value.bidAccepted) {
    accepted()
  }else if (index === 2 && !tabsLoaded.value.bidInprogress) {
    InProgress()
  }
   else if (index === 3 && !tabsLoaded.value.completed) {
    Taskcompleted()
  }
}

onMounted(() => {
  waitingForAcceptance()
})

</script>



<template>
  <CustomerAuthenticatedLayout>

    <Head title="বিড" />
    <div class="lg:col-span-3">
      <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">আবেদনকৃত কাজসমূহ</h2>

        <TabGroup @change="handleTabChange">
          <div class="border-b border-gray-200">
            <TabList class="flex space-x-8">
              <Tab v-for="(category, index) in categories" :key="index" v-slot="{ selected }"
                class="focus:outline-none">
                <button :class="[
                  'py-2 px-1 font-medium text-sm focus:outline-none border-b-2 transition-colors',
                  selected
                    ? 'border-blue-500 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                ]">
                  {{ category }}
                  <span class="ml-2 px-2 py-0.2 text-xs rounded-full" :class="{
                    'bg-yellow-100 text-yellow-800': index === 0,
                    'bg-green-100 text-green-800': index === 1,
                    'bg-blue-100 text-red-800': index === 2,
                    'bg-red-100 text-red-800': index === 3
                  }">
                    <template v-if="index === 0">
                      {{ pendingBid.length }}
                    </template>
                    <template v-else-if="index === 1">
                      {{ tabsLoaded.bidAccepted ? bidAccepted.length : '?' }}
                    </template>
                     <template v-else-if="index === 2">
                      {{ tabsLoaded.bidInprogress ? bidInprogress.length : '?' }}
                    </template>
                    <template v-else>
                      {{ tabsLoaded.completed ? taskCompleted.length : '?' }}
                    </template>
                  </span>
                </button>
              </Tab>
            </TabList>
          </div>

          <TabPanels class="mt-6">

            <TabPanel>
              <PendingBidsTab :pending-bid="pendingBid" :loading="loading" @accept-bid="handleAcceptBid"
                @refresh="waitingForAcceptance" />
            </TabPanel>

            <TabPanel>
              <AcceptedBidsTab :bid-accepted="bidAccepted" :loading="loading && !tabsLoaded.bidAccepted"
                :is-loaded="tabsLoaded.bidAccepted" />
            </TabPanel>
             <TabPanel>
              <InProgressBidsTab v-if="tabsLoaded.bidInprogress" :bid-inprogress="bidInprogress"
                :loading="loading && !tabsLoaded.bidInprogress" :is-loaded="tabsLoaded.bidInprogress" />
            </TabPanel>
            <TabPanel>
              <CompletedBidsTab v-if="tabsLoaded.completed" :task-completed="taskCompleted"
                :loading="loading && !tabsLoaded.completed" :is-loaded="tabsLoaded.completed" />
            </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </CustomerAuthenticatedLayout>
</template>