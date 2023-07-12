<template>
    <div 
        v-for="barber in barbers" :key="barber.id"
        :class="{'border-indigo-700' : barber.id === barberSelected }"
        class="w-44 p-2 mt-4 ml-4 border-collapse border 
        border-gray-700 rounded shadow flex justify-center 
        cursor-pointer animate__animated animate__fadeIn" @click="selectBarber(barber.id)">
        <div>
            <div class="flex justify-center">
                <img class="h-16 w-16 rounded-full object-cover" src="/assets/images/user.svg">
            </div>
            <div class="mt-3 flex flex-col">
                <p class="text-xs font-bold uppercase flex justify-center">{{barber.name}}</p>
                <p class="text-xs font-bold uppercase">Barbeiro(a)</p>
            </div>
            <div class="flex justify-center items-center mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
                <p class="text-xs ml-2 text-zinc-500">22</p>
            </div>
        </div>
        </div>
</template>

<script>
import { ref } from 'vue'

export default {
    name: "CardBarber",
    props: {
        barbers: {
            type: Object,
            required: true,
        }
    },

    setup(_, {emit}) {

        const barberSelected = ref(null);

        const selectBarber = (barberId) => {
            barberSelected.value = barberId;
            emit('barberSelected', barberId)
        }

        return {
            selectBarber, 
            barberSelected
        }
    },
};
</script>
