<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import { ShieldUser, HouseHeart, Car, TrafficCone, House, Phone } from 'lucide-vue-next';

</script>

<template>
  <GuestLayout>
    <div class="pl-5 mt-5 p-5 w-full flex flex-col justify-center items-start text-white gap-5">
		<section id="" class="flex flex-col lg:ml-30 lg:max-w-[50%] animate__animated animate__fadeInLeft">
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
		</section>

		<section id="parmums" class="mt-50 w-full flex flex-row-reverse justify-between items-center text-right p-10 animate__animated animate__fadeInUp scroll-mt-50">
			<div class="bg-[#12182B]/30 backdrop-blur-md p-5 rounded-2xl shadow-2xl max-w-4xl backdrop-blur-md bg-opacity-10">
				<h2 class="text-4xl font-bold text-white mb-5 hover:text-gray-200 transition-colors duration-300">Par mums</h2>
				<p class="max-w-3xl text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
					Mēs esam apdrošināšanas uzņēmums ar vairāk nekā 20 gadu pieredzi nozarē. Mūsu misija ir nodrošināt klientiem visaptverošu apdrošināšanas risinājumu klāstu, kas pielāgoti viņu individuālajām vajadzībām. 
					Mēs lepojamies ar mūsu profesionālo un draudzīgo pieeju, kā arī ar spēju piedāvāt konkurētspējīgas cenas un izcilu klientu apkalpošanu.
				</p>
			</div>
			<img src="@/assets/Home/protection.png" class="w-50"></img>
		</section>

		<section id="pakalpojumi" class="mt-50 scroll-mt-50">
			<div class="bg-[#12182B]/30 backdrop-blur-md p-5 rounded-2xl shadow-2xl w-full backdrop-blur-md bg-opacity-10 ">
				<h2 class="text-4xl font-bold text-white mb-5 text-center hover:text-gray-200 transition-colors duration-300">Pakalpojumi</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-10">
					<div class="flex flex-col gap-3 p-5 bg-[#1E2A45]/50 rounded-lg hover:bg-[#1E2A45]/70 transition-colors duration-300 hover:scale-[1.05]">
						<h3 class="text-2xl font-semibold text-white mb-3 hover:text-gray-200 transition-colors duration-300 flex items-center gap-2"><HouseHeart class=""></HouseHeart>Dzīvības apdrošināšana</h3>
						<p class="text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
							Aizsargājiet savus mīļos ar mūsu dzīvības apdrošināšanas plāniem, kas nodrošina finansiālu drošību neparedzētos gadījumos.
						</p>
					</div>

					<div class="flex flex-col gap-3 p-5 bg-[#1E2A45]/50 rounded-lg hover:bg-[#1E2A45]/70 transition-colors duration-300 hover:scale-[1.05]">
						<h3 class="text-2xl font-semibold text-white mb-3 hover:text-gray-200 transition-colors duration-300 flex items-center gap-2"><Car></Car>Mašīnu apdrošināšana</h3>
						<p class="text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
							Mūsu mašīnu apdrošināšanas plāni piedāvā plašu segumu, lai Jūs varētu braukt ar mieru, zinot, ka Jūsu transportlīdzeklis ir aizsargāts.
						</p>
					</div>

					<div class="flex flex-col gap-3 p-5 bg-[#1E2A45]/50 rounded-lg hover:bg-[#1E2A45]/70 transition-colors duration-300 hover:scale-[1.05]">
						<h3 class="text-2xl font-semibold text-white mb-3 hover:text-gray-200 transition-colors duration-300 flex items-center gap-2"><TrafficCone></TrafficCone>Ceļojuma apdrošināšana</h3>
						<p class="text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
							Brauciet droši ar mūsu ceļojuma apdrošināšanas plāniem, kas sedz medicīniskos izdevumus, ceļojuma atcelšanu un citas neparedzētas situācijas.
						</p>
					</div>

					<div class="flex flex-col gap-3 p-5 bg-[#1E2A45]/50 rounded-lg hover:bg-[#1E2A45]/70 transition-colors duration-300 hover:scale-[1.05]">
						<h3 class="text-2xl font-semibold text-white mb-3 hover:text-gray-200 transition-colors duration-300 flex items-center gap-2"><House></House>Īpašumu apdrošināšana</h3>
						<p class="text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
							Aizsargājiet savu māju un īpašumu ar mūsu īpašumu apdrošināšanas plāniem, kas sedz bojājumus, zādzības un citas neparedzētas situācijas.
						</p>
					</div>
				</div>
			</div>
		</section>

		<section id="kontakti" class="w-full mt-50 flex flex-col justify-start items-start text-left p-10 gap-5 animate__animated animate__fadeInUp">
			<div class="bg-[#12182B]/30 flex flex-row gap-5 backdrop-blur-md p-5 rounded-2xl shadow-2xl w-full backdrop-blur-md bg-opacity-10">
				<div class="flex-1 flex flex-col">
					<h2 class="text-4xl font-bold text-white mb-5 hover:text-gray-200 transition-colors duration-300 flex gap-5 items-center"><Phone></Phone>Kontakti</h2>
					<p class="max-w-3xl text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
						Ja Jums ir kādi jautājumi vai vēlaties uzzināt vairāk par mūsu pakalpojumiem, lūdzu, sazinieties ar mums:
					</p>
					<ul class="list-disc mt-10 list-inside text-lg text-white leading-relaxed hover:text-gray-200 transition-colors duration-300">
						<li>Reģistrācijas numurs: 0000000000</li>
						<li>Tālrunis: +371 123 456 78</li>
						<li>E-pasts: shieldpoint@shield.com</li>
					</ul>
				</div>
				<div class="flex-1">
					<iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d388.9228426891188!2d21.02692143276609!3d56.53526972166431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46faa7ccb271be93%3A0xf9d1bf3406ae7d9d!2sLiep%C4%81jas%20Valsts%20tehnikums!5e0!3m2!1sen!2slv!4v1759862295897!5m2!1sen!2slv" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</section>

	</div>
  </GuestLayout>
</template>
