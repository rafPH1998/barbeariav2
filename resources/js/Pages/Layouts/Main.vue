<template>
    <NavBar>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <div class="relative ml-3">
                <div class="flex items-center">
                    <p class="text-white text-xs mr-3">Bem vindo, {{ user.name }}</p>
                    <button 
                        @click="showDropdown()"
                        type="button" 
                        class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full" src="/assets/images/user.svg">
                    </button>
                </div>
                <div
                    :class="[
                        dropdown ? 'block' : 'hidden' 
                    ]"
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-200 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <Link :href="route('profile.index')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white" role="menuitem" tabindex="-1" id="user-menu-item-0">Meu perfil</Link>
                    <Link :href="route('logout')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white" role="menuitem" tabindex="-1" id="user-menu-item-1">Sair</Link>
                </div>
            </div>
        </div>
    </NavBar>

    <div class="antialiased bg-black w-full min-h-screen text-slate-300 relative py-4">
        <div class="grid grid-cols-12 mx-auto gap-2 sm:gap-4 md:gap-6 lg:gap-10 xl:gap-14 max-w-7xl my-10 px-2">
            <SideBar/>
            <div id="content" class="bg-white/10 col-span-9 rounded-lg p-6">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script setup>
import SideBar from '../Layouts/SideBar.vue'
import NavBar from '../Layouts/NavBar.vue'
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'

const dropdown = ref(false)
const page = usePage()

const showDropdown = () => dropdown.value = !dropdown.value
const user = computed(() => page.props.flash.user)

</script>