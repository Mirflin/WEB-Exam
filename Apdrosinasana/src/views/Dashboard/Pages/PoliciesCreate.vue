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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import { ref } from 'vue';
import axios from 'axios';
import moment from 'moment';

const props = defineProps(['open']);
const emit = defineEmits(['close', 'notify']);

const form = ref({
    policy_number: '',
    type: '',
    start_date: moment().format('YYYY-MM-DD'),
    end_date: moment().format('YYYY-MM-DD'),
})

const save = async() => {
    if(form.value.policy_number.length < 5){
        emit('notify', 'error','Polises numuram jābūt vismaz 5 simbolus garam!')
        return
    }else if(form.value.type.length < 3){
        emit('notify', 'error','Polises tipam jābūt vismaz 3 simbolus garam!')
        return
    }

    const response = await axios.post('/api/policies-create', form.value);
    emit('notify', 'success','Polise veiksmīgi izveidota!');
    emit('close');
}

</script>

<template>
    <Dialog :open="props.open" @close="emit('close')" @openChange="emit('close')">
        <DialogContent class="sm:max-w-[600px] bg-white">
        <DialogHeader>
            <DialogTitle>Ievietot polisi</DialogTitle>
            <DialogDescription>
            Veiciet izmaiņas savā profilā šeit. Noklikšķiniet uz saglabāt, kad esat pabeidzis.
            </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4 py-4">
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="name" class="text-right">
                Polise numurs
            </Label>
            <Input v-model="form.policy_number" class="col-span-3" />
            </div>
            <div class="grid grid-cols-4 items-center gap-4">
            <Label for="username" class="text-right">
                Tips
            </Label>
            <Select v-model="form.type" default-value="-" >
                <SelectTrigger class="w-40">
                <SelectValue placeholder="Izvēlēties tipu" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup class="bg-white z-[99999]">
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
            </div>
        </div>
        <DialogFooter>
            <Button @click="emit('close')" class="bg-gray-500 text-white hover:bg-gray-600 cursor-pointer">Atcelt</Button>
            <Button :disabled="!form.policy_number || !form.type" @click="save" class="bg-blue-500 text-white hover:bg-blue-600 cursor-pointer">Saglabāt</Button>
        </DialogFooter>
        </DialogContent>
    </Dialog>
</template>