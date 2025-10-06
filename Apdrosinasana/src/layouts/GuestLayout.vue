<script setup>
import Header from '@/components/Header.vue';


</script>

<template>
    <div class="image min-h-screen bg-cover bg-center flex flex-col">
        <Header />
        <slot />
    </div>
</template>

<style scoped>
.image {
    background-image: url('@/assets/Home/background.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
}
</style>