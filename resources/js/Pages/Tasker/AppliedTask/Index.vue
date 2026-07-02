<script setup>
import TaskerAuthenticatedLayout from '@/Layouts/TaskerAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue';
import axios from 'axios';
import { defineAsyncComponent, onMounted, ref } from 'vue';

const AppliedTasksTab = defineAsyncComponent(() => import('./Tabs/AppliedTasksTab.vue'));
const AcceptedTasksTab = defineAsyncComponent(() => import('./Tabs/AcceptedTasksTab.vue'));
const InProgressTasksTab = defineAsyncComponent(() => import('./Tabs/InProgressTasksTab.vue'));
const CompletedTasksTab = defineAsyncComponent(() => import('./Tabs/CompletedTasksTab.vue'));

const categories = [
    'কাজের আবেদনগুলো',
    'গৃহীত কাজগুলো',
    'চলমান কাজগুলো',
    'কমপ্লিটেড কাজগুলো',
];

const loading = ref(false);
const error = ref(null);

const appliedTasks = ref([]);
const acceptedTasks = ref([]);
const inProgressTasks = ref([]);
const completedTasks = ref([]);

const tabsLoaded = ref({
    applied: true,
    accepted: false,
    inProgress: false,
    completed: false,
});

const fetchAppliedTasks = async () => {
    loading.value = true;

    try {
        const response = await axios.get(route('tasker.applied.task.list'));
        appliedTasks.value = response.data.data;
    } catch (err) {
        error.value = 'Failed to fetch applied tasks.';
    } finally {
        loading.value = false;
    }
};

const fetchAcceptedTasks = async (forceRefresh = false) => {
    if (!forceRefresh && tabsLoaded.value.accepted) return;

    loading.value = true;

    try {
        const response = await axios.get(route('tasker.accepted.task.list'));
        acceptedTasks.value = response.data.data;
        tabsLoaded.value.accepted = true;
    } catch (err) {
        error.value = 'Failed to fetch accepted tasks.';
    } finally {
        loading.value = false;
    }
};

const fetchInProgressTasks = async () => {
    if (tabsLoaded.value.inProgress) return;

    loading.value = true;

    try {
        const response = await axios.get(route('tasker.in-progress.task.list'));
        inProgressTasks.value = response.data.data;
        tabsLoaded.value.inProgress = true;
    } catch (err) {
        error.value = 'Failed to fetch in-progress tasks.';
    } finally {
        loading.value = false;
    }
};

const fetchCompletedTasks = async () => {
    if (tabsLoaded.value.completed) return;

    loading.value = true;

    try {
        const response = await axios.get(route('tasker.completed.task.list'));
        completedTasks.value = response.data.data;
        tabsLoaded.value.completed = true;
    } catch (err) {
        error.value = 'Failed to fetch completed tasks.';
    } finally {
        loading.value = false;
    }
};

const handleTabChange = (index) => {
    if (index === 1 && !tabsLoaded.value.accepted) {
        fetchAcceptedTasks(false);
    } else if (index === 2 && !tabsLoaded.value.inProgress) {
        fetchInProgressTasks();
    } else if (index === 3 && !tabsLoaded.value.completed) {
        fetchCompletedTasks();
    }
};

onMounted(() => {
    fetchAppliedTasks();
});
</script>

<template>
    <TaskerAuthenticatedLayout>
        <Head title="আবেদনকৃত কাজসমূহ" />

        <div class="lg:col-span-3">
            <div id="tasks" class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-dark mb-4">আবেদনকৃত কাজসমূহ</h2>

                <TabGroup @change="handleTabChange">
                    <div class="border-b border-gray-200">
                        <TabList class="flex space-x-8">
                            <Tab v-for="(category, index) in categories" :key="index" v-slot="{ selected }" class="focus:outline-none">
                                <button
                                    :class="[
                                        'py-2 px-1 font-medium text-sm focus:outline-none border-b-2 transition-colors',
                                        selected
                                            ? 'border-blue-500 text-blue-600'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    ]"
                                >
                                    {{ category }}
                                    <span
                                        class="ml-2 px-2 py-0.5 text-xs rounded-full"
                                        :class="{
                                            'bg-yellow-100 text-yellow-800': index === 0,
                                            'bg-green-100 text-green-800': index === 1,
                                            'bg-blue-100 text-blue-800': index === 2,
                                            'bg-red-100 text-red-800': index === 3
                                        }"
                                    >
                                        <template v-if="index === 0">{{ appliedTasks.length }}</template>
                                        <template v-else-if="index === 1">{{ tabsLoaded.accepted ? acceptedTasks.length : '?' }}</template>
                                        <template v-else-if="index === 2">{{ tabsLoaded.inProgress ? inProgressTasks.length : '?' }}</template>
                                        <template v-else>{{ tabsLoaded.completed ? completedTasks.length : '?' }}</template>
                                    </span>
                                </button>
                            </Tab>
                        </TabList>
                    </div>

                    <p v-if="error" class="mt-4 text-sm text-red-600">{{ error }}</p>

                    <TabPanels class="mt-6">
                        <TabPanel>
                            <AppliedTasksTab
                                :applied-tasks="appliedTasks"
                                :loading="loading"
                            />
                        </TabPanel>

                        <TabPanel>
                            <AcceptedTasksTab
                                :accepted-tasks="acceptedTasks"
                                :loading="loading && !tabsLoaded.accepted"
                                :is-loaded="tabsLoaded.accepted"
                                @refresh="() => fetchAcceptedTasks(true)"
                            />
                        </TabPanel>

                        <TabPanel>
                            <InProgressTasksTab
                                v-if="tabsLoaded.inProgress"
                                :in-progress-tasks="inProgressTasks"
                                :loading="loading && !tabsLoaded.inProgress"
                                :is-loaded="tabsLoaded.inProgress"
                            />
                        </TabPanel>

                        <TabPanel>
                            <CompletedTasksTab
                                v-if="tabsLoaded.completed"
                                :completed-tasks="completedTasks"
                                :loading="loading && !tabsLoaded.completed"
                                :is-loaded="tabsLoaded.completed"
                            />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </TaskerAuthenticatedLayout>
</template>