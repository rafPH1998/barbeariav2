<template>
    <Main>   
        <div v-if="mySchedules.data.length !== 0">

            <Modal 
                :modal="modal" 
                :errors="errors" 
                :idSchedule="idSchedulePending.length > 0 && idSchedulePending[0].id !== null ? idSchedulePending[0].id : ''"
                @closeModal="modal = false" 
            />

            <p class="text-white">Minhas agendas</p>
         
            <div 
                v-for="schedule in mySchedules.data" :key="schedule.id"
                :class="[
                    schedule.status === 'finalizado' 
                    ||
                    schedule.status === 'cancelado' ? 'bg-white/10' : ''
                ]"
                class="border-collapse border border-gray-700 mt-6 rounded-lg flex justify-between">
                <div class="flex">
                    <div class="border-collapse border-r h-full border-gray-700 flex flex-col items-center px-4 py-1">
                        <h1>{{schedule.month_of_year}}</h1>
                        <p class="text-xs">{{schedule.hour}}</p>
                        <p class="text-xs">{{schedule.day_of_week}}</p>
                        <a 
                            @click.prevent="openModal()"
                            v-if="schedule.status === 'pendente'"
                            type="button"
                            class="bg-red-600 hover:bg-red-700
                            font-bold rounded-full
                            mt-12 text-center w-full
                            text-white text-xs cursor-pointer">
                            Cancelar
                        </a>
                    </div>
                    <div class="flex flex-col px-4 py-1">
                        <h1 class=""> {{schedule.service == 'corte' ? 'corte' : 'corte + barba'}}</h1>
                        <div class="flex ml-2">
                            <p class="font-bold">Status:</p>
                            <span class="ml-2 text-gray-500 flex"> 
                                <p>{{schedule.status}} </p>
                                <p class="ml-1">
                                    <CheckPending v-show="schedule.status === 'pendente'" height="h-6" width="w-6"/>
                                    <CheckSuccess v-show="schedule.status === 'finalizado'" height="h-6" width="w-6"/>
                                    <CheckCancel  v-show="schedule.status === 'cancelado'" height="h-6" width="w-6"/>
                                </p>
                            </span>
                        </div>
                        <div class="flex ml-2">
                            <p class="font-bold">Duração:</p>
                            <span class="ml-2 text-gray-500">
                                {{schedule.service == 'corte' ? '30' : '45'}}min*
                            </span>
                        </div>
                        <div class="flex ml-2">
                            <p class="font-bold">Barbeiro:</p>
                            <span class="ml-2 text-gray-500">
                                {{schedule.barber_name}}
                            </span>
                        </div>
                        <div v-if="schedule.status === 'cancelado'">
                            <div class="flex ml-2">
                                <p class="font-bold">Quem cancelou:</p>
                                   <span v-if="schedule.user_id !== schedule.author_canceled_id" class="ml-2 text-gray-500">
                                    Barbearia
                                </span>
                                <span v-else class="ml-2 text-gray-500">
                                    Cliente
                                </span>
                            </div>
                            <div  
                                class="flex text-xs mt-6">
                                <p class="font-bold">Motivo do cancelamento:</p>
                                <span class="ml-2 text-gray-500">
                                    {{ schedule.description }}
                                </span>
                            </div>
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
                    <p class="text-xs py-2 mr-2 text-orange-400 italic">{{schedule.created_at}}</p>
                </div>
            </div>
        </div>
        <div v-else class="border-collapse border border-gray-700 p-10 rounded-lg flex">
            <p class="text-white">Você não tem nenhuma agenda no momento</p>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
            </svg>
        </div>
        <div class="flex flex-row-reverse mt-5">
            <Pagination 
                :data="mySchedules"
                @changePage="changePage"
            />
        </div>
    </Main>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import { ref } from 'vue'
import CheckPending from '../Auth/components/icons/CheckPending.vue';
import CheckSuccess from '../Auth/components/icons/CheckSuccess.vue';
import CheckCancel from '../Auth/components/icons/CheckCancel.vue';
import Pagination from '../../components/Pagination.vue';
import Modal from '../../components/Modal.vue'
import { useToast } from "vue-toastification";
import { usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    mySchedules: {
        type: Object
    },
    errors: {
        type: Object
    }
})

console.log(props.mySchedules)

const toast = useToast();
const page = usePage()

if (page.props.flash.success) {
    toast.success(`Sucesso! ${page.props.flash.success} :)`)
}

const changePage = (page) => {
    router.get('/schedules/my-schedules', {
        page
    });
}
const idSchedulePending = props.mySchedules.data.filter(obj => obj.status === "pendente");
const modal = ref(false)

const openModal = () => modal.value = true
</script>