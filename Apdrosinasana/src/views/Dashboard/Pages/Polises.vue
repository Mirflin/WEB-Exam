<script setup>
import '@bhplugin/vue3-datatable/dist/style.css'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';
import { RefreshCcw, Trash2Icon } from 'lucide-vue-next';

const polises = ref([]);
const loading = ref(false);

onMounted(async () => {
    await fetchPolises();
});

const fetchPolises = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/polises-list');
        polises.value = response.data.polises;
        console.log(polises.value);
    } catch (error) {
        console.error('Error fetching polises:', error);
    } finally {
        loading.value = false;
    }
};

const cols = ref([
    { title: 'ID', field: 'id', sortable: true },
    { title: 'Client', field: 'client.name', sortable: true },
    { title: 'Polise numurs', field: 'policy_number', sortable: true },
    { title: 'Tips', field: 'type', sortable: true },
    { title: 'No', field: 'start_date', sortable: true },
    { title: 'Līdz', field: 'end_date', sortable: true },
    { title: 'Stāvoklis', field: 'status', sortable: true },
    { title: 'Darbības', field: 'actions' },
]);

const deletePolise = async (id) => {
    try {
        await axios.post('/api/polis-delete', { id: id });
        polises.value = polises.value.filter(polis => polis.id !== id);
    } catch (error) {
        console.error('Error deleting polis:', error);
    }
};


</script>

<template>
    <div>
        <div class="mb-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-5">Polises</h1>
            <Button @click="fetchPolises" class="cursor-pointer hover:bg-gray-100"><RefreshCcw /></Button>
        </div>
        <vue3-datatable :rows="polises" :columns="cols" :loading="loading" :sortable="true" :columnFilter="true">
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

            <template #actions="data">
                <Button @click="deletePolise(data.value.id)" class="bg-red-600 hover:bg-red-700 text-white cursor-pointer"><Trash2Icon /> </Button>
            </template>

        </vue3-datatable>
    </div>
</template>