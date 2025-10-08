<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import moment from 'moment';
import Button from '@/components/ui/button/Button.vue';

const loading = ref(false);
const auth = useAuthStore();
const editMode = ref(false);
const activePayments = ref(true);

const save = async() => {

    if(!editMode.value){ 
        editMode.value = true
        return
    }

    loading.value = true;

    // Here you would typically send the updated user data to the server
    // For example:
    // await auth.updateUser(auth.user);

    loading.value = false;
    editMode.value = false;
};

const form = ref({
    name: auth.user.name,
    email: auth.user.email,
    personal_code: auth.user.personal_code,
    phone: auth.user.phone,
    address: auth.user.address,
});

</script>

<template>
    <div class="">
        <div class="pl-10 flex flex-col items-start gap-5 bg-white p-5 rounded-lg shadow-lg w-full">
            <Button @click="save" class="absolute top-30 right-15 z-10 cursor-pointer bg-blue-200 hover:bg-blue-300" :class="editMode ? 'bg-green-300 hover:bg-green-400' : ''">{{ editMode ? 'Saglabāt' : 'Rediģēt' }}</Button>
            <div class="flex justify-center lg:justify-start items-end gap-10 flex-wrap">
                <img class="w-50 rounded-full bg-gray-100 shadow-xl" src="@/assets/logo.png" alt="Logo" />
                <div class="mb-5">
                    <h1 class="text-2xl font-bold">{{ form.name }}</h1>
                    <p class="text-gray-600">{{ form.email }}</p>
                </div>
            </div>
            <div class="mt-5 w-full lg:w-1/2 flex flex-col justify-start items-start gap-5">
                <h2 class="text-xl font-semibold mb-3">Lietotāja informācija</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold">Vārds:</p>
                        <p v-if="!editMode">{{ form.name }}</p>
                        <input v-else v-model="form.name" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">E-pasts:</p>
                        <p v-if="!editMode">{{ form.email }}</p>
                        <input v-else v-model="form.email" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Izveidots:</p>
                        <p>{{ moment(auth.user.created_at).format('DD.MM.YYYY') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Personālais kods:</p>
                        <p v-if="!editMode">{{ form.personal_code }}</p>
                        <input v-else v-model="form.personal_code" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Telefons:</p>
                        <p v-if="!editMode">{{ form.phone }}</p>
                        <input v-else v-model="form.phone" class="border p-1 rounded" />
                    </div>
                    <div>
                        <p class="font-semibold">Adrese:</p>
                        <p v-if="!editMode">{{ form.address }}</p>
                        <input v-else v-model="form.address" class="border p-1 rounded" />
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