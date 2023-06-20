<template>
    <Main>
        <div>
            <form action="#" 
                method="POST" 
                @submit.prevent="submitForm()"
                class="border-collapse border border-gray-700
                rounded px-8 pt-6 pb-8 mb-8 m-8"
                enctype="multipart/form-data">

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex items-center">
                    <img class="h-32 w-32 rounded-full" src="/assets/images/user.svg">
                </div>

                <div class="relative">
                    <Input  
                        v-model="form.image"
                        label="Foto" 
                        name="image" 
                        type="file" 
                        @input="form.image = $event.target.files[0]" 
                    />
                </div>

                <div class="flex flex-wrap -mx-3 mb-6 mt-2">
                    <Input  
                        v-model="form.name"
                        label="Nome" 
                        name="name" 
                        type="text" 
                        :error="errors.name"
                    />
                
                    <Input  
                    v-model="form.email"
                        label="E-mail" 
                        name="email" 
                        type="email" 
                        :error="errors.email"
                    />

                    <Input  
                        v-model="form.password"
                        label="Senha" 
                        name="password" 
                        type="password" 
                        :error="errors.password"
                    />

                    <Input  
                        v-model="form.password_confirmation"
                        label="Confirme senha" 
                        name="password_confirmation" 
                        type="password" 
                        :error="errors.password_confirmation"
                    />
                </div>

                <button-form :loader="form.processing">
                    <sppiner-loading v-show="form.processing"/>
                    <span v-if="form.processing">Salvando...</span>
                    <span v-else>Salvar</span>
                </button-form>
            </form>
        </div>
    </Main>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import { usePage, router } from '@inertiajs/vue3'
import Input from './components/Input.vue';
import ButtonForm from '../Auth/components/ButtonForm.vue';
import SppinerLoading from '../../components/SppinerLoading.vue';
import { useToast } from "vue-toastification";
import { reactive } from 'vue'

const props = defineProps({
    user: Object,
    errors: Object
})

const page = usePage()
const toast = useToast();

const form = reactive({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
    password_confirmation: null,
    image: null,
    processing: false
})

const submitForm = () => {
    router.put(`/profile/${form.id}`, form, {
        onStart: () => (form.processing = true), 
        onFinish: () => {
            
            if (page.props.flash.error) {
                router.get('/profile')
                toast.error(`Erro! ${page.props.flash.error} :(`)
            }

            if (page.props.flash.success) {
                router.get('/profile')
                toast.success(`Sucesso! ${page.props.flash.success} :)`)
            }
            form.processing = false
        }
    })
}

</script>