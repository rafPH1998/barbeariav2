<template>
    <Main>
        <div id="24h">
            <h1 class="font-bold py-4 uppercase">Dados atualizados do dia 10/06/2023</h1>
            <div id="stats" class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">

                <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <div id="stats-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-indigo-300 text-sm font-medium uppercase leading-4">Total Clientes no sistema</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>{{scheduleTotals.totalUsers === null ? 0 : scheduleTotals.totalUsers}}</span>
                                <icon/>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-black/60 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <div id="stats-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-teal-300 text-sm font-medium uppercase leading-4">Total de entrada do dia</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>${{formattedTotalPrice}}</span>
                                <icon/>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <div id="stats-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-500 text-sm font-medium uppercase leading-4">Total de agenda do dia</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>{{scheduleTotals.total === null ? 0 : scheduleTotals.total}}</span>
                                <icon/>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <CheckPending/>
                        <div>
                            <p class="text-yellow-300 text-sm font-medium uppercase leading-4">Agendas pendentes</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>{{scheduleTotals.pending === null ? 0 : scheduleTotals.pending}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <CheckSuccess/>
                        <div>
                            <p class="text-green-500 text-sm font-medium uppercase leading-4">Agendas finalizadas</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>{{scheduleTotals.finalized === null ? 0 : scheduleTotals.finalized}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-black/60 to-white/5 p-6 rounded-lg">
                    <div class="flex flex-row space-x-4 items-center">
                        <CheckCancel/>
                        <div>
                            <p class="text-red-500 text-sm font-medium uppercase leading-4">Agendas canceladas</p>
                            <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                                <span>{{scheduleTotals.canceled === null ? 0 : scheduleTotals.canceled}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row-reverse">
            <button-form :typeButton="'cancel'" @click.prevent="downloadCsv()">
  
                <span class="flex items-center">Baixar informações
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </span>
            </button-form>
        </div>
    </Main>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import Icon from '../../components/Icon.vue'
import CheckSuccess from '../Auth/components/icons/CheckSuccess.vue';
import CheckCancel from '../Auth/components/icons/CheckCancel.vue';
import CheckPending from '../Auth/components/icons/CheckPending.vue';
import ButtonForm from '../../Pages/Auth/components/ButtonForm.vue'
import { computed } from 'vue';

const props = defineProps({scheduleTotals: Object})

const formattedTotalPrice = computed(() => {
    if (props.scheduleTotals.totalPrice === null || props.scheduleTotals.totalPrice === undefined) {
        return "0.00";
    } else {
        const totalPriceNumber = Number(props.scheduleTotals.totalPrice);
        return totalPriceNumber.toFixed(2);
    }
});

const downloadCsv = () => {
    router.post('/dashboard-download')
}

</script>