<template>
    <footer class="bg-white/10 py-16 mt-16">     
        <div class="flex justify-center">
            <h1 class="text-white">Informações</h1>
        </div>
        <div class="flex flex-col ml-10 container mx-auto">
            <div class="divide-y divide-white/20 text-white">
                <div class="p-5"></div>
                <div class="p-5 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-indigo-500 w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="ml-2">
                        <p class="text-xs">Domingo e feriados: <b class="text-red-400">fechado</b></p>
                        <p class="mt-1 text-xs">Segunda-Feira a Sábado: <b>09:00 às 20:00</b></p>
                    </div>
                </div>
                <div class="p-5 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-indigo-500 w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <p class="ml-2 text-xs">(11) 97486-1759</p>
                </div>
                <div class="p-5"></div>
            </div>
        </div>

        <div class="flex justify-between ml-10 mt-10">
            <div class="flex flex-col text-white text-xs">
                <p>Rua Luís XV 144, Francisco Morato | SP</p>
                <p>Todos os direitos reservados © 2022</p>
            </div>
            
            <div class="flex mr-16 items-center">
                <p class="text-white mr-3 text-xs">Nos siga ou entre em contato conosco nas redes sociais:</p>
                <a href="'https://www.instagram.com/lh_barbershop/')" target="_blank">
                    <img src="assets/images/instagram.png" class="w-7 h-7 mr-2 cursor-pointer">
                </a>
                <a href="'https://api.whatsapp.com/send/?phone=5511966259025&text&type=phone_number&app_absent=0')" target="_blank">
                    <img src="assets/images/whatsapp.png" class="w-7 h-7 mr-2 cursor-pointer">
                </a>
                <img src="assets/images/facebook.png" class="w-7 h-7 mr-2 cursor-pointer">
            </div>
        </div>
    </footer>
</template>