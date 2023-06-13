<template>
    <button type="submit" :disabled="loader" 
        class="animate__animated animate__fadeInDown mt-4 
        text-white bg-indigo-800 font-bold 
        rounded-full text-xs p-2 hover:bg-indigo-900">
        <slot/>
    </button>
</template>

<script setup>
    defineProps({
        loader: {
            type: Boolean
        },
    })
</script>