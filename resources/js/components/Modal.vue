<template>
       <div 
            v-if="modal"
            :class="[
                modal ? 'block' : 'hidden'
            ]"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-800 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto animate__animated animate__fadeIn">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-zinc-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600 stroke-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-bold leading-6 text-white" id="modal-title">Cancelar agenda</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-white">
                                            Tem certeza que deseja deletar sua agenda ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2 border-red-500">
                            <form @submit.prevent="cancelSchedule()" action="#"  method="POST">
                                <div class="flex flex-col mt-4"> 
                                    <label for="description" class="block text-gray-400 text-sm">Motivo do Cancelamento*:</label>
                                    <textarea rows="3"
                                        @input="checkDescriptionLength()"
                                        v-model="description" 
                                        :class="[errors.description ? 'border border-1 border-red-500' : '']"
                                        class="block p-2.5 w-full text-sm text-white
                                        bg-white/10 rounded-lg resize-none outline-none"
                                        placeholder="Escreva..."></textarea>
                                    
                                </div>
                                <p v-if="errors.description" class="text-xs text-red-500">{{ errors.description }}</p>

                                <div class="flex flex-row-reverse text-gray-400 text-xs">
                                    <p class="">Total: {{countCaracteres}} (min 4 e max 100)</p>
                                </div>
                                <div class="flex flex-row-reverse mt-10">
                                    <button type="submit"
                                        :disabled="processing"
                                        class="inline-flex w-full justify-center rounded-md bg-green-600
                                        px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 
                                        sm:ml-3 sm:w-auto">
                                        <sppiner-loading v-show="processing"/>
                                        <span v-if="processing">Cancelando...</span>
                                        <span v-else>Cancelar</span>
                                    </button>
            
                                    <button type="submit" 
                                        @click="$emit('closeModal', clearForm)"
                                        class="inline-flex w-full justify-center rounded-md bg-red-600
                                        px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 
                                        sm:ml-3 sm:w-auto">Voltar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import { router, usePage } from '@inertiajs/vue3';
    import SppinerLoading from './SppinerLoading.vue';
    import { useToast } from "vue-toastification";

    const props = defineProps({
        idSchedule: Number,
        modal: Object,
        errors: Object
    })

    const page = usePage()
    const toast = useToast();
    const description = ref('');
    const processing = ref(false);
    const qtMaxCharacters = ref(100);

    const checkDescriptionLength = () => {
        if (description.value.length > qtMaxCharacters.value) {
            description.value = description.value.slice(0, qtMaxCharacters.value);
        }
    }

    const countCaracteres = computed(() => description.value.length)

    const cancelSchedule = () => {
        router.post('/schedules/canceleds', 
            {
                description: description.value,
                id: props.idSchedule
            }, 
            {
            onStart: () => (processing.value = true), 
            onFinish: () => {
                if (page.props.flash.success) {
                    router.get('/schedules/my-schedules')
                    toast.success(`Boa! ${page.props.flash.success} :)`)
                }
                processing.value = false
                $emit('closeModal')
            }
        })
    }

    const clearForm = computed(() =>  {
        description.value = ''
        props.errors.description = ''
        return;
    })
    
</script>
