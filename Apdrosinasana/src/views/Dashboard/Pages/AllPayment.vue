<script setup>
import '@bhplugin/vue3-datatable/dist/style.css'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';
import { RefreshCcw, Trash2Icon } from 'lucide-vue-next';

const payments = ref([]);
const loading = ref(false);

onMounted(async () => {
    await fetchPayments();
});

const fetchPayments = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/payments-list');
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

const deletePayment = async (id) => {
    try {
        await axios.post('/api/payments-delete', { id: id });
        payments.value = payments.value.filter(payment => payment.id !== id);
    } catch (error) {
        console.error('Error deleting payment:', error);
    }
};


</script>

<template>
    <div>
        <div class="mb-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-5">Maksājumi</h1>
            <Button @click="fetchPayments" class="cursor-pointer hover:bg-gray-100"><RefreshCcw /></Button>
        </div>
        <vue3-datatable :rows="payments" :columns="cols" :loading="loading" :sortable="false" :columnFilter="true">
            <template #created_at="data">
                {{ moment(data.value.start_date).format('YYYY-MM-DD') }}
            </template>

            <template #client.name="data">
                {{ data.value.client.user.name }}
            </template>

            <template #status="data">
                <span v-if="data.value.status === 1" class="text-green-600 font-bold">Aktivs</span>
                <span v-else-if="data.value.status === 2" class="text-yellow-600 font-bold">Beidzies</span>
                <span v-else-if="data.value.status === 3" class="text-red-600 font-bold">Atcelts</span>
            </template>

            <template #policy.client.name="data">
                {{ data.value.policy.policy_number }}
            </template>

            <template #actions="data">
                <Button @click="deletePolise(data.value.id)" class="bg-red-600 hover:bg-red-700 text-white cursor-pointer"><Trash2Icon /> </Button>
            </template>

        </vue3-datatable>
    </div>
</template>