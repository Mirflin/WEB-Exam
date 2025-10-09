<script setup>
import '@bhplugin/vue3-datatable/dist/style.css'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';
import { RefreshCcw, Trash2Icon, ArchiveRestore, ArchiveRestoreIcon, Edit2Icon } from 'lucide-vue-next';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Notivue, Notification, push } from 'notivue'
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';
import router from '@/router';

const auth = useAuthStore()
const users = ref([]);
const loading = ref(false);
const totalPolicies = ref(0);

onMounted(async () => {
    await fetchUsers();
});

const fetchUsers = async () => {
    loading.value = true;
    try {
        const response = await axios.post('/api/all-users');
        users.value = response.data.users;
        totalPolicies.value = response.data.totalPolicies;
    } catch (error) {
        console.error('Error fetching users:', error);
    } finally {
        loading.value = false;
    }
};

const cols = ref([
    { title: 'ID', field: 'id', sortable: false },
    { title: 'Vārds', field: 'name', sortable: false },
    { title: 'Personālais kods', field: 'client.personal_code', sortable: false },
    { title: 'Adrese', field: 'client.address', sortable: false },
    { title: 'Telefons', field: 'client.phone', sortable: false },
    { title: 'E-pasts', field: 'email', sortable: false },
    { title: 'Līmenis', field: 'role_id', sortable: false },
    { title: 'Izveidots', field: 'created_at', sortable: false },
    { title: 'Statuss', field: 'active', sortable: false },
    { title: 'Darbības', field: 'darbibas', sortable: false },
]);

const modalOpen = ref(false);
const selectedUser = ref(null);

const openEditModal = (user) => {
    if(user.id){
        creating.value = false;
        selectedUser.value = user
        form.value.name = user.name;
        form.value.email = user.email;
        form.value.personal_code = user.client.personal_code;
        form.value.address = user.client.address;
        form.value.phone = user.client.phone;
        form.value.level = user.role_id;
    }else{
        creating.value = true;
    }
    modalOpen.value = true;
};

const closeEditModal = () => {
    resetForm();
    selectedUser.value = null;
    fetchUsers();
    modalOpen.value = false;
};

const saveChanges = async () => {

    if(form.value.phone.length < 8){
        push.error('Telefona numuram jābūt vismaz 8 simbolus garam!')
        loading.value = false
        return
    }else if(!form.value.email.includes('@') || !form.value.email.includes('.')){
        push.error('Ievadiet derīgu e-pastu!')
        loading.value = false
        return
    }else if(form.value.name.length < 2){
        push.error('Vārdam jābūt vismaz 2 simbolus garam!')
        loading.value = false
        return
    }else if(form.value.address.length < 5){
        push.error('Adresei jābūt vismaz 5 simbolus garam!')
        loading.value = false
        return
    }else if(!form.value.name || !form.value.email || !form.value.personal_code || !form.value.address || !form.value.phone || !form.value.level){
        push.error('Lūdzu, aizpildiet visus obligātos laukus!');
        return;
    }else if(form.value.personal_code.length !== 11){
        push.error('Personālajam kodam jābūt 11 simbolus garam!')
        loading.value = false
        return
    }

    if(creating.value){
        try{
            const response = await axios.post('/api/user-create', {
                name: form.value.name,
                email: form.value.email,
                personal_code: form.value.personal_code,
                address: form.value.address,
                phone: form.value.phone,
                level: form.value.level,
                password: form.value.password,
                password_confirmation: form.value.password_confirmation
            });
            push.success('Lietotājs veiksmīgi izveidots!');
            creating.value = false;
        } catch (error) {
            push.error('Kļūda, izveidojot lietotāju. Lūdzu, pārbaudiet ievadītos datus.');
            return;
        }
    }else{
        try{
            const response = await axios.post('/api/user-update', {
                id: selectedUser.value ? selectedUser.value.id : null,
                name: form.value.name,
                email: form.value.email,
                personal_code: form.value.personal_code,
                address: form.value.address,
                phone: form.value.phone,
                level: form.value.level,
                password: form.value.password,
                password_confirmation: form.value.password_confirmation
            });
            push.success('Lietotājs veiksmīgi atjaunināts!');
        } catch (error) {
            push.error('Kļūda, atjauninot lietotāju. Lūdzu, pārbaudiet ievadītos datus.');
        }
    }

    auth.attempt();
    
    closeEditModal();
};

const deleteUser = async (userId) => {
    try {
        await axios.post('/api/user-delete', { id: userId });
        push.success('Lietotājs veiksmīgi izdzēsts!');
        if(userId === auth.user.id){
            await auth.logout();
            router.push('/');
            return;
        }
        fetchUsers();
    } catch (error) {
        console.error('Error deleting user:', error);
        push.error('Kļūda, dzēšot lietotāju.');
    }
};

const restoreUser = async (userId) => {
    try {
        await axios.post('/api/user-restore', { id: userId });
        push.success('Lietotājs veiksmīgi atjaunots!');
        fetchUsers();
    } catch (error) {
        console.error('Error restoring user:', error);
        push.error('Kļūda, atjaunojot lietotāju.');
    }
};

const resetForm = () => {
    form.value = {
        name: '',
        email: '',
        personal_code: '',
        address: '',
        phone: '',
        password:'',
        level: '',
        password_confirmation: ''
    };
};

const form = ref({
    name: '',
    email: '',
    personal_code: '',
    address: '',
    phone: '',
    password:'',
    level: '',
    password_confirmation: ''
})

const creating = ref(false);
</script>

<template>
    <div>
        <Notivue v-slot="item">
            <Notification :item="item" />
        </Notivue>
        <Dialog v-if="modalOpen" @close="closeEditModal" :open="modalOpen">
            <DialogContent class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
            <DialogHeader>
                <DialogTitle>Jauns/rediģēt lietotāju</DialogTitle>
                <div>
                    <form @submit.prevent class="flex flex-col gap-4">
                        <div class="flex  flex-col gap-1 mt-8">
                            <Label class="text-lg w-20">Vārds: </Label>
                            <Input v-model="form.name" class="text-xl"></Input>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label class="text-lg w-20">E-pasts: </Label>
                            <Input type="email" v-model="form.email" class="text-xl"></Input>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label class="text-lg w-40">Personālais kods: </Label>
                            <Input v-model="form.personal_code" class="text-xl"></Input>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label class="text-lg w-20">Address: </Label>
                            <Input v-model="form.address" class="text-xl"></Input>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label class="text-lg w-20">Phone: </Label>
                            <Input v-model="form.phone" class="text-xl"></Input>
                        </div>
                        <div v-if="creating" class="flex flex-col gap-1">
                            <Label class="text-lg w-20">Parols: </Label>
                            <Input v-model="form.password" class="text-xl" type="password"></Input>
                        </div>
                        <div v-if="creating" class="flex flex-col gap-1">
                            <Label class="text-lg w-40">Atkartot parolu: </Label>
                            <Input v-model="form.password_confirmation" class="text-xl" type="password"></Input>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label class="text-lg w-40">Līmenis: </Label>
                            <Select v-model="form.level">
                                <SelectTrigger>
                                    <SelectValue placeholder="Izvēlieties līmeni" />
                                </SelectTrigger>
                                <SelectContent>
                                <SelectGroup>
                                    <SelectItem :value="1">
                                    Admins
                                    </SelectItem>
                                    <SelectItem :value="2">
                                    Lietotājs
                                    </SelectItem>
                                </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                    </form>
                </div>
            </DialogHeader>

            <DialogFooter>
                <Button class="mr-2 bg-gray-200 hover:bg-gray-300 cursor-pointer" @click="closeEditModal">Aizvērt</Button>
                <Button class="bg-blue-500 hover:bg-blue-600 text-white cursor-pointer" @click="saveChanges">Saglabāt izmaiņas</Button>
            </DialogFooter>
            </DialogContent>
        </Dialog>
        <div class="mb-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-5">Lietotāji</h1>
            <div class="flex gap-2 items-center">
                <Button @click="fetchUsers" class="cursor-pointer hover:bg-gray-100"><RefreshCcw /></Button>
                <Button @click="openEditModal" class="cursor-pointer bg-green-500 hover:bg-green-600 text-white">Jauns +</Button>
            </div>
        </div>
        <vue3-datatable :rows="users" :columns="cols" :loading="loading" :sortable="false" :columnFilter="true">

            <template #role_id="data">
                <span v-if="data.value.role_id == 1" class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Admins</span>
                <span v-else class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Lietotājs</span>
            </template>

            <template #active="data">
                <span v-if="data.value.active" class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-800">Aktīvs</span>
                <span v-else class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800">Neaktīvs</span>
            </template>

            <template #created_at="data">
                {{ moment(data.value.created_at).format('YYYY-MM-DD') }}
            </template>

            <template #darbibas="data">
                <div class="flex gap-2">
                    <Button :disabled="data.value.id == auth.user.id" @click="deleteUser(data.value.id)" v-if="data.value.active" class="bg-red-600 hover:bg-red-700 text-white cursor-pointer"><Trash2Icon /> </Button>
                    <Button @click="restoreUser(data.value.id)" v-else class="bg-yellow-400 hover:bg-yellow-500 text-white cursor-pointer"><ArchiveRestoreIcon /> </Button>
                    <Button :disabled="data.value.id == auth.user.id" @click="openEditModal(data.value)" class="bg-blue-400 hover:bg-blue-500 text-white cursor-pointer"><Edit2Icon /> </Button>
                </div>
            </template>
        </vue3-datatable>
    </div>
</template>