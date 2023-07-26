<template>
    <div>
      <Main>
        <div class="p-6">
            <h2 class="text-3xl font-semibold mb-4">
                Calendário {{  currentDay + '-' + currentMonth + '-' + currentYear }}
            </h2>
            <table class="w-full">
                <tr>
                    <th class="p-2 border-collapse border-r border-gray-700 h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs text-white font-bold" v-for="dia in daysOfWeek" :key="dia">{{ dia }}</th>
                </tr>
                <tr class="text-center text-xs" v-for="(week, index) in weeks" :key="index">
                    <td class="border-collapse border border-gray-700 p-1 h-40 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto transition cursor-pointer duration-500 ease hover:bg-white/10" v-for="day in week" :key="day">
                        <div class="flex justify-center items-center h-full">
                            <span class="text-white font-bold" v-if="day !== 0">{{ day }}<br>
                                <div class="text-center">
                                    <p class="text-green-500 mt-5">Disponíveis</p>
                                    <div class="mt-5">
                                        <p class="text-white font-bold bg-green-700 rounded p-1 mt-2" v-if="day !== 0" v-for="hour in hours" :key="hour">{{ hour }}</p>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
      </Main>
    </div>
</template>
  
<script setup>
import Main from '../Layouts/Main.vue';
import {computed} from 'vue'

const props = defineProps({
    currentMonth: String,
    currentYear: String, 
    currentDay: String, 
    firstDayMonth: Number,
    lastDayMonth: Number,
    daysOfWeek: Array
});

const weeks = computed(() => {

    const weeks = [];
    let week = [];
    let dayCounter = 1;

    for (let i = 0; i < props.firstDayMonth; i++) {
        week.push(0);
    }

    while (dayCounter <= props.lastDayMonth) {
        week.push(dayCounter);
        if (week.length === 7) {
            weeks.push(week);
            week = [];
        }
        dayCounter++;
    }

    if (week.length > 0) {
        while (week.length < 7) {
            week.push(0);
        }
        weeks.push(week);
    }

    return weeks;
})

const hours = [];
for (let hour = 8; hour <= 20; hour++) {
    const formattedTime = `${hour.toString().padStart(2, '0')}:00`;
    hours.push(formattedTime);
}

</script>
 
  