<template>

    <Head title="Registre-se"/>

    <AuthLayout>
        <h1 class="text-white">Realize um cadastro :)</h1>

        <form @submit.prevent="registerUser()" action="#" method="POST" class="flex flex-col mt-4">
            <input-field-text v-model="form.name" label="Nome" name="name" type="text" :error="errors.name"/>
            <input-field-text v-model="form.email" label="E-mail" name="email" type="email" :error="errors.email"/>
            <input-field-text v-model="form.password" label="Senha" name="password" type="password" :error="errors.password"/>
            <label for="birthday" class="block uppercase tracking-wide text-gray-300 text-xs font-light mb-1">Data de Nascimento</label>
            <input
                :class="[
                    errors.birthday ? 'border border-1 border-red-500' : ''
                ]"
                class="bg-transparent appearance-none rounded w-full
                text-gray-400 border-collapse border border-gray-700 
                focus:outline-none py-2 px-3"
                placeholder="Padrão: 00/00/0000"
                @input="handleInput" 
                name="birthday" id="birthday" type="text"
                v-model="form.birthday"
            >
            <span v-if="errors.birthday" class="text-red-500 text-xs">{{errors.birthday}}</span>

            <button-form :loader="form.processing">
                <sppiner-loading v-show="form.processing"/>
                <span v-if="form.processing">Cadastrando...</span>
                <span v-else>Cadastrar</span>
            </button-form>

            <Link :href="route('login')" class="text-white flex justify-center text-xs mt-2">Já possui uma conta? Faça o login</Link>
        </form>
    </AuthLayout>

</template>

<script setup>
    import AuthLayout from '../Auth/layouts/AuthLayout.vue'
    import InputFieldText from '../Auth/components/InputFieldText.vue'
    import ButtonForm from '../Auth/components/ButtonForm.vue'
    import SppinerLoading from '../../components/SppinerLoading.vue'
    import { reactive } from 'vue'
    import { Link, Head, router, usePage } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import { formatDate } from '../../funcoes/formaDate'

    const props = defineProps({
        errors: Object
    })

    const page = usePage()

    const form = reactive({
        name: null,
        email: null,
        password: null,
        birthday: null,
        _token: page.props.csrf,
        processing: false
    })
    
    const toast = useToast();

    const registerUser = () => {
        router.post('/register', form, {
            onStart: () => (form.processing = true), 
            onFinish: () => {
                if (page.props.flash.success) {
                    toast.success(`Sucesso! ${page.props.flash.success} :)`)
                    resetForm()
                }
                form.processing = false
            }
        })
    }

    const resetForm = () => {
        Object.keys(form).forEach((key) => {
            form[key] = null;
        });

        Object.keys(props.errors).forEach((key) => {
            props.errors[key] = '';
        });
    };

    const handleInput = (event) => {
        const input = event.target;
        const formattedValue = formatDate(input.value);
        form.birthday = formattedValue;
    };
</script> 
