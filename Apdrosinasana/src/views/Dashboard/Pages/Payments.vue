<script setup>
import '@bhplugin/vue3-datatable/dist/style.css'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Vue3Datatable from '@bhplugin/vue3-datatable';

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
    } catch (error) {
        console.error('Error fetching payments:', error);
    } finally {
        loading.value = false;
    }
};

fetchPayments();

</script>

<template>
    <div>
        <h1>Profila lapa</h1>
    </div>
</template>