<template>
    <div 
        :class="[
            props.type == 'file' ? '' : 'w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-4'
        ]">
        <label :for="name" class="block uppercase tracking-wide text-gray-300 text-xs font-light mb-1">{{ label }}</label>
        <input 
            :modelValue="modelValue"
            :type="showPassword ? 'text' : type"
            :value="modelValue"
            :name="name" 
            :id="name" 
            :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            :disabled="props.type == 'email' && props.id === 'email'"
            :class="[
                error ? 'border border-1 border-red-500' : '',
                props.type == 'email' && props.id === 'email' ? 'bg-white/10' : ''
            ]"
            class="bg-transparent  appearance-none rounded w-full py-2 px-3 text-gray-400 border-collapse border border-gray-700 focus:outline-none"
        >
        <span class="text-red-600 text-xs" v-if="error">{{ error }}</span>
        <p v-show="props.type === 'password'" @click="togglePassword()" 
            class="-ml-8 -mt-8 mr-1 flex items-center flex-row-reverse cursor-pointer">
            <IconShowPassword v-if="!showPassword" />
            <IconClosePassword v-if="showPassword" />
        </p>
    </div>
</template>

<script setup>
import IconShowPassword from '../../../components/IconShowPassword.vue';
import IconClosePassword from '../../../components/IconClosePassword.vue';

import { ref } from 'vue'

const props = defineProps({
    id: {
        type: String,
        required: false,
    },
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
    placeholder: {
        type: String,
        required: false,
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