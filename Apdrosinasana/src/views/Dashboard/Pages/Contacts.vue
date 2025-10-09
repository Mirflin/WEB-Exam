<script setup>
import { onMounted, ref } from 'vue';
import { Notivue, Notification ,push} from 'notivue'
import Button from '@/components/ui/button/Button.vue';
import axios from 'axios';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';

const form = ref({
    phone: '',
    email: '',
    registration: ''
});
const contacts = ref();

const loading = ref(false);

onMounted(async () => {
    await fetchContacts();
});

const fetchContacts = async () => {
    try {
        const response = await axios.get('/api/contacts');
        contacts.value = response.data;
        form.value.phone = contacts.value.phone;
        form.value.email = contacts.value.email;
        form.value.registration = contacts.value.registration;
    } catch (error) {
        console.error('Error fetching contacts:', error);
    }
};

const save = async() => {
    loading.value = true;
    if(!editMode.value){ 
        editMode.value = true
        loading.value = false;
        return
    }

    if(form.value.phone.length < 8){
        loading.value = false;
        push.error('Telefona numuram jābūt vismaz 8 simbolus garam!')
        return
    }else if(!form.value.email.includes('@') || !form.value.email.includes('.')){
        loading.value = false;
        push.error('Lūdzu, ievadiet derīgu e-pasta adresi!')
        return
    }else if(form.value.registration.length < 5){
        loading.value = false;
        push.error('Reģistrācijas numuram jābūt vismaz 5 simbolus garam!')
        return
    }

    try {
        await axios.post('/api/contacts-create', {
            phone: form.value.phone,
            email: form.value.email,
            registration: form.value.registration
        });
        push.success('Kontakti veiksmīgi saglabāti!')
        editMode.value = false;
    } catch (error) {
        console.error('Error saving contacts:', error);
    }
    loading.value = false;
};

const editMode = ref(false);
</script>

<template>
    <div>
        <Notivue v-slot="item">
            <Notification :item="item" />
        </Notivue>
    <div class="rounded-md shadow-md p-5 m-5" v-if="!loading">
        <div class="mb-5 flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-5">Kontakti</h1>
            <Button class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" @click="save">
                {{ editMode ? 'Atcelt' : 'Rediģēt' }}
            </Button>
        </div>
        <div class="flex flex-col gap-4">
            <div>
                <Label class="mb-2">Telefons:</Label>
                <p v-if="!editMode">{{ form.phone ? form.phone : 'Nav pieejams' }}</p>
                <Input v-if="editMode" v-model="form.phone" class="border p-1 rounded" />
            </div>
            <div>
                <Label class="mb-2">E-pasts:</Label>
                <p v-if="!editMode">{{ form.email ? form.email : 'Nav pieejams' }}</p>
                <Input v-if="editMode" v-model="form.email" class="border p-1 rounded" />
            </div>
            <div>
                <Label class="mb-2">Reģistrācija:</Label>
                <p v-if="!editMode">{{ form.registration ? form.registration : 'Nav pieejams' }}</p>
                <Input v-if="editMode" v-model="form.registration" class="border p-1 rounded" />
            </div>
        </div>
    </div>
    </div>
</template>