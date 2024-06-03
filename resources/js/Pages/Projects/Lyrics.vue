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

    <Head title="Lyrics" />

    <ProjectLayout :project="project">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lyrics</h2>
        </template>

    </ProjectLayout>

</template>
