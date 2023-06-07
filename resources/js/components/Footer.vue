<template>
    <footer class="bg-white/10 py-16 mt-16">     
        <div class="flex justify-center">
            <h1 class="text-white">Informações</h1>
        </div>
        <div class="flex flex-col ml-10 container mx-auto">
            <div class="divide-y divide-white/20 text-white">
                <div class="p-5"></div>
                <div class="p-5 flex items-center">
                    <img class="h-8 w-8 rounded-full" src="assets/images/relogio.png">
                    <div class="ml-2">
                        <p class="text-xs">Domingo: <b class="text-red-400">fechado</b></p>
                        <p class="mt-1 text-xs">Segunda-Feira a Sábado: <b>09:00 às 20:00</b></p>
                    </div>
                </div>
                <div class="p-5 flex items-center">
                    <img class="h-8 w-8 rounded-full" src="assets/images/phone.png">
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