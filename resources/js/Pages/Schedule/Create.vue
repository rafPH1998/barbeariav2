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
                        v-model="form.date" :min="form.minDate"
                        placeholder="DD/MM/YYYY"
                        >

                    <div 
                        v-if="form.date"
                        class="p-2 w-full mt-2">
                        <input type="button" id="botaoHora" value="8:00"
                            class="bg-transparent hover:bg-indigo-600 mt-2
                            text-white-700 font-semibold cursor-pointer
                            hover:text-white p-2 border border-indigo-500 
                            hover:border-transparent rounded text-xs">
                    </div>

                    <button-form>
                        <span>Agendar</span>
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
    import { Link } from '@inertiajs/vue3';
    import { reactive, onMounted } from 'vue'

    defineProps({
        service: String
    })

    const form = reactive({
        date: null,
        minDate: null
    })

    onMounted(() => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        const day = currentDate.getDate().toString().padStart(2, '0');
        form.minDate = `${year}-${month}-${day}`;
    })
</script>