<template>
    <div>
        <Main>
            <h1 class="flex justify-center mt-10 font-bold text-2xl text-white animate__animated animate__backInLeft">Selecione um tipo de serviço</h1>  
            
            <div class="py-10 flex justify-center animate__animated animate__backInLeft">
                <div v-if="services.length == 0">
                    Nenhum serviço cadastrado!
                </div>
                <div v-else>
                    <CardTypeService :servicesObject="props.services" />
                </div>
            </div>
        </Main>
    </div>
</template>

<script setup>
import Main from '../Layouts/Main.vue';
import CardTypeService from './components/CardTypeService.vue';

const props = defineProps({
    services: Object
})
</script>