<template>
    <div class="flex justify-center">
        <div 
            v-for="barber in barbers" :key="barber.id"
            :class="{
                'border-indigo-700' : barber.id === barberSelected ,
                'bg-white/5' : barber.status === 0 || isBarberAvailable(barber.id),
                'effect' : barber.status !== 0 && !isBarberAvailable(barber.id)
            }"
            class="w-44 p-2 mt-4 ml-4 border-collapse border
            border-gray-700 rounded shadow flex justify-center 
            cursor-pointer animate__animated animate__fadeIn" @click="barber.status !== 0 && !isBarberAvailable(barber.id) && selectBarber(barber.id)">
            <div>
                <div class="flex justify-center">
                    <img class="h-16 w-16 rounded-full object-cover" 
                        :src="[
                            barber.image ? '/storage/' + barber.image : '/assets/images/user.svg'
                        ]"
                    >
                </div>
                <div class="mt-3 flex flex-col">
                    <p class="text-xs font-bold uppercase flex justify-center">{{barber.name}}</p>
                    <p class="text-xs font-bold uppercase flex justify-center">Barbeiro(a)</p>
                </div>

                <div class="flex justify-center mt-2">
                    <div v-if="isBarberAvailable(barber.id)">
                        <div class="ml-2 inline-flex items-center px-3 py-1 text-red-500 rounded-full gap-x-2 bg-red-100/60 dark:bg-gray-800">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 3L3 9M3 3L9 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <h2 class="text-xs font-normal">Indisponível</h2>
                        </div>
                    </div>
                    <div v-else>
                        <div class="ml-2 inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60 dark:bg-gray-800">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <h2 class="text-xs font-normal">Disponível</h2>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <p class="text-xs ml-2 text-zinc-500">22</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3';

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
        const page = usePage()

        const selectBarber = (barberId) => {
            barberSelected.value = barberId;
            emit('barberSelected', barberId)
        }

        const statusBarbers = page.props.flash.barbersBusy;

        const isBarberAvailable = (barberId) => {
            const barberUnavailableConditions = [
                (barberId === 1 && !statusBarbers[1]),
                (barberId === 4 && !statusBarbers[4])
            ];
            return barberUnavailableConditions.some(condition => condition);
        }

        return {
            isBarberAvailable,
            selectBarber, 
            barberSelected
        }
    },
};
</script>
