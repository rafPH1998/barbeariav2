<template>
     <div>
        <Main>
            <div class="animate__animated animate__fadeIn">
                <form action="#" method="POST" @submit.prevent="storePlan()">
                    <div class="-mx-3 mb-6 mt-2 p-8">
                        <h1 class="font-bold uppercase">Cadastrar serviço</h1>
                        <div class="border-collapse border border-gray-700 mt-4 rounded p-8 flex">
                            <input-profile 
                                v-model="form.name_plan" 
                                label="Nome do plano" 
                                name="name_plan" 
                                type="text" 
                                :error="errors.name_plan"
                                />
                            <input-profile 
                                v-model="form.time_plan" 
                                label="Tempo de serviço (minutos ou hora)" 
                                name="time_plan" 
                                type="text" 
                                :error="errors.time_plan" 
                                placeholder="(Apenas números)"
                                />
                            <input-profile 
                                v-model="form.price_plan" 
                                label="Preço do serviço" 
                                name="price_plan" 
                                type="text" 
                                :error="errors.price_plan"
                                />
                        </div>
                        <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button-form :loader="form.processing">
                                <span v-if="form.processing">Cadastrando...</span>
                                <span v-else>Cadastrar</span>
                            </button-form>
                        </div>
                    </div>
                </form>
            </div>
        </Main>
    </div>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import ButtonForm from '../Auth/components/ButtonForm.vue';
import InputProfile from '../Profile/components/InputProfile.vue';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import { reactive } from 'vue'

defineProps({
    errors: Object
})

const toast = useToast();

const form = reactive({
    name_plan: null,
    time_plan: null,
    price_plan: null,
    processing: false
})

const storePlan = () => {
    router.post('/services/create', form, {
        onStart: () => (form.processing = true),
        onFinish: () => {
            form.processing = false
            const msgSuccess = usePage().props.flash.success
            
            if (msgSuccess) {
                toast.success(`Sucesso! ${msgSuccess} :)`)
                router.get('/services')
            }

        }
        
    })
}
</script>