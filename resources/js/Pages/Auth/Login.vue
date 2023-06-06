<template>

    <Head title="Login"/>

    <AuthLayout>
        <h1 class="text-white">Login</h1>

        <form action="#" method="POST" class="flex flex-col mt-4">
            <input-field label="E-mail" name="email" type="email"/>
            <input-field label="Senha" name="passoword" type="passoword"/>

            <button-form>
                Salvar
            </button-form>

            <Link :href="route('index')" class="text-white flex justify-center text-xs mt-2">Esqueci minha senha</Link>
        </form>
    </AuthLayout>

</template>

<script setup>
    import AuthLayout from '../Auth/layouts/AuthLayout.vue'
    import InputField from '../Auth/components/InputField.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import { Link, Head } from '@inertiajs/vue3';
</script>