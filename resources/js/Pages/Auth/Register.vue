<template>

    <Head title="Registre-se"/>

    <AuthLayout>
        <h1 class="text-white">Realize um cadastro :)</h1>

        <form @submit.prevent="registerUser()" action="#" method="POST" class="flex flex-col mt-4">
            <input-field v-model="form.name" label="Nome" name="name" type="text" :error="errors.name"/>
            <input-field v-model="form.email" label="E-mail" name="email" type="email" :error="errors.email"/>
            <input-field v-model="form.password" label="Senha" name="password" type="password" :error="errors.password"/>

            <button-form>
                <sppiner-loading v-show="form.processing"/>
                <span v-if="form.processin">Cadastrando...</span>
                <span v-else>Cadastrar</span>
            </button-form>

            <Link :href="route('login')" class="text-white flex justify-center text-xs mt-2">Já possui uma conta? Faça o login</Link>
        </form>
    </AuthLayout>

</template>

<script setup>
    import AuthLayout from '../Auth/layouts/AuthLayout.vue'
    import InputField from '../Auth/components/InputField.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import { reactive } from 'vue'
    import { Link, Head, router, usePage } from '@inertiajs/vue3';

    import { useToast } from "vue-toastification";

    defineProps({
        errors: Object
    })

    const form = reactive({
        name: null,
        email: null,
        password: null,
        processing: false
    })
    
    const page = usePage()
    const toast = useToast();

    const registerUser = () => {
        router.post('/register', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                if (page.props.flash.success) {
                    router.get('/login')
                    toast.success(`Sucesso! ${page.props.flash.success} :)`)
                }
                form.processing = false
            }
        })
    }
</script> 
