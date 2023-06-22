<template>
    <div>
        <Main>
            <div id="last-users mt-10">
                <h1 class="font-bold py-4 uppercase">Tabela de agendamentos</h1>
                <div class="mt-6">
                    <table class="w-full whitespace-nowrap text-white text-xs">
                        <thead class="bg-black/60">
                            <tr class="text-center">
                                <th class="py-3 px-2 rounded-l-lg">Foto</th>
                                <th class="py-3 px-2">Nome</th>
                                <th class="py-3 px-2">Email</th>
                                <th class="py-3 px-2">Serviço</th>
                                <th class="py-3 px-2">Status</th>
                                <th class="py-3 px-2">Dia do agendamento</th>
                                <th class="py-3 px-2">Início</th>
                                <th class="py-3 px-2">Término</th>
                                <th class="py-3 px-2 rounded-r-lg">Ação</th>
                            </tr>                          
                        </thead>
                        <tbody v-for="schedule in schedules.data" :key="schedule.id">
                            <tr class="border-b border-gray-700 text-center">
                                <td class="py-3 px-2 flex justify-center">
                                    <img class="h-8 w-8 rounded-full" 
                                        :src="[
                                            schedule.user.image ? '/storage/' + schedule.user.image : '/assets/images/user.svg'
                                        ]"
                                    >
                                </td>
                                <td class="py-3 px-2">{{schedule.user.name}}</td>
                                <td class="py-3 px-2">{{schedule.user.email}}</td>
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
                                <td class="py-3 px-2">{{schedule.date}}</td>
                                <td class="py-3 px-2">{{schedule.hour}}</td>
                                <td class="py-3 px-2">{{schedule.end_service}}</td>
                                <td class="py-3 px-2">
                                    <a 
                                        @click.prevent="openModal()"
                                        v-if="schedule.status === 'pendente'"
                                        type="button"
                                        class="bg-red-600 hover:bg-red-700
                                        font-bold rounded-full text-center w-full
                                        text-white text-xs cursor-pointer">
                                        Cancelar
                                    </a>
                                </td>
                            </tr> 
                        </tbody>                       
                    </table>
                </div>
            </div>
            <div class="flex flex-row-reverse mt-5">
                <Pagination :data="schedules"/>
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

 const props = defineProps({
     schedules: Object
 })
 
</script>
