<template>
    <div id="menu" class="bg-white/10 col-span-3 rounded-lg p-4 ">
        <a href="#" class="flex flex-col space-y-2 md:space-y-0 md:flex-row mb-5 items-center md:space-x-2 hover:bg-white/10 group transition duration-150 ease-linear rounded-lg group w-full py-3 px-2">
            <div>
                <img class="h-10 w-10 rounded-full relative object-cover" src="/assets/images/user.svg">
            </div>
            <div>
                <p class="font-medium group-hover:text-indigo-400 leading-4">{{ user.name }}</p>
                <span class="text-xs text-slate-500">Cliente desde: {{ user.created_at }}</span>
            </div>
        </a>
        <hr class="my-2 border-slate-700">
        <div id="menu" class="flex flex-col space-y-2 my-5">
            <Link :href="route('dashboard')" 
                :class="{ 'bg-white/10': $page.url === '/dashboard' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/dashboard'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Dashboard
                        </p>
                    </div>    
                </div>
            </Link>
            <Link :href="route('schedules.typeForm')" 
                :class="{ 'bg-white/10': $page.url === '/schedules/type-service' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.848 8.25l1.536.887M7.848 8.25a3 3 0 11-5.196-3 3 3 0 015.196 3zm1.536.887a2.165 2.165 0 011.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 11-5.196 3 3 3 0 015.196-3zm1.536-.887a2.165 2.165 0 001.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863l2.077-1.199m0-3.328a4.323 4.323 0 012.068-1.379l5.325-1.628a4.5 4.5 0 012.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.331 4.331 0 0010.607 12m3.736 0l7.794 4.5-.802.215a4.5 4.5 0 01-2.48-.043l-5.326-1.629a4.324 4.324 0 01-2.068-1.379M14.343 12l-2.882 1.664" />
                    </svg>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/type-service'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Agendar um serviço
                        </p>
                    </div>    
                </div>
            </Link>
            <Link :href="route('schedules.mySchedules')" 
                :class="{ 'bg-white/10': $page.url === '/schedules/show' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Minhas agendas</p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 py-1.5 rounded-full bg-indigo-800 text-xs font-mono font-bold">23</div>
                </div>
            </Link>
            <Link :href="route('assessments.index')"
                :class="{ 'bg-white/10': $page.url === '/assessments' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                    </svg>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/assessments'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Avaliações
                        </p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 py-1.5 rounded-full bg-indigo-800 text-xs font-mono font-bold">23</div>
                </div>
            </Link>
            <Link :href="route('profile.index')" 
                :class="{'bg-white/10': $page.url === '/profile'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/profile'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Perfil
                        </p>
                    </div>
                </div>
            </Link>
            <Link :href="route('logout')" method="POST"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400 ml-4">Sair</p>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.flash.user)


</script>