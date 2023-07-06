<template>
    <button type="submit" :disabled="loader" 
        :class="[
            props.typeButton === 'cancel' ? 'bg-red-800 hover:bg-red-900 mr-2' : 'bg-indigo-800 hover:bg-indigo-900'
        ]"
        class="animate__animated animate__fadeInDown mt-4 
        text-white font-bold 
        rounded-full text-xs p-2">
        <slot/>
    </button>
</template>

<script setup>
    const props = defineProps({
        loader: {
            type: Boolean
        },
        typeButton: {
            type: String
        }
    })
</script>