<template>
    <div>
        <Main>
            <p class="text-white">criar uma agenda para <b class="text-red-400">{{service}}</b></p>

            <div class="border-collapse border border-gray-700 p-6 mt-6 rounded-lg">
                <form action="#" method="POST" class="flex flex-col mt-4">

                    <label for="date">Selecione uma data:</label>
                    <input
                        class="bg-white/10 shadow-lg 
                        appearance-none rounded w-full py-2 px-3 text-white 
                        leading-tight focus:outline-none focus:shadow-outline"
                        type="date" id="date" 
                        @change="getDates()"
                        v-model="form.date" :min="minDate"
                        placeholder="DD/MM/YYYY"
                        >
                    <span v-if="errors.date" class="text-red-600 text-xs">{{errors.date}}</span>

                    <div 
                        class="p-2 w-full mt-6">

                        <input type="hidden" id="hour" v-model="form.hour">
                        
                        <div v-if="messageError">
                            <p class="text-red-600">{{ messageError }} <p class="text-white">Que tal agendar para outra data? =)</p></p>
                        </div>
                        <div v-else>
                            <p v-show="form.date" class="text-xs">Selecione um horário</p>
                            <button 
                                v-if="form.date"
                                v-for="(buttonsHours, chave) in page.props.flash.dates"
                                :key="chave"
                                :class="[
                                    form.hour === buttonsHours ? 'bg-indigo-700 text-white' : ''
                                ]"
                                @click.prevent="chooseDate(buttonsHours)"
                                class="hover:bg-indigo-600 mt-2
                                text-white-700 font-semibold cursor-pointer mr-2
                                hover:text-white p-2 border border-indigo-500 
                                hover:border-transparent rounded text-xs">
                                {{buttonsHours}}
                            </button>
                        </div>

                    </div>
                    <span v-if="errors.hour" class="text-red-600 text-xs ml-2">{{errors.hour}}</span>


                    <button-form @click.prevent="storeSchedule()" :loader="form.processing">
                        <sppiner-loading v-show="form.processing"/>
                        <span v-if="form.processing">Agendando...</span>
                        <span v-else>Agendar</span>
                    </button-form>

                    <Link :href="route('schedules.typeForm')" 
                        class="mt-4 text-xs
                        text-red-700
                        text-center">
                        Voltar
                    </Link>
                </form>
            </div>
        </Main>
    </div>
</template>


<script setup>
    import Main from '../Layouts/Main.vue';
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import { Link, router, usePage } from '@inertiajs/vue3';
    import { reactive, ref, onMounted, computed } from 'vue'
    import { useToast } from "vue-toastification";
    
    defineProps({
        service: String,
        errors: Object
    })

    const toast = useToast();
    const page = usePage()
    const messageError = computed(() => page.props.flash.error)
    const minDate = ref(null)

    const form = reactive({
        date       : null,
        hour       : null,
        processing : false,
        type       : page.props.service
    })
    const getDates = () => router.post('/schedules', form)
    const chooseDate = (hourSelected) => form.hour = hourSelected

    const storeSchedule = () => {

        router.post('/schedules', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                if (page.props.flash.success) {
                    router.get('/dashboard')
                    toast.success(`Sucesso! ${page.props.flash.success} :)`)
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