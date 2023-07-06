

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
                        <form action="#" method="POST">
                            <div class="flex flex-wrap -mx-3 mb-6 mt-2 p-8">
                                <h1 class="font-bold uppercase">Cadastrar funcionário na barbeária</h1>
                                <input-profile label="Nome" name="name" type="text"/>
                                <input-profile label="E-mail" name="email" type="email"/>
                                <input-profile label="Data de Nascimento" name="text" type="birthday"/>
                                <input-profile label="Senha" name="password" type="password"/>
                            </div>
                            <hr class="border-slate-700">
                            <div class="bg-zinc-900 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button-form>
                                    Cadastrar
                                </button-form>
                                <button-form @click="$emit('closeModal')" :typeButton="'cancel'">
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

<script setup>
    import InputProfile from '../Pages/Profile/components/InputProfile.vue';
    import ButtonForm from '../Pages/Auth/components/ButtonForm.vue'

    const props = defineProps({
        modal: Object
    })

</script>



