<script setup>
import { LogInIcon } from 'lucide-vue-next';

</script>

<template>
    <div class="w-screen fixed z-[2] h-auto p-5 flex justify-between items-center">
        <img class="w-30" src="@/assets/logo.png"></img>
        <nav class="flex gap-4 items-center">
            <RouterLink to="/" href="#" class="text-white text-lg font-semibold hover:underline">Sākums</RouterLink>
            <RouterLink to="/#parmums" href="#parmums" class="text-white text-lg font-semibold hover:underline ml-4">Par mums</RouterLink>
            <RouterLink to="/#pakalpojumi" href="#pakalpojumi" class="text-white text-lg font-semibold hover:underline ml-4">Pakalpojumi</RouterLink>
            <RouterLink to="/#kontakti" href="#kontakti" class="text-white text-lg font-semibold hover:underline ml-4">Kontakti</RouterLink>
            <RouterLink to="/login" class="font-bold py-2 px-4 rounded-full text-white hover:text-gray-500 cursor-pointer"><LogInIcon></LogInIcon></RouterLink>
        </nav>
    </div>
</template>