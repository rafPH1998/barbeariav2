<template>
    <Main>
        <p class="text-white">minhas agendas</p>
        <div class="border-collapse border border-gray-700 mt-6 rounded-lg flex justify-between">
            <div class="flex">
                <div class="border-collapse border-r h-full border-gray-700 flex flex-col items-center px-4 py-1">
                    <h1>16/JUN/2023</h1>
                    <p class="text-xs">9:00</p>
                    <p class="text-xs">sexta-feira</p>

                    <Link 
                        type="button"
                        class="bg-red-600 hover:bg-red-700
                        font-bold rounded-full
                        mt-12 text-center w-full
                        text-white text-xs">
                        Cancelar
                    </Link>
                </div>
                <div class="flex flex-col px-4 py-1">
                    <h1 class="">Corte</h1>
                    <div class="flex ml-2">
                        <p class="font-bold">Status:</p>
                        <span class="text-yellow-500 ml-2"> 
                            Pendente
                        </span>
                    </div>
                    <div class="flex ml-2">
                        <p class="font-bold">Duração:</p>
                        <span class="ml-2 text-gray-500">20min*</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex p-2">
                    <div class="w-full items-center flex-col flex">
                        <h1 class="text-orange-400 font-bold">Lh Barbeshop</h1>
                        <p class="text-xs">Rua Luís XV 144</p>
                        <p class="text-xs">Francisco Morato</p>
                    </div>
                    <img class="h-24 w-24" src="/assets/images/lh.jpg">
                </div>
                <p class="text-xs py-2 mr-2 text-orange-400 italic">Agendado por você em 15/06/2023 às 12:30</p>
            </div>
        </div>
    </Main>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import { Link } from '@inertiajs/vue3';
</script>