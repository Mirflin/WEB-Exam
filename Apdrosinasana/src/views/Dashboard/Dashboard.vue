<script setup>
import SideBar from './SideBar/SideBar.vue';
import HeadPart from './SideBar/HeadPart.vue';
import { onMounted, onUnmounted, ref, defineAsyncComponent } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useLocalStorage } from '@vueuse/core';

const auth = useAuthStore()
const open = ref(true)
const comp = useLocalStorage('component', 'profile')

onMounted(() => {
    if(window.innerWidth < 768){
        open.value = false
    }
})


const setComponent = (component) => {
    comp.value = component
}

const components = {
    profile: defineAsyncComponent(() => import('./Pages/Profile.vue')),
    policies: defineAsyncComponent(() => import('./Pages/Policies.vue')),
    payments: defineAsyncComponent(() => import('./Pages/Payments.vue')),
}


</script>

<template>
    <div class="flex">
        <SideBar :component="comp" @component="setComponent" :open="open"></SideBar>
        <div class="flex-1 flex-col">
            <HeadPart  @dashboard="open = !open"></HeadPart>
            <component :is="components[comp]" class="p-5"></component>
        </div>
    </div>
</template>

<style scoped>
body {
  overflow-y: scroll;
  scrollbar-width: none;
}
</style>