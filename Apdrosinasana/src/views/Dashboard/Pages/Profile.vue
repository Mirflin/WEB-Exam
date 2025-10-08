<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';
import axios from 'axios';
import Input from '@/components/ui/input/Input.vue';
import { Notivue, Notification, push } from 'notivue'

const loading = ref(false);
const auth = useAuthStore();
const editMode = ref(false);
const activePayments = ref(true);
const client = ref(null);

onMounted(async () => {
    await fetch();
});

const fetch = async() => {
    loading.value = true;
    const response = await axios.post('/api/clients', auth.user.id);

    client.value = response.data;
    form.value.personal_code = client.value.personal_code;
    form.value.phone = client.value.phone;
    form.value.address = client.value.address;
    loading.value = false;
};

const save = async() => {

    if(!editMode.value){ 
        editMode.value = true
        return
    }

    if(form.value.name.length < 2){
        push.error('Vārdam jābūt vismaz 2 simbolus garam!')
        return
    }else if(form.value.address.length < 5){
        push.error('Adresei jābūt vismaz 5 simbolus garam!')
        return
    }else if(!form.value.email.includes('@') || !form.value.email.includes('.')){
        push.error('Ievadiet derīgu e-pastu!')
        return
    }else if(form.value.personal_code.length !== 11){
        push.error('Personālajam kodam jābūt 11 simbolus garam!')
        return
    }else if(form.value.phone.length < 8){
        push.error('Telefona numuram jābūt vismaz 8 simbolus garam!')
        return
    }

    loading.value = true;

    try {
        const response = await axios.post('/api/user-update', {
            name: form.value.name,
            email: form.value.email,
            personal_code: form.value.personal_code,
            phone: form.value.phone,
            address: form.value.address,
        });
    } catch (error) {
        push.error('Kļūda, mēģiniet vēlreiz!');
        loading.value = false;
        return;
    }

    push.success('Dati veiksmīgi atjaunoti!');

    await auth.attempt();
    await fetch();

    loading.value = false;
    editMode.value = false;
};

const form = ref({
    name: auth.user.name,
    email: auth.user.email,
    personal_code: 0,
    phone: 0,
    address: 0,
});

</script>

<template>
    <div class="">
        <Notivue v-slot="item">
            <Notification :item="item" />
        </Notivue>
        <div class="pl-10 flex flex-col items-start gap-5 bg-white p-5 rounded-lg shadow-lg w-full">
            <Button @click="save" class="absolute top-30 right-15 z-10 cursor-pointer bg-blue-200 hover:bg-blue-300" :class="editMode ? 'bg-green-300 hover:bg-green-400' : ''">{{ editMode ? 'Saglabāt' : 'Rediģēt' }}</Button>
            <div class="flex justify-center lg:justify-start items-end gap-10 flex-wrap">
                <img class="w-50 rounded-full bg-gray-100 shadow-xl" src="@/assets/logo.png" alt="Logo" />
                <div class="mb-5">
                    <h1 class="text-2xl font-bold">{{ auth.user.name }}</h1>
                    <p class="text-gray-600">{{ auth.user.role.role_name }}</p>
                </div>
            </div>
            <div class="mt-5 w-full lg:w-1/2 flex flex-col justify-start items-start gap-5">
                <h2 class="text-xl font-semibold mb-3">Lietotāja informācija</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold">Vārds:</p>
                        <p v-if="!editMode">{{ form.name }}</p>
                        <Input v-else v-model="form.name" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">E-pasts:</p>
                        <p v-if="!editMode">{{ form.email }}</p>
                        <Input type="email" v-else v-model="form.email" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Izveidots:</p>
                        <p>{{ moment(auth.user.created_at).format('DD.MM.YYYY') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Personālais kods:</p>
                        <p v-if="!editMode">{{ form.personal_code }}</p>
                        <Input v-else v-model="form.personal_code" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Telefons:</p>
                        <p v-if="!editMode">{{ form.phone }}</p>
                        <Input v-else v-model="form.phone" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Adrese:</p>
                        <p v-if="!editMode">{{ form.address }}</p>
                        <Input v-else v-model="form.address" class="border p-1 rounded" />
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 flex flex-col items-start gap-5 w-full" v-if="activePayments">
            <div class="flex-1 border-1 bg-gray-100 p-5 rounded-lg shadow-lg w-full">
                <h2 class="text-xl font-semibold mb-3">Nākamie maksājumi</h2>
                <p class="text-gray-600">Šobrīd nav gaidošu maksājumu.</p>
            </div>
        </div>
    </div>
</template>