<script setup>
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';

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
            </div>
        </div>
    </div>
</template>