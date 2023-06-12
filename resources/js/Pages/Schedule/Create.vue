<template>
    <div>
        <Main>
            <p class="text-white">criar uma agenda para <b class="text-red-400">{{service}}</b></p>

            <div class="border-collapse border border-gray-700 p-6 mt-6 rounded-lg">
                <form action="#" method="POST" class="flex flex-col mt-4">
                    <input-field 
                        label="Selecione a data" 
                        name="date" 
                        type="date" 
                        placeholder="DD/MM/YYYY"
                        />

                    <div class="p-2 w-full mt-2" id="horasDisponiveis">
                        <input type="button" id="botaoHora" value="8:00"
                            class="bg-transparent hover:bg-indigo-500 mt-2
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
    import InputField from '../Auth/components/InputField.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import { Link } from '@inertiajs/vue3';

    defineProps({
        service: String
    })
</script>