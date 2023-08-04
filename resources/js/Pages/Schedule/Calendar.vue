<template>
    <div>
        <Main>
            <div class="p-6">
                <h2 class="mb-4 font-bold py-4 uppercase">Calendário de agendas</h2>
    
                <!-- Loop through the grouped schedules -->
                <div v-for="(group, groupIndex) in groupedSchedules" :key="groupIndex" class="border-collapse border border-gray-700 mt-16 rounded p-6">
                    <h3 class="text-white p-1 mt-2">
                        <p class="font-bold">Dia {{ group.date }}</p>
                        <div class="mt-6">
                            <span class="text-red-500">Ocupados</span>
                        </div>
                    </h3>
        
                    <!-- Loop through the schedules within the current date group -->
                    <div v-for="(schedule, index) in group.schedules" :key="schedule.id">
                        <p class="text-white border-collapse border border-red-800 rounded p-1 mt-2 flex">
                            {{ schedule.hour }} - Barbeiro ({{ schedule.name }})
                            <img class="h-6 w-6 rounded-full ml-2" 
                                :src="[
                                    schedule.user_image ? '/storage/' + schedule.user_image : '/assets/images/user.svg'
                                ]"
                            >
                        </p>
                    </div>
        
                    <div class="mt-8">
                        <div class="p-2 rounded border-collapse border border-gray-700">
                            <details class="group">
                                <summary class="flex justify-between items-center font-medium cursor-pointer list-none">
                                    <span class="text-green-600">Disponíveis</span>
                                    <span class="transition group-open:rotate-180">
                                        <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                    </span>
                                </summary>
                                <div v-for="time in availableHours[groupIndex]" :key="time" class="text-white-800 border-collapse border border-green-500 rounded p-1 mt-2 flex">
                                    {{ time }}
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
    
            <button @click="scrollToTop" class="fixed right-4 bottom-4 p-2 bg-indigo-600 text-white rounded">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
            </svg>
            </button>
        </Main>
    </div>
  </template>
  
<script setup>
import Main from '../Layouts/Main.vue';
import { computed } from 'vue';

const props = defineProps({
    schedules: {
        type: Array
    },
    availableHours: {
        type: Array
    }
});

const groupedSchedules = computed(() => {
    const groups = {};
    props.schedules.forEach((schedule) => {
        if (!groups[schedule.date]) {
            groups[schedule.date] = {
                date: schedule.date,
                schedules: [schedule],
            }
        } else {
            groups[schedule.date].schedules.push(schedule);
        }
    })
    return Object.values(groups);
})

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}
</script>
  