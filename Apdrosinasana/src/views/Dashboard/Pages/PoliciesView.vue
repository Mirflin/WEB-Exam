<script setup>
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Calendar } from "@/components/ui/calendar"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import {
  DateFormatter,
  getLocalTimeZone,
} from "@internationalized/date"

import { CalendarIcon } from "lucide-vue-next"
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';
import axios from 'axios';
import moment from 'moment';

const props = defineProps(['open', 'policy']);
const emit = defineEmits(['close', 'notify', 'refresh']);

const form = ref({
    policy_id: props.policy,
    ammout: '',
    until: '',
})

const save = async() => {
    if(!form.value.ammout || !form.value.until){
        emit('notify', 'error','Lūdzu, aizpildiet visus laukus!')
        return
    }

    if (moment(form.value.until).isBefore(moment())) {
        emit('notify', 'error', 'Datums ir pagājis!')
        return
    }

    form.value.until = moment(form.value.until).format('YYYY-MM-DD')

    const response = await axios.post('/api/policies-pay', form.value);
    emit('notify', 'success','Polise veiksmīgi apmaksāta!');
    emit('refresh');
    emit('close');
}

</script>

<template>
    <Dialog :open="props.open" @close="emit('close')" @openChange="emit('close')">
        <DialogContent class="sm:max-w-[600px] bg-white">
        <DialogHeader>
            <DialogTitle>Apmaksāt polisi</DialogTitle>
            <DialogDescription>
            Veiciet apmaksu polisa šeit.
            </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4 py-4">
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right">
                Summa (EUR)
            </Label>
            <Input type="number" v-model="form.ammout" class="col-span-3" />
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="username" class="text-right">
                Līdz
            </Label>
            <Popover>
                <PopoverTrigger as-child>
                <Button
                    variant="outline"
                >
                    <CalendarIcon class="mr-2 h-4 w-4" />
                    {{ form.until ? moment(form.until.toDate(getLocalTimeZone())).format('YYYY-MM-DD') : "Pick a date" }}
                </Button>
                </PopoverTrigger>
                <PopoverContent class="w-auto p-0">
                <Calendar class="bg-white" v-model="form.until" initial-focus />
                </PopoverContent>
            </Popover>
            </div>
        </div>
        <DialogFooter>
            <Button @click="emit('close')" class="bg-gray-500 text-white hover:bg-gray-600 cursor-pointer">Atcelt</Button>
            <Button :disabled="!form.ammout || !form.until" @click="save" class="bg-blue-500 text-white hover:bg-blue-600 cursor-pointer">Saglabāt</Button>
        </DialogFooter>
        </DialogContent>
    </Dialog>
</template>