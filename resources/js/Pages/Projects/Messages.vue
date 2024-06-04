<script setup>
import { Head } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';

defineProps({
    project: {
        type: Object,
        required: true,
    }
});
</script>

<template>

    <Head title="Messages" />

    <ProjectLayout :project="project">

        <template #header>
            Messages
        </template>

    </ProjectLayout>

</template>
