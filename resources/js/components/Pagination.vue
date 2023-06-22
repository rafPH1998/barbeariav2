<template>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex items-center -space-x-px">
            <li>
                <Link 
                    :disabled="data.prev_page_url == null"
                    :href="data.prev_page_url" as="button"
                    class="block px-3 py-2 ml-0 leading-tight text-indigo-500 hover:bg-white/10 bg-red border-collapse border border-gray-700 rounded-l-lg">
                    <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </Link>
            </li>
            <li>
                <Link 
                    v-for="link in links" :key="link.label"
                    :href="link.url" as="button"
                    :class="{ 'bg-white/10': link.active }"
                    class="px-3 py-2 leading-tight text-indigo-500 hover:bg-white/10 border-collapse border border-gray-700 pagination">
                    {{ link.label }}
                </Link>
            </li>
            <li>
                <Link  
                    :disabled="data.next_page_url == null" 
                    :href="data.next_page_url" as="button"
                    class="block px-3 py-2 leading-tight text-indigo-500 hover:bg-white/10 border-collapse border border-gray-700 rounded-r-lg">
                    <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script setup>
    import { Link, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue'

    defineProps({
        data: Object,
    })

    const page = usePage()

    const links = computed(() => {
        const cleanLinks = [...page.props.schedules.links];
        cleanLinks.shift();
        cleanLinks.pop();
        return cleanLinks;
    });

</script>

<style>
 .pagination{
    font-size: 12.8px;
 }
</style>