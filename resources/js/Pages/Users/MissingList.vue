<template>
    <div>
        <Main>
            <h1 class="font-bold py-4 uppercase ml-4">Clientes que não frequentaram a barbearia nos ultimos 3 meses</h1>

            <div class="flex flex-wrap mt-4">
                <CardUsers :users="users.data"/>
            </div>
            <div class="ml-4 mt-5">
                <Pagination :data="users" @changePage="changePage"/>
            </div>
        </Main>
    </div>
</template>


<script setup>
import Main from '../Layouts/Main.vue';
import CardUsers from './components/CardUsers.vue';
import Pagination from '../../components/Pagination.vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({users: Object})

console.log(props.users)

const changePage = (page) => {
    router.get('/users', {page});
}

</script>

