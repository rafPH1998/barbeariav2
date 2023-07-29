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
                    <img class="h-16 w-16 rounded-full object-cover bg-red-500" 
                        :src="[
                            barber.image ? '/storage/' + barber.image : '/assets/images/barbeiro.png'
                        ]"
                    >
                </div>
                <div class="mt-3 flex flex-col">
                    <p class="text-xs font-bold uppercase flex justify-center">{{barber.name}}</p>
                    <p class="text-xs font-bold uppercase flex justify-center">Barbeiro(a)</p>
                </div>

                <div class="flex justify-center mt-2">
                    <div v-if="isBarberAvailable(barber.id) || barber.status == 0">
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
                    <IconHeartDefault/>
                    <p class="text-xs ml-2 text-zinc-500">{{barber.likes_count}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3';
import IconHeartDefault from '../../../components/IconHeartDefault.vue'

export default {
    name: "CardBarber",
    props: {
        barbers: {
            type: Object,
            required: true,
        }
    },

    components: {
        IconHeartDefault
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
