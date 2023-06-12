<template>
    <div>
        <Main>
           <!--  <p class="text-white">criar uma agenda</p> -->
 
            <h1 class="flex justify-center mt-10 font-bold text-2xl text-white animate__animated animate__backInLeft">Selecione um tipo de serviço</h1>  
            
            <div class="py-10 flex justify-center animate__animated animate__backInLeft">
                <CardTypeService
                    :nameService="'Corte'"
                    :hour="'45min'"
                    :price="'25'"
                    :typeService="'corte'"
                />

                <CardTypeService
                    :nameService="'Corte + Barba'"
                    :hour="'1:30min'"
                    :price="'45'"
                    :typeService="'corte_barba'"
                />
            </div>
        </Main>
    </div>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import { Link } from '@inertiajs/vue3';
import CardTypeService from './components/CardTypeService.vue';
</script>