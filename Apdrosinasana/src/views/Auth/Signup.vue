<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import {ref} from 'vue'
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { Notivue, Notification, push } from 'notivue'

const auth = useAuthStore()
const router = useRouter()

const form = ref({
    name: '',
    email: '',
    personal_code: '',
    address: '',
    phone: '',
    password:'',
    password_confirmation: ''
})

const loading = ref(false)

const submit = async() => {
    loading.value = true

    if(form.value.password !== form.value.password_confirmation){
        push.error('Paroli nesakrīt!')
        loading.value = false
        return
    }else if(form.value.password.length < 8){
        push.error('Parolam jābūt vismaz 8 simbolus garam!')
        loading.value = false
        return
    }else if(form.value.personal_code.length !== 11){
        push.error('Personālajam kodam jābūt 11 simbolus garam!')
        loading.value = false
        return
    }else if(form.value.phone.length < 8){
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
    }

    const response = await auth.register(form.value)

    if(!response){
        router.push('/login')
    }else{
        push.error('Nepareiz parols vai e-pasts!')
    }
}

</script>

<template>
    <Notivue v-slot="item">
        <Notification :item="item" />
    </Notivue>
    <GuestLayout>
        <div class="w-full h-auto mb-20 flex justify-center align-center">
            <div class="w-full lg:w-[40%]  bg-[#12182B]/60 flex flex-col gap-5 backdrop-blur-md p-5 rounded-2xl shadow-2xl backdrop-blur-md bg-opacity-10 text-white">
                <div class="absolute top-5 left-5 text-sm cursor-pointer hover:text-gray-500">
                    <RouterLink to="/login"><- Ielogoties</RouterLink>
                </div>
                <h1 class="text-3xl text-center w-full">Registrēties</h1>
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
                    <div class="flex flex-col gap-1">
                        <Label class="text-lg w-20">Parols: </Label>
                        <Input type="password" v-model="form.password" class="text-xl"></Input>
                    </div>
                    <div class="flex flex-col gap-1">
                        <Label class="text-lg w-40">Atkartot parols: </Label>
                        <Input type="password" v-model="form.password_confirmation" class="text-xl"></Input>
                    </div>
                    <Button @click="submit" class="p-2 mt-10 bg-blue-600 cursor-pointer hover:bg-blue-400">{{ loading ? '...' : 'Registrēties' }}</Button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>