<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import { ShieldUser } from 'lucide-vue-next';

</script>

<template>
  <GuestLayout>
    <div class="pl-5 mt-5 p-5 w-full h-150 flex flex-col justify-center items-start text-white gap-5">
		<div class="flex flex-col lg:ml-30 lg:max-w-[50%] animate__animated animate__fadeInLeft">

			<div class="bg-[#12182B]/93 backdrop-blur-md p-10 rounded-2xl shadow-2xl">
				<div class="mb-5">
					<h1 class="text-6xl text-[#E6F3FF] font-bold flex items-center gap-3 mb-3">
						<ShieldUser class="inline" size="60px"/>
						ShieldPoint
					</h1>
					<h2 class="text-2xl text-[#A6C8FF]">
						Jūsu uzticamais apdrošināšanas partneris
					</h2>
				</div>
				<p class="text-lg text-[#C9D6E2] leading-relaxed">
					Mēs piedāvājam plašu apdrošināšanas pakalpojumu klāstu, lai aizsargātu Jūs un Jūsu īpašumu no neparedzētiem notikumiem. 
					Sazinieties ar mums jau šodien, lai uzzinātu vairāk par mūsu piedāvājumiem un kā mēs varam palīdzēt Jums justies droši un aizsargātiem.
				</p>
			</div>
		</div>
	</div>
  </GuestLayout>
</template>
