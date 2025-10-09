<script setup>
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/components/ui/alert-dialog"
import Input from '@/components/ui/input/Input.vue';
import { ref, onMounted } from 'vue';
import Button from '@/components/ui/button/Button.vue';
import axios from 'axios';
import { Notivue, Notification, push } from 'notivue'
import moment from 'moment';
import { RefreshCcw, HandCoins, TrashIcon, ArchiveRestore } from 'lucide-vue-next';
import PoliciesCreate from './PoliciesCreate.vue';
import PoliciesView from './PoliciesView.vue';

const loading = ref(false);
const policies = ref([]);
const total = ref(0);
const createModal = ref(false);

onMounted(async () => {
    await fetch();
});

const fetch = async() => {
    loading.value = true;
    try {
        const response = await axios.post('/api/policies', filter.value);
        policies.value = response.data.policies
        total.value = response.data.total
        if(filter.value.type !== '-' || filter.value.status !== '-' || filter.value.search !== ''){
            push.success(`Atrastie ${policies.value.length} ieraksti!`)
        }
    } catch (error) {
        console.error('Error fetching policies:', error);
    } finally {
        loading.value = false;
    }
}

const statusColor = (status) => {
    if(status === 1){
        return 'bg-green-500'
    }else if(status === 2){
        return 'bg-yellow-500'
    }else if(status === 3){
        return 'bg-red-500'
    }else{
        return 'bg-gray-500'
    }
}

const translateType = (type) => {
    if(type === 'car'){
        return 'Mašīna'
    }else if(type === 'property'){
        return 'Īpašums'
    }else if(type === 'tour'){
        return 'Ceļojums'
    }else if(type === 'life'){
        return 'Dzīvība'
    }else{
        return type
    }
}

const filter = ref(
    {
        type: '-',
        search: '',
        status: '-'
    }
);

const resetFilters = () => {
    filter.value.type = '-'
    filter.value.status = '-'
    filter.value.search = ''
    fetch()
}

const checkCount = () => {
    if(total.value >= 50){
        push.error('Jūs esat sasniedzis maksimālo polisi skaitu (50)!')
        return false
    }
    createModal.value = true
}

const notification = (type, message) => {
    if(type === 'success'){
        push.success(message)
    }else if(type === 'error'){
        push.error(message)
    }else{
        push.info(message)
    }
}

const itemId = ref(null);
const deleteDialog = ref(false);
const itemDialog = ref(false);

const deleteItem = async() => {
    if(!itemId.value) return;

    loading.value = true;
    try {
        await axios.post('/api/policies-delete', { policy_id: itemId.value });
        push.success('Poliss veiksmīgi izdzēsts!');
        fetch();
    } catch (error) {
        push.error('Kļūda, mēģiniet vēlreiz!');
    } finally {
        loading.value = false;
        deleteDialog.value = false;
        itemId.value = null;
    }
}

const restoreItem = async(id) => {
    if(!id) return;

    loading.value = true;
    try {
        await axios.post('/api/policies-restore', { policy_id: id });
        push.success('Poliss veiksmīgi atjaunots!');
        fetch();
    } catch (error) {
        push.error('Kļūda, mēģiniet vēlreiz!');
    } finally {
        loading.value = false;
        deleteDialog.value = false;
        itemId.value = null;
    }
}

</script>

<template>
    <div>
        <PoliciesCreate v-if="createModal" @notify="notification" :open="createModal" @close="createModal = false; fetch()" />
        <PoliciesView @refresh="fetch" v-if="itemDialog" :policy="itemId" :open="itemDialog" @notify="notification" @close="itemDialog = false" />
        
        <Notivue v-slot="item">
            <Notification :item="item" />
        </Notivue>

        <AlertDialog v-if="deleteDialog" v-model:open="deleteDialog">
            <AlertDialogTrigger as-child>
            </AlertDialogTrigger>
            <AlertDialogContent class="bg-white">
            <AlertDialogHeader>
                <AlertDialogTitle>Vai tu esi pilnīgi pārliecināts?</AlertDialogTitle>
                <AlertDialogDescription>
                Šī darbība nav atgriezeniska. Tas pastāvīgi izdzēsīs jūsu
                polisi no servera.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel class="bg-gray-100 hover:bg-gray-200 cursor-pointer">Atcelt</AlertDialogCancel>
                <AlertDialogAction @click="deleteItem" class="bg-red-500 hover:bg-red-600 cursor-pointer text-white">Turpināt</AlertDialogAction>
            </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

    <div class="p-10 m-5 shadow-md rounded-lg bg-white">
        <div class="flex gap-5 justify-between items-center mb-5">
            <div class="flex gap-3 items-center">
                <Select v-model="filter.type" default-value="-" >
                    <SelectTrigger class="w-40">
                    <SelectValue placeholder="Izvēlēties tipu" />
                    </SelectTrigger>
                    <SelectContent>
                    <SelectGroup class="bg-white">
                        <SelectLabel>Tips</SelectLabel>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="-">
                                -
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="car">
                                Mašīna
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="property">
                                Īpašums
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="tour">
                                Ceļojums
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="life">
                                Dzīvība
                            </SelectItem>
                    </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="filter.status" default-value="-" >
                    <SelectTrigger class="w-40">
                    <SelectValue placeholder="Izvēlēties status" />
                    </SelectTrigger>
                    <SelectContent>
                    <SelectGroup class="bg-white">
                        <SelectLabel>Status</SelectLabel>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="-">
                                -
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="1">
                                Aktīvs
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="2">
                                Beidzies
                            </SelectItem>
                            <SelectItem class="cursor-pointer hover:bg-gray-100" value="3">
                                Atcelts
                            </SelectItem>
                    </SelectGroup>
                    </SelectContent>
                </Select>

                <Input class="w-50" v-model="filter.search" placeholder="polise numurs"></Input>

                <Button @click="fetch" class="bg-blue-400 text-white cursor-pointer hover:bg-blue-500">Filtrēt</Button>
            </div>
            <div class="flex gap-3 items-center">
                <Button @click="resetFilters" class="cursor-pointer hover:bg-gray-100"><RefreshCcw /></Button>
                <Button @click="checkCount" class="bg-green-400 text-white cursor-pointer hover:bg-green-500">Pievienot +</Button>
            </div>
        </div>
        <div class="mt-5 min-h-50 max-h-200 p-5 overflow-y-auto grid gap-3 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <div v-if="policies.length > 0 && !loading" v-for="value in policies" :key="value.id">
                <div class="border-1 relative p-5 border-gray-200 py-5 hover:shadow-lg rounded-lg flex flex-col gap-2">
                    <div class="absolute right-2 top-1">
                        <div class="w-3 h-3 rounded-full" :class="statusColor(value.status.id)"></div>
                    </div>
                    <div class="absolute right-1 bottom-1 flex gap-2">
                        <HandCoins @click="itemId = value.id; itemDialog = true" class="cursor-pointer opacity-50 hover:opacity-100 hover:text-yellow-500" />
                        <TrashIcon @click="itemId = value.id; deleteDialog = true" class="cursor-pointer opacity-50 hover:opacity-100 hover:text-red-500" />
                        <ArchiveRestore v-if="value.status.id === 3" @click="restoreItem(value.id)" class="cursor-pointer opacity-50 hover:opacity-100 hover:text-green-500" />
                    </div>
                    <div class="font-semibold">{{ value.policy_number }}</div>
                    <div class="text-sm text-gray-500">{{ translateType(value.type) }}</div>
                    <div class="text-sm text-gray-500">Sākums: {{ moment(value.start_date).format('DD.MM.YYYY') }}</div>
                    <div class="text-sm text-gray-500">Beidzas: {{ moment(value.end_date).format('DD.MM.YYYY') }}</div>
                </div>
            </div>
            <div v-else-if="!loading" class="text-center col-span-full text-gray-500">Nav atrasts neviens ieraksts</div>
            <div v-else class="text-center col-span-full text-gray-500">Ielādē...</div>
        </div>
    </div>
    </div>
</template>