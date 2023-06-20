<template>
    <label :for="name" class="block uppercase tracking-wide text-gray-300 text-xs font-light mb-1">{{ label }}</label>
    <div class="flex">
     <input 
        :modelValue="modelValue"
        :type="showPassword ? 'text' : type"
        :value="modelValue"
        :name="name" 
        :id="name" 
        @input="$emit('update:modelValue', $event.target.value)"
        :class="[
            error ? 'border border-1 border-red-500' : ''
        ]"
         class="bg-transparent appearance-none rounded w-full py-2 px-3 text-gray-400 border-collapse border border-gray-700 focus:outline-none"
        >
        <p v-show="props.type === 'password'" @click="togglePassword()" 
            class="-ml-8 flex items-center cursor-pointer 
            transition ease-in-out 
            delay-150 hover:-translate-y-1 
            hover:scale-110 duration-300">
            <IconShowPassword v-if="!showPassword" />
            <IconClosePassword v-if="showPassword" />
        </p>
    </div>
    <span class="text-red-600 text-xs" v-if="error">{{ error }}</span>
 </template>
   
 <script setup>
    import IconShowPassword from '../../../components/IconShowPassword.vue'
    import IconClosePassword from '../../../components/IconClosePassword.vue'
    import { ref } from 'vue'

    const props = defineProps({
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

    const showPassword = ref(false)
    const togglePassword = () => showPassword.value = !showPassword.value
 
 </script>