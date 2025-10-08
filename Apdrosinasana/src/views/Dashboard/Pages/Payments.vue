<script setup>
import '@bhplugin/vue3-datatable/dist/style.css'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';
import { RefreshCcw } from 'lucide-vue-next';

const payments = ref([]);
const loading = ref(false);

onMounted(async () => {
    await fetchPayments();
});

const fetchPayments = async () => {
    loading.value = true;
    try {
        const response = await axios.post('/api/payments');
        payments.value = response.data.payments;
        console.log(payments.value);
    } catch (error) {
        console.error('Error fetching payments:', error);
    } finally {
        loading.value = false;
    }
};

const cols = ref([
    { title: 'ID', field: 'id', sortable: true },
    { title: 'Personal code', field: 'policy.client.name', sortable: true },
    { title: 'Polise', field: 'policy.policy_number', sortable: true },
    { title: 'Summa', field: 'amount', sortable: true },
    { title: 'No', field: 'created_at', sortable: true },
    { title: 'Līdz', field: 'policy.end_date', sortable: true },
]);



</script>

<template>
    <div>
        <div class="mb-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-5">Maksājumi</h1>
            <Button @click="fetchPayments" class="cursor-pointer hover:bg-gray-100"><RefreshCcw /></Button>
        </div>
        <vue3-datatable :rows="payments" :columns="cols" :loading="loading" :sortable="true" :columnFilter="true">
            <template #created_at="data">
                {{ moment(data.value.created_at).format('YYYY-MM-DD') }}
            </template>

            <template #policy.client.name="data">
                {{ data.value.policy.policy_number }}
            </template>

        </vue3-datatable>
    </div>
</template>