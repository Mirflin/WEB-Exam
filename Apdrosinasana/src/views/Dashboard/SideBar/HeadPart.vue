<script setup>
import { ListIcon, ChevronDownIcon, ChevronUpIcon, CirclePowerIcon } from 'lucide-vue-next';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';
import { Notivue, Notification, push } from 'notivue'

const auth = useAuthStore()
const router = useRouter()
const dropdown = ref(false)
const emit = defineEmits(['dashboard'])

const logOut = async() => {
    await auth.logout()
    router.push('/')
    push.success('Jūs esat izlogojies!')
}
</script>

<template>
    <Notivue v-slot="item">
        <Notification :item="item" />
    </Notivue>
    <div class="w-full h-20 bg-gray-100 shadow-md justify-between border-b border-gray-300 flex items-center pl-5 pr-10">
        <div @click="emit('dashboard')" class="p-3 w-fit flex justify-between items-center cursor-pointer border-1 rounded-md hover:bg-gray-300">
            <ListIcon />
        </div>
        <div class="flex items-center ml-5 text-lg font-bold">
            <DropdownMenu v-model:open="dropdown">
                <DropdownMenuTrigger @click="dropdown = !dropdown" class="flex items-center cursor-pointer gap-2">
                    {{ auth.user.name }}
                    <ChevronDownIcon v-if="!dropdown" />
                    <ChevronUpIcon v-else />
                </DropdownMenuTrigger>

                <DropdownMenuContent class="mt-2 bg-white" :align="'end'">
                    <DropdownMenuItem @click="logOut" class="cursor-pointer hover:bg-gray-200"><CirclePowerIcon />Iziet</DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    </div>
</template>