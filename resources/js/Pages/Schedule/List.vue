<template>
    <div>
        <Main>
            <Modal 
                :modal="modal" 
                :errors="errors" 
                :objectUserSelected="objectUserSelected"
                @closeModal="modal = false" 
            />

            <div id="last-users mt-10">
                <h1 class="font-bold py-4 uppercase">Tabela de agendamentos</h1>

                <div class="flex justify-between mt-5">
                    <div>
                        <p class="text-xs">Busque agendas por alguma data</p>
                        <form action="#" @submit.prevent="filterDate()" class="mt-1">
                            <input type="text"
                                placeholder="Ex: (00/00/0000)"
                                v-model="date"
                                @input="formatDate"
                                class="py-2.5 px-3 ml-0 bg-transparent
                                leading-tight text-gray-500 rounded-l-lg outline-none
                                border-collapse border border-gray-700 text-xs">
                            <button 
                                id="search"
                                class="text-white font-bold text-xs hover:bg-indigo-600
                                rounded-r-lg border border-indigo-500">
                                Buscar
                            </button>
                        </form>
                    </div>
                    <div>
                        <ul class="flex">
                            <li @click="selectStatus('pendente')" 
                                :class="{ 'bg-indigo-600': props.status === 'pendente' || props.status == null}"
                                class="border-collapse border border-indigo-500 text-xs rounded-full 
                                px-3 py-1 cursor-pointer hover:bg-indigo-600 font-bold">
                                Pendentes ({{props.count_status !== null ? props.count_status.count_pending : '0'}})
                            </li>
                            <li @click="selectStatus('finalizado')" 
                                :class="{ 'bg-indigo-600': props.status === 'finalizado' }"
                                class="ml-2 border-collapse border border-indigo-500 text-xs rounded-full 
                                px-3 py-1 cursor-pointer hover:bg-indigo-600 font-bold">
                                Finalizados ({{props.count_status !== null ? props.count_status.count_finished : '0'}})
                            </li>
                            <li @click="selectStatus('cancelado')" 
                                :class="{ 'bg-indigo-600': props.status === 'cancelado' }"
                                class="ml-2 border-collapse border border-indigo-500 text-xs rounded-full 
                                px-3 py-1 cursor-pointer hover:bg-indigo-600 font-bold">
                                Cancelados ({{props.count_status !== null ? props.count_status.count_canceleds : '0'}})
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6">
                    <table class="w-full whitespace-nowrap text-white text-xs">
                        <thead class="bg-black/60">
                            <tr class="text-center">
                                <th class="py-3 px-2 rounded-l-lg">Foto</th>
                                <th class="py-3 px-2">Nome</th>
                                <th class="py-3 px-2">Serviço</th>
                                <th class="py-3 px-2">Status</th>
                                <th class="py-3 px-2">Dia do agendamento</th>
                                <th class="py-3 px-2">Início</th>
                                <th class="py-3 px-2">Término</th>
                                <th class="py-3 px-2 rounded-r-lg">{{nameColumn}}</th>
                            </tr>                          
                        </thead>
                        <tbody v-for="schedule in schedules.data" :key="schedule.id">
                            <tr class="border-b border-gray-700 text-center">
                                <td 
                                    :class="[
                                        schedule.cancellation_reason ? 'py-12': 'py-3'
                                    ]"
                                    class="px-2 flex justify-center">
                                    <img class="h-8 w-8 rounded-full" 
                                        :src="[
                                            schedule.user.image ? '/storage/' + schedule.user.image : '/assets/images/user.svg'
                                        ]"
                                    >
                                </td>
                                <td class="py-3 px-2">{{schedule.user.name}}</td>
                                <td class="py-3 px-2">{{schedule.service}}</td>
                                <td class="py-3 px-2">
                                <div class="text-gray-500 flex justify-center items-center ml-4"> 
                                    <p>{{schedule.status}}</p>
                                    <p class="ml-1">
                                        <CheckPending v-show="schedule.status === 'pendente'" height="h-6" width="w-6"/>
                                        <CheckSuccess v-show="schedule.status === 'finalizado'" height="h-6" width="w-6"/>
                                        <CheckCancel  v-show="schedule.status === 'cancelado'" height="h-6" width="w-6"/>
                                    </p>
                                </div>
                                </td>                          
                                <td 
                                    :class="{
                                        'line-through text-gray-500': schedule.status === 'finalizado', 
                                        'line-through text-red-500': schedule.status === 'cancelado'
                                    }" 
                                    class="py-3 px-2">{{schedule.date}}
                                </td>

                                <td :class="{
                                        'line-through text-gray-500': schedule.status === 'finalizado', 
                                        'line-through text-red-500': schedule.status === 'cancelado'
                                    }" 
                                    class="py-3 px-2">{{schedule.hour}}
                                </td>

                                <td :class="{
                                        'line-through text-gray-500': schedule.status === 'finalizado', 
                                        'line-through text-red-500': schedule.status === 'cancelado'
                                    }" 
                                    class="py-3 px-2">{{schedule.end_service}}
                                </td>
                                <td class="py-3 px-2" v-if="schedule.status === 'pendente'">
                                    <a 
                                        @click.prevent="openModal(schedule)"
                                        type="button"
                                        class="bg-red-600 hover:bg-red-700
                                        font-bold rounded-full text-center w-full
                                        text-white text-xs cursor-pointer">
                                        Cancelar
                                    </a>
                                </td>
                                <td class="py-12" v-show="nameColumn == 'Motivo do cancelamento'">
                                    <p class="text-indigo-500 font-medium text-xs  whitespace-pre-line"> 
                                        {{schedule.cancellation_reason}}
                                    </p>
                                </td>
                            </tr> 
                        </tbody>                       
                    </table>
                </div>
            </div>
            <div class="flex flex-row-reverse mt-5">
                <Pagination 
                    :data="schedules"
                    @changePage="changePage"
                />
            </div>
        </Main> 
     </div>
 </template>
 
<script setup>
import Main from '../Layouts/Main.vue';
import CheckPending from '../Auth/components/icons/CheckPending.vue';
import CheckSuccess from '../Auth/components/icons/CheckSuccess.vue';
import CheckCancel from '../Auth/components/icons/CheckCancel.vue';
import Pagination from '../../components/Pagination.vue';
import Modal from '../../components/Modal.vue'
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    schedules: Object,
    errors: Object,
    status: String,
    dateSelected: String,
    count_status: Array
})

const date = ref('')
const modal = ref(false)
const objectUserSelected = ref('')

const nameColumn = computed(() => {
    const pendings = props.schedules.data.filter(obj => obj.status === 'pendente')
    const cancelds = props.schedules.data.filter(obj => obj.status === 'cancelado')

    if (pendings.length !== 0) {
        return 'Ação'
    } else if(cancelds.length !== 0) {
        return 'Motivo do cancelamento'
    }
})

const selectStatus = (selectedStatus) => {
    router.get('/schedules', {status: selectedStatus });
};

const filterDate = () => {
    router.get('/schedules', {date: date.value });
};

const changePage = (page) => {
    router.get('/schedules', {
        status: props.status, 
        date  : props.dateSelected, 
        page
    });
}

const openModal = (obj) => { 
    modal.value = true
    objectUserSelected.value = obj
}

const formatDate = (event) => {
    const input = event.target;
    let inputValue = input.value.replace(/\D/g, '');

    if (inputValue.length > 8) {
        inputValue = inputValue.slice(0, 8);
    }

    let formattedValue = '';
    if (inputValue.length > 2) {
        formattedValue += inputValue.substr(0, 2) + '/';
        inputValue = inputValue.substr(2);
    }
    
    if (inputValue.length > 2) {
        formattedValue += inputValue.substr(0, 2) + '/';
        inputValue = inputValue.substr(2);
    }

    formattedValue += inputValue;

    date.value = formattedValue;
}
 
</script>


<style>
    #search{
        padding: 9.4px;
    }
</style>