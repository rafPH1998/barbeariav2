<template>
    <div>
        <Main>
            <div class="p-6">
                <h2 class="mb-4 font-bold py-4 uppercase">Calendário de agendas</h2>
                <div v-for="(schedule, index) in props.schedules" :key="schedule.id">
                    <h3 v-if="index === 0 || props.schedules[index - 1].date !== schedule.date" class="text-white font-bold p-1 mt-2">
                        Dia {{ schedule.date }}
                    </h3>

                    <p class="text-white font-bold bg-indigo-600 rounded p-1 mt-2 flex">
                        {{ schedule.hour }} - Barbeiro ({{schedule.name}})
                        <img class="h-6 w-6 rounded-full ml-2" 
                            :src="[
                                schedule.user_image ? '/storage/' + schedule.user_image : '/assets/images/user.svg'
                            ]"
                        >
                    </p>

                    <hr class="mt-6 border-collapse border border-gray-700" 
                        v-if="index < props.schedules.length - 1 && props.schedules[index + 1].date !== schedule.date"
                    >
                </div>
            </div>
            
            <button @click="scrollToTop" class="fixed right-4 bottom-4 p-2 bg-indigo-600 text-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
                </svg>
            </button>
        </Main>
    </div>
</template>

  
  
<script setup>
import Main from '../Layouts/Main.vue';
import { defineProps } from 'vue';

const props = defineProps({
    schedules: Array
});

console.log(props.schedules)

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}
</script>
  