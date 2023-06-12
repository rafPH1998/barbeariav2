<template>
    <label :for="name" class="leading-7 text-sm text-white">{{ label }}</label>
     <input 
        :modelValue="modelValue"
        :type="type" 
        :value="modelValue"
        :name="name" 
        :id="name" 
        @input="$emit('update:modelValue', $event.target.value)"
        :class="[
            error ? 'border border-1 border-red-500' : ''
        ]"
         class="bg-white/10 shadow-lg 
                appearance-none rounded w-full py-2 px-3 text-white 
                leading-tight focus:outline-none focus:shadow-outline"
        >
     <span class="text-red-600 text-xs" v-if="error">{{ error }}</span>
 </template>
   
 <script setup>
    defineProps({
        label: {
            type: String,
            required: true,
        },
        modelValue: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        error: {
            type: String
        },
    })
 </script>