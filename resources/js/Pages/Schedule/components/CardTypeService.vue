<template>
    <div class="flex">
        <div class="border-collapse border border-gray-700 rounded-lg drop-shadow-xl p-10 ml-4"  
            v-for="services in servicesObject" :key="services.id">
            <div>
                <span class="flex justify-center">{{ services.name_plan }}</span>
                <p class="flex justify-center text-white mt-4 text-xs">{{services.time_plan}} min</p>
                <span class="flex justify-center mt-2 font-bold">R$ {{services.price_plan}}</span>

                <Link 
                    :href="route('schedules.create', services.name_plan)"
                    type="button"
                    class="bg-indigo-500 hover:bg-indigo-600
                    font-bold py-2 px-4 rounded-full
                    mt-6 text-center w-full transition ease-in-out 
                    delay-150 hover:-translate-y-1 text-white
                    hover:scale-110 duration-150 text-xs">
                    Agendar
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    servicesObject: {
        type: Object,
        required: true,
    }
})
</script>