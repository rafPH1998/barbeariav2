<template>
    <Main>
        <div class="animate__animated animate__fadeIn"> 
            <h1 class="font-bold py-4 uppercase">Tabela de funcionários</h1>

            <button-form @click="createEmployee()">
                Cadastrar funcionário
            </button-form>

            <ModalDelete :modal="modal" @closeModal="modal.show = false" @deleteUser="deleteUser(modal.userId)" />

            <!-- modal para cadastrar um funcionario -->
            <FormModal :modal="modal" @closeModal="modal.create = false"/>

            <table class="w-full whitespace-nowrap text-white text-xs mt-10">
                <thead class="bg-black/60">
                    <tr class="text-center">
                        <th class="py-3 px-2 rounded-l-lg">#</th>
                        <th class="py-3 px-2">Foto</th>
                        <th class="py-3 px-2">Nome</th>
                        <th class="py-3 px-2">Tipo</th>
                        <th class="py-3 px-2">E-mail</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">R$ lucrados no dia</th>
                        <th class="py-3 px-2">Data de cadastro</th>
                        <th class="py-3 px-2">Ações</th>
                    </tr>                          
                </thead>
                <tbody v-for="employee in employees" :key="employee.id">
                    <tr 
                        :class="{'bg-white/10' : employee.status === 0}"
                        class="border-b border-gray-700 text-center">
                        <td class="py-3 px-2">{{employee.id}}</td>
                        <td 
                            class="px-2 flex justify-center mt-1">
                            <img class="h-8 w-8 rounded-full" 
                                :src="[
                                    employee.image ? '/storage/' + employee.image : '/assets/images/user.svg'
                                ]"
                            >
                        </td>
                        <td class="py-3 px-2">{{employee.name}}</td>
                        <td :class="{'text-green-500': employee.type == 'manager'}" 
                            class="py-3 px-2">{{employee.type == 'manager' ? "Gerente" : "Funcionário"}}
                        </td>
                        <td class="py-3 px-2">{{employee.email}}</td>
                        <td class="p-3 px-5">
                            <select class="bg-white/10 rounded p-1" 
                                    :disabled="loading"
                                    v-model="employee.status"
                                    @change="updatedStatus(employee.status, employee.id)"
                                >
                                <option :value="1" class="text-black">Ativo</option>
                                <option :value="0" class="text-black">Inativo</option>
                            </select>
                        </td>                        
                        <td class="py-3 px-2 font-bold">R$ 23</td>                          
                        <td class="py-3 px-2">{{employee.created_at}}</td>   
                        <td class="py-3 px-2" v-if="employee.type !== 'manager'">
                            <IconTrash @click.prevent="openModal(employee.id)"/>
                        </td>                   
                    </tr> 
                </tbody>                       
            </table>
        </div>
    </Main>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import ButtonForm from '../../Pages/Auth/components/ButtonForm.vue'
import IconTrash from '../Layouts/components/icons/IconTrash.vue'
import ModalDelete from  '../../components/ModalDelete.vue'
import FormModal from  '../../components/FormModal.vue'
import { useToast } from "vue-toastification";
import { router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({employees: Object})

const toast = useToast();

const modal = ref({
    show  : false,
    create: false,
    userId: null,
});

const loading = ref(false)
const msgSuccess = computed(() => usePage().props.flash.success);

const openModal = (userId) => {
    modal.value.show = true;
    modal.value.userId = userId;
};

const createEmployee = () => modal.value.create = true

const deleteUser = (id) => {
    router.delete(`/employees/${id}`, {
        onFinish: () => {
            if (msgSuccess) {
                toast.success(`Sucesso! ${msgSuccess.value} :)`)
            }
        }
    })
    modal.value.show = false
}

const updatedStatus = (status, id) => {
    router.put(`/employees/${id}`, {
        status: status, 
        userId: id
    }, {
        onStart: () => (loading.value = true), 
        onFinish: () => (loading.value = false)
    });
}

</script>
