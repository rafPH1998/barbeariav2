<template>

    <NavBar>
        <Link :href="route('register')" 
            class="text-white hover:bg-white/10 
            px-5 py-1 rounded-lg transition ease-in-out 
            delay-150 hover:-translate-y-1
            hover:duration-300 hover:scale-110 " 
            :class="{ 'bg-white/10': $page.url === '/register' }">Registre-se
        </Link>

        <Link :href="route('login')" 
            class="text-white ml-6 hover:bg-white/10 
            px-5 py-1 rounded-lg transition ease-in-out 
            delay-150 hover:-translate-y-1 hover:scale-110 
            hover:duration-300">Login
        </Link>
    </NavBar>

    <h1 class="text-white">Register</h1>

</template>

<script setup>
import NavBar from '../../components/NavBar.vue';
import { Link } from '@inertiajs/vue3';
</script>