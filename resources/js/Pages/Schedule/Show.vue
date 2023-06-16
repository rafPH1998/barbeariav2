<template>
    <Main>   

        <Modal 
            :modal="modal" 
            @closeModal="modal = false" 
        />

        <p class="text-white">Minhas agendas</p>
         
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
                    <a 
                        @click.prevent="openModal()"
                        v-if="mySchedules.status === 'pendente'"
                        type="button"
                        class="bg-red-600 hover:bg-red-700
                        font-bold rounded-full
                        mt-12 text-center w-full
                        text-white text-xs cursor-pointer">
                        Cancelar
                    </a>
                </div>
                <div class="flex flex-col px-4 py-1">
                    <h1 class=""> {{mySchedules.service == 'corte' ? 'corte' : 'corte + barba'}}</h1>
                    <div class="flex ml-2">
                        <p class="font-bold">Status:</p>
                        <span class="ml-2 text-gray-500 flex"> 
                            <p>{{mySchedules.status}} </p>
                            <p class="ml-1">
                                <CheckPending v-show="mySchedules.status === 'pendente'" height="h-6" width="w-6"/>
                                <CheckSuccess v-show="mySchedules.status === 'finalizado'" height="h-6" width="w-6"/>
                                <CheckCancel  v-show="mySchedules.status === 'cancelado'" height="h-6" width="w-6"/>
                            </p>
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
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue'
import CheckPending from '../Auth/components/icons/CheckPending.vue';
import CheckSuccess from '../Auth/components/icons/CheckSuccess.vue';
import CheckCancel from '../Auth/components/icons/CheckCancel.vue';
import Modal from '../../components/Modal.vue'

defineProps({
    mySchedules: Object
})

const page = usePage()
const modal = ref(false)

const dateAndHour = computed(() => {
    const created_at =  page.props.mySchedules.created_at
    const dataHora = created_at.split(" ");
    return dataHora;
})


const openModal = () => {
    modal.value = true;
};


</script>