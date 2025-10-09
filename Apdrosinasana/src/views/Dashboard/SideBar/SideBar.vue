<script setup>
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const auth = useAuthStore()
const props = defineProps(['open', 'component']);
const emit = defineEmits(['component']);

</script>

<template>
    <div v-auto-animate >
        <div class="min-w-64 h-screen bg-gray-800 text-white" :class="{ 'block': props.open, 'hidden': !props.open }" v-auto-animate>
            <div class="p-2 w-full border-b border-gray-700 flex justify-start items-center gap-2">
                <button @click="emit('component', 'profile')" class="flex items-center gap-2 cursor-pointer">
                    <img class="w-16" src="@/assets/logo.png" />
                </button>

                <div>
                    <h1 class="text-2xl font-bold">ShieldPoint</h1>
                    <p class="text-sm">Informācijas panelis</p>
                </div>
            </div>
            <div class="h-full p-5 flex flex-col items-start gap-3">
                <Button @click="emit('component', 'profile')" :class="props.component === 'profile' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Mans profils</Button>
                <Button @click="emit('component', 'policies')" :class="props.component === 'policies' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Apdrošināšanas polises</Button>
                <Button @click="emit('component', 'payments')" :class="props.component === 'payments' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Maksājumi vēsture</Button>

                <div v-if="auth.user.role_id == 1" class="w-full border-t pt-3 flex flex-col gap-3 border-gray-700">
                    <Button @click="emit('component', 'admin')" :class="props.component === 'admin' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Admin panelis</Button>
                    <Button @click="emit('component', 'users')" :class="props.component === 'users' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Lietotāji</Button>
                    <Button @click="emit('component', 'allpolicies')" :class="props.component === 'allpolicies' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Polises</Button>
                    <Button @click="emit('component', 'allpayments')" :class="props.component === 'allpayments' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Maksājumi</Button>
                    <Button @click="emit('component', 'contacts')" :class="props.component === 'contacts' ? 'bg-gray-700' : ''" class="text-lg p-2 rounded-md hover:bg-gray-700 cursor-pointer w-full text-left">Kontakti</Button>
                </div>
            </div>
        </div>
    </div>
</template>