<template>
    <nav aria-label="Page navigation example" 
        v-if="meta.next_page_url !== null || meta.prev_page_url !== null"
        >
        <ul class="inline-flex items-center -space-x-px">
            <li v-if="meta.current_page > 1" @click.prevent="changePage(meta.current_page - 1)">
                <Link 
                    class="cursor-pointer block px-3 py-2 ml-0 leading-tight text-indigo-500 hover:bg-white/10 bg-red border-collapse border border-gray-700 rounded-l-lg"
                >
                    <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </Link>
            </li>

            <li>
                <a
                    v-for="link in links"
                    :key="link.label"
                    :href="link.url"
                    @click.prevent="changePage(link.label)"
                    :class="{ 'bg-white/10': link.active }"
                    class="px-3 py-2 leading-tight text-indigo-500 hover:bg-white/10 border-collapse border border-gray-700 pagination"
                >
                    {{ link.label }}
                </a>
            </li>
  
            <li v-if="meta.current_page < meta.last_page" @click.prevent="changePage(meta.current_page + 1)">
                <Link
                    class="cursor-pointer block px-3 py-2 leading-tight text-indigo-500 hover:bg-white/10 border-collapse border border-gray-700 rounded-r-lg"
                >
                    <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </Link>
            </li>
        </ul>
    </nav>
</template>
  
<script>
import { computed } from "vue"
import { Link } from '@inertiajs/vue3';

export default {
    name: "Pagination",
    props: {
        data: {
            type: Object,
        }
    },

    setup(props, { emit }) {

        //esse emit dispara a pagina atual que o usuario está, 
        //assim no back toda vez que o usuario alterar a pagina, ele paginara de acordo com o status selecionado 
        const changePage = (page) => emit("changePage", page);
        
        //exibi todos os links da paginação
        const links = computed(() => {
            const cleanLinks = [...props.data.links];
            cleanLinks.shift();
            cleanLinks.pop();
            return cleanLinks;
        });

        const meta = computed(() => props.data)

        return {
            changePage,
            links,
            meta
        };
    },
};
</script>

<style>
 .pagination{
    font-size: 14.5px;
 }
</style>