<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const textarea = ref(null);
</script>

<template>
    <textarea class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm" v-model="model" ref="textarea">
        <slot />
    </textarea>
</template>
