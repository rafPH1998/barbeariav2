<template>

    <Head title="Definir nova senha"/>

    <AuthLayout>
        <h1 class="text-white">Definir nova senha</h1>

        <form @submit.prevent="resetPassword()" action="#" method="POST" class="flex flex-col mt-4">

            <div v-if="msgStatus.error">
                <span class="text-red-500">{{msgStatus.error}}</span>
            </div>
            <div v-else-if="msgStatus.status" class="pb-4">
                <p class="text-green-500 text-xs">Senha atualizada com sucesso!</p>
                <Link :href="route('login')" class="text-white text-xs mt-2 no-underline hover:underline">Voltar para login</Link>
            </div>

            <input-field-text 
                v-model="form.email" 
                label="E-mail" 
                name="email" 
                type="email" 
                :error="errors.email"
                />
            <input-field-text 
                v-model="form.password" 
                label="Digíte sua nova senha" 
                name="password" 
                type="password" 
                :error="errors.password"
                />

            <button-form :loader="form.processing">
                <sppiner-loading v-show="form.processing"/>
                <span v-if="form.processing">Alterando...</span>
                <span v-else>Trocar senha</span>
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

    const props =defineProps({
        errors: Object,
        token: String
    })
    
    const page = usePage()
    const msgStatus = computed(() => page.props.flash);

    const form = reactive({
        email: null,
        password: null,
        token: props.token,
        _tokenCsrf: page.props.csrf,
        processing: false
    })

    const resetPassword = () => {
        router.post('/reset-password', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                form.processing = false
            }
        })
    }

</script>