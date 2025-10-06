<script setup>
import Button from './ui/button/Button.vue';
</script>

<template>
    <div class="w-screen h-auto p-5 flex justify-between items-center">
        <img class="w-40" src="@/assets/logo.png"></img>
        <nav class="flex gap-4 items-center">
            <a href="#" class="text-white text-lg font-semibold hover:underline">Sākums</a>
            <a href="#" class="text-white text-lg font-semibold hover:underline ml-4">Par mums</a>
            <a href="#" class="text-white text-lg font-semibold hover:underline ml-4">Servisi</a>
            <a href="#" class="text-white text-lg font-semibold hover:underline ml-4">Kontakti</a>
            <Button class="ml-4 bg-white text-blue-600 font-bold py-2 px-4 rounded-full hover:bg-gray-200 cursor-pointer">Ielogoties</Button>
        </nav>
    </div>
</template>