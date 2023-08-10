<template>
    <div>
        <Main>
            <h1 class="font-bold py-4 uppercase ml-4">Listagem de serviços</h1>

            <ModalDelete 
                :modal="modal" 
                @closeModal="modal.show = false" 
                :type="'serviço'"
                @delete="deleteService(modal.serviceId)"
            />

            <div class="mt-6">
                <div class="mt-6 h-96 overflow-y-auto">
                    <table class="w-full whitespace-nowrap text-white text-xs">
                        <thead class="bg-black/60">
                            <tr class="text-center">
                                <th class="py-3 px-2">ID</th>
                                <th class="py-3 px-2">NOME DO PLANO</th>
                                <th class="py-3 px-2">TEMPO DO SERVIÇO</th>
                                <th class="py-3 px-2">PREÇO DO SERVIÇO</th>
                                <th class="py-3 px-2">AÇÕES</th>
                            </tr>                          
                        </thead>
                        <tbody v-for="services in servicesSchedules" :key="services.id">
                            <tr class="border-b border-gray-700 text-center hover:bg-white/10">
                                <td class="py-3 px-2">{{ services.id }}</td>
                                <td class="py-3 px-2">{{ services.name_plan }}</td>
                                <td class="py-3 px-2">{{ services.time_plan }}min</td>
                                <td class="py-3 px-2">R$ {{  services.price_plan }}</td>
                                <td class="py-3 px-2">
                                    <IconTrash @click.prevent="openModal(services.id)"/>
                                </td>
                            </tr> 
                        </tbody>                       
                    </table>
                </div>
            </div>

        </Main>
    </div>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import IconTrash from '../Layouts/components/icons/IconTrash.vue'
import ModalDelete from '../../components/ModalDelete.vue';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
    servicesSchedules: Object
})

const modal = ref({
    show  : false,
    userId: null,
});

const openModal = (serviceId) => {
    modal.value.show = true;
    modal.value.serviceId = serviceId;
};

const deleteService = (id) => {
    router.delete(`/services/${id}`)
    modal.value.show = false
}

</script>

