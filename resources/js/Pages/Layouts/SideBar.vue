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
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/home.png">
                    </div>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/dashboard'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Dashboard
                        </p>
                    </div>    
                </div>
            </Link>
            <Link :href="route('schedules.typeForm')" 
                :class="{ 'bg-white/10': $page.url === '/schedules/type-service' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/tesoura.png">
                    </div>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/type-service'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Agendar um serviço
                        </p>
                    </div>    
                </div>
            </Link>
            <Link :href="route('schedules.show', 1)" 
                :class="{ 'bg-white/10': $page.url === '/schedules/show' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/cronograma.png">
                    </div>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Minhas agendas</p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 py-1.5 rounded-full bg-indigo-800 text-xs font-mono font-bold">23</div>
                </div>
            </Link>
            <Link :href="route('assessments.index')"
                :class="{ 'bg-white/10': $page.url === '/assessments' }"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/avaliacoes.png">
                    </div>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/assessments'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Avaliações
                        </p>
                    </div>
                    <div class="absolute -top-3 -right-3 md:top-0 md:right-0 px-2 py-1.5 rounded-full bg-indigo-800 text-xs font-mono font-bold">23</div>
                </div>
            </Link>
            <Link :href="route('profile.index')" 
                :class="{'bg-white/10': $page.url === '/profile'}"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="relative flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/perfil.png">
                    </div>
                    <div>
                        <p 
                            :class="{'text-indigo-400': $page.url === '/profile'}"
                            class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Perfil
                        </p>
                    </div>
                </div>
            </Link>
            <Link :href="route('logout')" method="POST"
                class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                    <div>
                        <img class="h-10 w-10 rounded-full mt-2" src="/assets/images/sair.png">
                    </div>
                    <div>
                        <p class="font-bold text-base text-slate-200 leading-4 group-hover:text-indigo-400">Sair</p>
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