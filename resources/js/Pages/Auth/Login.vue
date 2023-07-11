<template>

    <Head title="Login"/>

    <AuthLayout>
        <h1 class="text-white">Login</h1>

        <form @submit.prevent="login()" action="#" method="POST" class="flex flex-col mt-4">
            <input-field-text 
                v-model="form.email" 
                label="E-mail" 
                name="email" 
                type="email" 
                :error="errors.email"
                />
            <input-field-text  
                v-model="form.password" 
                label="Senha" 
                name="password" 
                type="password" 
                :error="errors.password"
                />

            <button-form :loader="form.processing">
                <sppiner-loading v-show="form.processing"/>
                <span v-if="form.processing">Logando...</span>
                <span v-else>Entrar</span>
            </button-form>

            <Link :href="route('index')" class="text-white flex justify-center text-xs mt-2">Esqueci minha senha</Link>
        </form>
    </AuthLayout>

</template>

<script setup>
    import AuthLayout from '../Auth/layouts/AuthLayout.vue'
    import InputFieldText from '../Auth/components/InputFieldText.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import { Link, Head, router, usePage } from '@inertiajs/vue3';
    import { reactive } from 'vue'
    import { useToast } from "vue-toastification";
    
    defineProps({
        errors: Object
    })

    const form = reactive({
        email: null,
        password: null,
        processing: false
    })
    
    const page = usePage()
    const toast = useToast();

    const login = () => {
        router.post('/login', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                if (page.props.flash.error) {
                    router.get('/login')
                    toast.error(`Erro! ${page.props.flash.error} :)`)
                }
                form.processing = false
            }
        })
    }
</script>