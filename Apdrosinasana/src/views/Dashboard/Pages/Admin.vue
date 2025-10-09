<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Notivue, Notification, push } from 'notivue'
import moment from 'moment';
import { RefreshCcw } from 'lucide-vue-next';

const data = ref([]);

const loading = ref(false);

const fetchData = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/admin-data');
        data.value = response.data;
    } catch (error) {
        console.error('Error fetching admin data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchData();
});


</script>

<template>
    <div class="m-5 p-5 w-full shadow-md rounded-md">
        <div class="flex justify-between items-center mr-5">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
            <Button class="cursor-pointer hover:bg-gray-200" @click="fetchData"><RefreshCcw /></Button>
        </div>
        <div v-if="!loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-5">
            <div class="bg-white p-5 rounded-md shadow-md">
                <h2 class="text-lg font-bold">Lietotāji</h2>
                <p class="text-2xl">{{ data.total_users }}</p>
            </div>
            <div class="bg-white p-5 rounded-md shadow-md">
                <h2 class="text-lg font-bold">Polises</h2>
                <p class="text-2xl">{{ data.total_policies }}</p>
            </div>
            <div class="bg-white p-5 rounded-md shadow-md">
                <h2 class="text-lg font-bold">Maksājumi</h2>
                <p class="text-2xl">{{ data.total_payments }}</p>
            </div>
            <div class="bg-white p-5 rounded-md shadow-md">
                <h2 class="text-lg font-bold">Aktīvās Polises</h2>
                <p class="text-2xl">{{ data.active_policies }}</p>
            </div>
        </div>
    </div>
</template>