<template>
    <Main>
        <div class="animate__animated animate__fadeIn">
            <form action="#" 
                method="POST" 
                @submit.prevent="submitForm()"
                class="border-collapse border border-gray-700
                rounded px-8 pt-6 pb-8 mb-8 m-8"
                >
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex items-center">
                    <img
                        class="h-32 w-32 rounded-full"
                        :src="[form.previewImage || (props.user.image ? '/storage/' + props.user.image : '/assets/images/user.svg')]"
                    >
                </div>
                    
                <div class="relative">
                    <label for="image" class="block uppercase tracking-wide text-gray-300 text-xs font-light mb-1">Foto</label>
                    <input type="file" 
                        @input="handleImageUpload($event)"
                        class="bg-transparent appearance-none rounded w-full
                        py-2 px-3 text-gray-400 border-collapse border border-gray-700 
                        focus:outline-none">
                    <span class="text-red-600 text-xs" v-if="errors.image">{{errors.image}}</span>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6 mt-2">
                    <input-profile
                        v-model="form.name"
                        label="Nome" 
                        name="name" 
                        type="text" 
                        :error="errors.name"
                    />
                
                    <input-profile  
                    v-model="form.email"
                        label="E-mail" 
                        name="email" 
                        id="email"
                        type="email" 
                        :error="errors.email"
                    />

                    <input-profile  
                        v-model="form.password"
                        label="Senha" 
                        name="password" 
                        type="password" 
                        :error="errors.password"
                    />

                    <input-profile  
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
import InputProfile from './components/InputProfile.vue';
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
    progress: 0,
    previewImage: null,
    processing: false
})

const submitForm = () => {
    
    router.post(`/profile`, form, {
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

const handleImageUpload = (event) => {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            form.previewImage = reader.result;
        };
        reader.readAsDataURL(file);
        form.image = file;
    }
}


</script>