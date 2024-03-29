<template>
    <div>
        <Main>
            <p class="text-white">criar uma agenda para <b class="text-red-400">{{service}}</b></p>

            <div v-show="schedules" class="mt-6">
                <span class="text-red-600 text-xs piscar">Você já tem um agendamento pendente!</span>
            </div>

            <div class="border-collapse border border-gray-700 p-6 mt-6 rounded-lg">
                <form action="#" method="POST" class="flex flex-col mt-4" @submit.prevent="storeSchedule()">

                    <label for="date">Selecione uma data:</label>
                    <input
                        class="bg-white/10 shadow-lg 
                        appearance-none rounded w-full py-2 px-3 text-white 
                        leading-tight focus:outline-none focus:shadow-outline"
                        type="date" id="date"
                        @change="getDates()"
                        v-model="form.date" 
                        :min="minDate"
                        :disabled="schedules"
                        placeholder="DD/MM/YYYY"
                        >
                    <span v-if="errors.date" class="text-red-600 text-xs">{{errors.date}}</span>

                    <div>
                        <div class="flex text-xs">
                            <p>Data selecionada:</p><span class="text-indigo-500 ml-1">{{ selectedDate }}</span>
                        </div>
                        <div v-show="selectedHour" class="flex">
                            <p class="text-xs">Hora selecionada:</p>
                            <a 
                                class="bg-indigo-600 px-1 ml-1
                                text-white-700 font-semibold cursor-pointer
                                border border-indigo-500 rounded text-xs">
                                {{selectedHour}}
                            </a>
                        </div>
                    </div>

                    <div 
                        v-if="!form.processingDates"
                        class="p-2 w-full mt-6">
                        <input type="hidden" id="hour" v-model="form.hour">
                        
                        <div v-show="messageError">
                            <p class="text-red-600">{{ messageError }} <p class="text-white">Que tal agendar para outra data? =)</p></p>
                        </div>

                        <div v-if="selectedHour">
                            <h1 class="flex justify-center">Selecione um barbeiro</h1>
                            <CardBarber :barbers="barbers" @barberSelected="getBarberSelected"/>
                        </div>
                        <div v-else>
                            <p v-show="form.date" class="text-xs">Selecione um horário</p>
                            <button 
                                v-for="(buttonsHours, chave) in page.props.flash.success"
                                :key="chave"
                                :class="[
                                    form.hour === buttonsHours ? 'bg-indigo-700 text-white' : ''
                                ]"
                                @click.prevent="chooseTime(buttonsHours)"
                                class="hover:bg-indigo-600 mt-2
                                text-white-700 font-semibold cursor-pointer mr-2
                                hover:text-white p-2 border border-indigo-500 
                                hover:border-transparent rounded text-xs">
                                {{buttonsHours}}
                            </button>
                        </div>
                    </div>
                    <div v-else class="p-2 w-full mt-6 flex items-center justify-center">
                        <SppinerLoading/>
                        <p class="text-xs ml-1">Carregando datas...</p>
                    </div>

                    <span v-if="errors.hour" class="text-red-600 text-xs ml-2">{{errors.hour}}</span>
                    <button-form 
                        :loader="shouldShowLoader">
                        <sppiner-loading v-show="form.processing"/>
                        <span v-if="form.processing">Agendando...</span>
                        <span v-else>Agendar</span>
                    </button-form>

                    <Link :href="route('schedules.typeForm')" class="mt-4 text-xs text-red-700 text-center">Voltar</Link>
                </form>
            </div>
        </Main>
    </div>
</template>

<script setup>
    import Main from '../Layouts/Main.vue';
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import CardBarber from './components/CardBarber.vue';
    import { Link, router, usePage } from '@inertiajs/vue3';
    import { reactive, ref, onMounted, computed } from 'vue'
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';

    const props = defineProps({
        service: String,
        pricePlan: String,
        schedules: Boolean,
        dateSelected: Array,
        errors: Object
    })

    const toast = useToast();
    const page = usePage()
    const store = useStore();
    const minDate = ref(null)

    const form = reactive({
        date: null,
        hour: null,
        barber: null,
        pricePlan: props.pricePlan,
        _token: page.props.csrf,
        processing: false,
        processingDates: false,
        type: page.props.service
    })

    const messageError = computed(() => page.props.flash.error)
    const selectedDate = computed(() => store.state.selectedDate)
    const selectedHour = computed(() => store.state.selectedHour)
    const barbers      = computed(() => page.props.flash.barbers)

    const shouldShowLoader = computed(() => {
        return form.processing || props.schedules || !selectedDate.value || !form.barber
    })

    const getDates = () => {
        router.get('/schedules/get-dates', form, {
            onStart: () => (form.processingDates = true),
            onFinish: () => {
                form.processingDates = false
                store.dispatch('setSelectedDate', form.date)
            }
        })
    }

    const chooseTime = (timeSelected) => {
        form.date = selectedDate
        form.hour = timeSelected

        router.get('/schedules/get-barbers', form, {
            onStart: () => (form.processingDates = true),
            onFinish: () => {
                form.processingDates = false
                store.dispatch('setSelectedDate', form.date)
                store.dispatch('setSelectedHour', form.hour)
            }
        })
    }

    //reseta do vuex data selecionada
    store.dispatch('setSelectedDate', '')
    store.dispatch('setSelectedHour', '')

    const getBarberSelected = (barberId) => form.barber = barberId

    const storeSchedule = () => {
        form.date = selectedDate
        form.hour = selectedHour

        router.post('/schedules', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                if (page.props.flash.success) {
                    toast.success(`Sucesso! ${page.props.flash.success} :)`)
                    router.get('/schedules/my-schedules')
                }
                form.processing = false
            }
        })
    }

    onMounted(() => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        const day = currentDate.getDate().toString().padStart(2, '0');
        minDate.value = `${year}-${month}-${day}`;
    })
</script>

<style>
.piscar {
    animation: piscar 1.5s infinite;
}

@keyframes piscar {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>