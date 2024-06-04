<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const select = ref(null);
</script>

<template>
    <select class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm" v-model="model"
        ref="select">
        <slot />
    </select>
</template>
