<template>

    <Head title="Definir nova senha"/>

    <AuthLayout>
        <h1 class="text-white">Enviar link de redefinição de senha</h1>

        <form @submit.prevent="sendLink()" action="#" method="POST" class="flex flex-col mt-4">
            <span v-show="form.status !== ''" class="text-green-500">{{form.status}}</span>

            <input-field-text 
                v-model="form.email" 
                label="E-mail" 
                name="email" 
                type="email" 
                :error="errors.email"
                />

            <button-form :loader="form.processing">
                <sppiner-loading v-show="form.processing"/>
                <span v-if="form.processing">Recuperando...</span>
                <span v-else>Recuperar</span>
            </button-form>

            <Link :href="route('login')" class="text-white flex justify-center text-xs mt-2">Voltar</Link>
        </form>
    </AuthLayout>

</template>

<script setup>
    import AuthLayout from '../Auth/layouts/AuthLayout.vue'
    import InputFieldText from '../Auth/components/InputFieldText.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import { Link, Head, router, usePage } from '@inertiajs/vue3';
    import { reactive, computed } from 'vue'
    import { useToast } from "vue-toastification";
    
    defineProps({
        errors: Object
    })
    
    const page = usePage()
    const toast = useToast();
    const status = computed(() => page.props);

    const form = reactive({
        email: null,
        _token: page.props.csrf,
        processing: false
    })

    console.log(status.value.status)

    const sendLink = () => {
        router.post('/forgot-password', form, {
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