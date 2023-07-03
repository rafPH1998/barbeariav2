<template>
    <div 
        v-for="user in users" :key="user.id"
        class="w-44 p-2 mt-4 ml-4 border-collapse border 
        border-gray-700 rounded shadow flex justify-center 
        cursor-pointer animate__animated animate__fadeIn">
        <div>
            <div class="flex justify-center">
                <img class="h-10 w-10 rounded-full object-cover" src="/assets/images/user.svg">
            </div>
            <div class="mt-3 flex justify-center">
                <p class="text-xs font-bold">{{user.name}}</p>
            </div>
            <div class="flex mt-5">
                <p class="text-xs font-bold">Cliente desde:</p>
                <p class="text-xs ml-2 text-green-600">{{user.created_at}}</p>
            </div>
            <div class="flex">
                <p class="text-xs font-bold">Qt de cortes:</p>
                <p class="text-xs ml-2">{{user.agenda_count}}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps({users: Object})
</script>


<style>
    .w-44:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.8);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>