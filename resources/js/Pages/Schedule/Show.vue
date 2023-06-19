<template>
    <Main>   
        <div v-if="mySchedules.length !== 0">

            <Modal 
                :modal="modal" 
                :errors="errors" 
                :idSchedule="idSchedulePending.length > 0 && idSchedulePending[0].id !== null ? idSchedulePending[0].id : ''"
                @closeModal="modal = false" 
            />

            <p class="text-white">Minhas agendas</p>
         
            <div 
                v-for="schedule in mySchedules" :key="schedule.id"
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
                        <div v-if="schedule.status === 'cancelado'">
                            <div class="flex ml-2">
                                <p class="font-bold">Quem cancelou:</p>
                                <span class="ml-2 text-gray-500">
                                cliente
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
        <div v-else>
            <p class="text-white">sem agenda</p>
        </div>
    </Main>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import { ref } from 'vue'
import CheckPending from '../Auth/components/icons/CheckPending.vue';
import CheckSuccess from '../Auth/components/icons/CheckSuccess.vue';
import CheckCancel from '../Auth/components/icons/CheckCancel.vue';
import Modal from '../../components/Modal.vue'
import { useToast } from "vue-toastification";
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    mySchedules: Object,
    errors: Object
})

const toast = useToast();
const page = usePage()

if (page.props.flash.success) {
    toast.success(`Sucesso! ${page.props.flash.success} :)`)
}

const idSchedulePending = props.mySchedules.filter(obj => obj.status === "pendente");
const modal = ref(false)

const openModal = () => {
    modal.value = true;
};

</script>