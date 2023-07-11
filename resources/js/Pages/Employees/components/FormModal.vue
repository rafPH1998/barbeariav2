

<template>
    <div 
        v-if="modal.create"
        :class="[
            'z-10',
            modal.create ? 'block' : 'hidden'
        ]">
        <div aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto animate__animated animate__fadeIn">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-zinc-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form action="#" method="POST" @submit.prevent="storeEmployee()">
                            <div class="flex flex-wrap -mx-3 mb-6 mt-2 p-8">
                                <h1 class="font-bold uppercase">Cadastrar funcionário na barbeária</h1>
                                <input-profile v-model="form.name" label="Nome" name="name" type="text" :error="errors.name"/>
                                <input-profile v-model="form.email" label="E-mail" name="email" type="email" :error="errors.email"/>
                                <input-profile v-model="form.password" label="Senha" name="password" type="password" :error="errors.password"/>

                               <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-4">
                                    <label for="birthday" class="block uppercase tracking-wide text-gray-300 text-xs font-light mb-1">Data de Aniversário</label>
                                    <input
                                        :class="[
                                            errors.birthday ? 'border border-1 border-red-500' : ''
                                        ]"
                                        class="bg-transparent  appearance-none rounded w-full py-2 px-3 text-gray-400 border-collapse border border-gray-700 focus:outline-none"
                                        placeholder="Padrão: 00/00/0000"
                                        @input="handleInput" 
                                        name="birthday" id="birthday" type="text"
                                        v-model="form.birthday"
                                    >
                                    <span v-if="errors.birthday" class="text-red-600 text-xs">{{errors.birthday}}</span>
                               </div>
                            </div>
                            <hr class="border-slate-700">
                            <div class="bg-zinc-900 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button-form :loader="form.processing">
                                    <sppiner-loading v-show="form.processing"/>
                                    <span v-if="form.processing">Cadastrando...</span>
                                    <span v-else>Cadastrar</span>
                                </button-form>
                                <button-form @click="closeModal()" :typeButton="'cancel'">
                                    Cancelar
                                </button-form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputProfile from '../../Profile/components/InputProfile.vue';
import ButtonForm from '../../Auth/components/ButtonForm.vue'
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import SppinerLoading from '../../../components/SppinerLoading.vue'
import { formatDate } from '../../../funcoes/formaDate';
import { reactive } from 'vue'

export default {
    name: "FormModal",
    components: {
        InputProfile,
        ButtonForm,
        SppinerLoading
    },
    props: {
        modal: {
            type: Object,
        },
        errors: {
            type: Object,
        }
    },

    setup(props, { emit }) {
        const page = usePage()
        const toast = useToast();

        const form = reactive({
            name: null,
            email: null,
            password: null,
            birthday: null,
            _token: page.props.csrf,
            processing: false
        })

        const storeEmployee = () => {
            router.post('/employees', form, {
                onStart: () => (form.processing = true), 
                onFinish: () => {
                    if (page.props.flash.success) {
                        router.get('/employees')
                        toast.success(`Sucesso! ${page.props.flash.success} :)`)
                    }
                    form.processing = false
                }
            })
        }

        const closeModal = () => {
            resetForm();
            emit('closeModal');
        };

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

        return {
            form,
            handleInput,
            closeModal,
            resetForm,
            storeEmployee
        };
    },
};
</script>