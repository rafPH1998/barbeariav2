<template>
    <Main>
        <p class="text-white">minhas agendas</p>
         
        <div 
            :class="[
                mySchedules.status === 'finalizado' 
                ||
                mySchedules.status === 'cancelado' ? 'bg-white/10' : ''
            ]"
            class="border-collapse border border-gray-700 mt-6 rounded-lg flex justify-between">
            <div class="flex">
                <div class="border-collapse border-r h-full border-gray-700 flex flex-col items-center px-4 py-1">
                    <h1>{{mySchedules.month_of_year}}</h1>
                    <p class="text-xs">{{mySchedules.hour}}</p>
                    <p class="text-xs">{{mySchedules.day_of_week}}</p>

                    <Link 
                        v-if="mySchedules.status === 'pendente'"
                        type="button"
                        class="bg-red-600 hover:bg-red-700
                        font-bold rounded-full
                        mt-12 text-center w-full
                        text-white text-xs">
                        Cancelar
                    </Link>
                </div>
                <div class="flex flex-col px-4 py-1">
                    <h1 class=""> {{mySchedules.service == 'corte' ? 'corte' : 'corte + barba'}}</h1>
                    <div class="flex ml-2">
                        <p class="font-bold">Status:</p>
                        <span 
                            :class="[
                                mySchedules.status === 'pendente' ? 'text-yellow-500' : 
                                (mySchedules.status === 'cancelado' ? 'text-red-500' : 'text-green-500')
                            ]"
                            class="ml-2"> 
                            {{mySchedules.status}}
                        </span>
                    </div>
                    <div class="flex ml-2">
                        <p class="font-bold">Duração:</p>
                        <span class="ml-2 text-gray-500">
                            {{mySchedules.service == 'corte' ? '30' : '45'}}min*
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex p-2">
                    <div class="w-full items-center flex-col flex">
                        <h1 class="text-orange-400 font-bold">LH Barbeshop</h1>
                        <p class="text-xs">Rua Luís XV 144</p>
                        <p class="text-xs">Francisco Morato</p>
                    </div>
                    <img class="h-24 w-24" src="/assets/images/lh.jpg">
                </div>
                <p class="text-xs py-2 mr-2 text-orange-400 italic">Agendado por você em {{dateAndHour[0]}} às {{dateAndHour[1]}}</p>
            </div>
        </div>
    </Main>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'

defineProps({
    mySchedules: Object
})

const page = usePage()

const dateAndHour = computed(() => {
    const created_at =  page.props.mySchedules.created_at
    const dataHora = created_at.split(" ");
    return dataHora;
})

</script>