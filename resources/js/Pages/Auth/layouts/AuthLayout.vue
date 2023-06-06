<template>
    <NavBar>
        <Link :href="route('register')" 
            class="text-white hover:bg-white/10 
            px-5 py-2 rounded-lg transition ease-in-out 
            delay-150 hover:-translate-y-1 hover:scale-110 
            hover:duration-300 text-xs"
            :class="{ 'bg-white/10': $page.url === '/register' }">
            Registre-se
        </Link>

        <Link :href="route('login')" 
            class="text-white ml-6 hover:bg-white/10 
            px-5 py-2 rounded-lg transition ease-in-out 
            delay-150 hover:-translate-y-1 hover:scale-110 
            hover:duration-300 text-xs"
            :class="{ 'bg-white/10': $page.url === '/login' }">
            Login
        </Link>
    </NavBar>

    <div class="flex justify-center">
        <div id="body" class="border-collapse border border-slate-500 p-10 mt-32 rounded-lg bg-white/10">
            <slot/>
        </div>
    </div>
</template>

<script setup>
    import NavBar from '../../../components/NavBar.vue';
    import { Link } from '@inertiajs/vue3';
</script>


<style>
   @media (max-width: 1300px) {
        #body {
            margin-top: 50px;
        }
    }
</style>