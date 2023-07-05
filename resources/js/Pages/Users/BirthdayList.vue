<template>
    <div>
        <Main>
            <h1 class="font-bold py-4 uppercase ml-4 flex">Listagem de aniversariantes do mês
                <div class="ml-2">
                    <IconBirthday/>
                </div>
            </h1>

            <div class="flex flex-wrap mt-4" v-if="users.length > 0">
                <CardUsers :users="users"/>
            </div>
            <div 
                v-else
                class="border-collapse border border-gray-700 p-10 rounded-lg flex mt-10">
                <p class="text-white">Nenhum cliente aniveráriante hoje</p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                </svg>
            </div>
        </Main>
    </div>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import CardUsers from './components/CardUsers.vue';
import IconBirthday from '../Layouts/components/icons/IconBirthday.vue'

defineProps({users: Object})

</script>