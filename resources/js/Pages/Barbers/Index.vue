<template>
    <div>
        <Main>
            <h1 class="font-bold py-4 uppercase">Barbeiros</h1>

            <div class="flex justify-center">
                <div 
                    v-for="barber in props.barbers" :key="barber.id"
                    class="w-44 p-2 mt-4 ml-4 border-collapse border effect
                    border-gray-700 rounded shadow flex justify-center 
                    cursor-pointer animate__animated animate__fadeIn">
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
                        
                        <div class="flex justify-center items-center mt-4">
                            <IconHeartDefault  
                                :isDisabled="'true'"
                                v-if="!isBarberLiked(barber.id) 
                                && (!barber.like_status || barber.like_status.length === 0)"
                                @click="toggleLikeBarber(barber.id)" 
                            />
                            <IconHeartWithBgColor 
                                v-else @click="toggleLikeBarber(barber.id)"
                            />
                            <p class="text-xs ml-2 text-zinc-500">{{ barber.likes_count }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </Main>
    </div>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import IconHeartDefault from '../../components/IconHeartDefault.vue'
import IconHeartWithBgColor from '../../components/IconHeartWithBgColor.vue'
import { router } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({ barbers: Object });
const likedBarbers = ref([]); 

const isBarberLiked = (barberId) => {
  return likedBarbers.value.includes(barberId);
}

const toggleLikeBarber = (barberId) => {
    router.post('/barbers', {barberId})

    if (isBarberLiked(barberId)) {
        likedBarbers.value = likedBarbers.value.filter((id) => id !== barberId);
    } else {
        likedBarbers.value.push(barberId);
    }
}

</script>


