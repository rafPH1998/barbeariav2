<template>
    <div id="menu" class="bg-white/10 col-span-3 rounded-lg p-4 h-[58rem]">
        <a href="#" class="flex flex-col space-y-2 md:space-y-0 md:flex-row mb-5 items-center md:space-x-2 hover:bg-white/10 group transition duration-150 ease-linear rounded-lg group w-full py-3 px-2">
            <div>
                <img class="h-10 w-10 rounded-full relative object-cover" 
                :src="[
                    !user.image && (user.type === 'employee' || user.type === 'manager')
                        ? '/assets/images/gerente.png'
                        : (!user.image && user.type === 'user' ? '/assets/images/user.svg' : `/storage/${user.image}`)
                ]">
            </div>
            <div>
                <p class="font-medium group-hover:text-indigo-400 leading-4">{{ user.name }}</p>
                <span class="text-xs text-gray-400 block uppercase tracking-wide font-light mb-1">Cliente desde: {{ user.created_at }}</span>
            </div>
        </a>
        <hr class="my-2 border-slate-700">
        <div id="menu" class="flex flex-col space-y-2 my-5">
            <Link v-if="canView" :href="route('dashboard')" :class="{ 'bg-white/10': $page.url === '/dashboard' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconDashboard/>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/dashboard'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Dashboard
                        </p>
                    </div>    
                </div>
            </Link>

            <div v-if="canView">
                <button 
                    @click="isMenuOpenServices($page.url)"
                    type="button" 
                    :class="{'bg-white/10 block' : subMenuServices}"
                    class="flex items-center w-full p-2 rounded-lg group hover:bg-white/10 dark:text-white" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                    <span class="flex-1 ml-6 text-left whitespace-nowrap" sidebar-toggle-item>Serviços</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-example" 
                    :class="[
                        subMenuServices 
                        || page.url === '/services/create' 
                        || page.url === '/services' 
                        ? 'block' : 'hidden' 
                    ]"
                    class="py-2 space-y-2">
                    <li>
                        <Link :href="route('services.index')" 
                            :class="{ 'bg-white/10': $page.url === '/services' }"
                            class="flex items-center w-full p-2 rounded-lg pl-6 group hover:bg-white/10 dark:text-white text-xs">
                            <IconUserList/>
                            <p class="ml-2">Listar serviços</p>
                        </Link>
                    </li>
                    <li>
                        <Link 
                            :href="route('services.create')" 
                            :class="{ 'bg-white/10': $page.url === '/services/create'}"
                            class="flex items-center w-full p-2 rounded-lg pl-6 group hover:bg-white/10 dark:text-white text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="ml-2">Criar novo serviço</p>
                        </Link>
                    </li>
                </ul>
            </div>

            <div v-if="canView">
                <button 
                    @click="isMenuOpenClients($page.url)"
                    type="button" 
                    :class="{'bg-white/10 block' : subMenuClients}"
                    class="flex items-center w-full p-2 rounded-lg group hover:bg-white/10 dark:text-white" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span class="flex-1 ml-6 text-left whitespace-nowrap" sidebar-toggle-item>Clientes</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-example" 
                    :class="[
                        subMenuClients 
                        || page.url === '/users' 
                        || page.url === '/users-birthday' 
                        || page.url === '/users-missing' 
                        ? 'block' : 'hidden' 
                    ]"
                    class="py-2 space-y-2">
                    <li>
                        <Link 
                            :href="route('users.index')" 
                            :class="{ 'bg-white/10': $page.url === '/users'}"
                            class="flex items-center w-full p-2 rounded-lg pl-6 group hover:bg-white/10 dark:text-white text-xs">
                            <IconUserList/>
                            <p class="ml-2">Listagem</p>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('users.birthday')" 
                            :class="{ 'bg-white/10': $page.url === '/users-birthday' }"
                            class="flex items-center w-full p-2 rounded-lg pl-6 group hover:bg-white/10 dark:text-white text-xs">
                            <IconBirthday/>
                            <p class="ml-2">Aniversários ({{birthdaysOfTheDay}})</p>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('users.missing')" 
                            :class="{ 'bg-white/10': $page.url === '/users-missing' }"
                            class="flex items-center w-full p-2 rounded-lg pl-6 group hover:bg-white/10 dark:text-white text-xs">
                            <IconUserMissing/>
                            <p class="ml-2">Sumidos</p>
                        </Link>
                    </li>
                </ul>
            </div>
            <Link v-if="!canView" :href="route('schedules.mySchedules')" :class="{ 'bg-white/10': $page.url === '/schedules/my-schedules' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconSchedule/>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Minhas agendas</p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 p-1 rounded-full bg-indigo-800 text-xs font-mono font-bold">
                        {{ user.agenda_count }}
                    </div>
                </div>
            </Link>
            <Link v-if="canView" :href="route('schedules.index')" :class="{ 'bg-white/10': $page.url === '/schedules' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Agendas do dia</p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 p-1 rounded-full bg-indigo-800 text-xs font-mono font-bold">
                        {{ countSchedules.length }}
                    </div>
                </div>
            </Link>
            <Link v-if="!canView" :href="route('schedules.typeForm')" :class="{ 'bg-white/10': $page.url === '/schedules/type-service' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconScheduleService/>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/type-service'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Agendar um serviço
                        </p>
                    </div>    
                </div>
            </Link>
            <Link :href="route('assessments.index')" :class="{ 'bg-white/10': $page.url === '/assessments' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                    </svg>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/assessments'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Avaliações
                        </p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 p-1 rounded-full bg-indigo-800 text-xs font-mono font-bold">11</div>
                </div>
            </Link>
            <Link :href="route('profile.index')" :class="{'bg-white/10': $page.url === '/profile'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconProfile/>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/profile'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Perfil
                        </p>
                    </div>
                </div>
            </Link>
            <Link v-if="canView" :href="route('employees.index')" :class="{'bg-white/10': $page.url === '/employees'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconEmployees/>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/employees'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Funcionários
                        </p>
                    </div>
                </div>
            </Link>
            <Link :href="route('schedules.calendar')" :class="{'bg-white/10': $page.url === '/schedules/calendar'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconCalendar/>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/employees'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Calendário
                        </p>
                    </div>
                </div>
            </Link>
            <Link :href="route('barbers')" :class="{'bg-white/10': $page.url === '/barbers'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <img class="h-6 w-6 rounded-full  bg-indigo-500" src="/assets/images/barbeiro.png">
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Barbeiros</p>
                    </div>
                </div>
            </Link>
            <Link :href="route('logout')" method="POST"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <IconLogout/>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Sair</p>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<script setup>
import IconBirthday from './components/icons/IconBirthday.vue';
import IconUserList from './components/icons/IconUserList.vue';
import IconSchedule from './components/icons/IconSchedule.vue';
import IconLogout from './components/icons/IconLogout.vue';
import IconProfile from './components/icons/IconProfile.vue';
import IconDashboard from './components/icons/IconDashboard.vue';
import IconScheduleService from './components/icons/IconScheduleService.vue';
import IconUserMissing from './components/icons/IconUserMissing.vue';
import IconEmployees from './components/icons/IconEmployees.vue';
import IconCalendar from './components/icons/IconCalendar.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'

const subMenuClients = ref(false)
const subMenuServices = ref(false)

const page = usePage()
const user = computed(() => page.props.flash.user)
const canView = computed(() => page.props.permissions.view_menu)
const countSchedules = computed(() => page.props.flash.countSchedules)
const birthdaysOfTheDay = computed(() => page.props.birthdaysOfTheDay)

const isMenuOpenClients = () => {
    subMenuClients.value = !subMenuClients.value
}

const isMenuOpenServices = () => {
    subMenuServices.value = !subMenuServices.value
}


</script>