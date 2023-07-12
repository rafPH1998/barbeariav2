<template>
    <div 
        v-for="user in users" :key="user.id"
        class="w-44 p-2 mt-4 ml-4 border-collapse border 
        border-gray-700 rounded shadow flex justify-center 
        cursor-pointer animate__animated animate__fadeIn">
        <div>
            <div class="flex justify-center">
                <img class="h-10 w-10 rounded-full object-cover" 
                :src="[
                    user.image ? '/storage/' + user.image : '/assets/images/user.svg'
                ]">
            </div>
            <div class="mt-3 flex justify-center">
                <p class="text-xs font-bold">{{user.name}}</p>
            </div>
            <div class="flex mt-5">
                <p class="text-xs font-bold">Cliente desde:</p>
                <p class="text-xs ml-2 text-zinc-500">{{user.created_at}}</p>
            </div>

            <div class="flex mt-5 items-center">
                <p class="text-xs font-bold">Status:</p>

                <div v-if="props.status === 'inactive'">
                    <div class="ml-2 inline-flex items-center px-3 py-1 text-red-500 rounded-full gap-x-2 bg-red-100/60 dark:bg-gray-800">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 3L3 9M3 3L9 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <h2 class="text-xs font-normal">Inativos</h2>
                    </div>
                </div>
                <div v-else>
                    <div class="ml-2 inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60 dark:bg-gray-800">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <h2 class="text-xs font-normal">Ativos</h2>
                    </div>
                </div>
            </div>

            <div class="flex mt-5">
                <p class="text-xs font-bold">Aniversário:</p>
                <p class="text-xs ml-2 text-zinc-500">{{user.birthday}}</p>
            </div>
            <div class="flex">
                <p class="text-xs font-bold">Total de cortes:</p>
                <p class="text-xs ml-2 text-zinc-500">{{user.agenda_count}}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        users: Object,
        status: String
    })
</script>


<style>
    .effect:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.9);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>