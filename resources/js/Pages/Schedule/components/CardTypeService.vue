<template>
     <div class="border-collapse border border-gray-700 rounded-lg drop-shadow-xl p-10 ml-6">
        <div class="flex justify-center w-full">
            <div>
                <span class="flex justify-center">{{ nameService }}</span>
                <p class="flex justify-center text-white mt-4 text-xs">{{hour}}</p>
                <span class="flex justify-center mt-2 font-bold">R$ {{price}}</span>

                <Link 
                    :href="route('schedules.create', typeService)"
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
defineProps({
    nameService: {
        type: String,
        required: true,
    },
    hour: {
        type: String,
        required: true,
    },
    price: {
        type: String,
        required: true,
    },
    typeService: {
        type: String,
        required: true,
    },
})
</script>