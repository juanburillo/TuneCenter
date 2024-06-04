<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    project: {
        type: Object,
        required: true,
    }
});

const project = usePage().props.project;

const projectInfoForm = useForm({
    title: project.title,
    key: project.key,
    time_signature: project.time_signature,
    bpm: String(project.bpm),
});

const submitProjectInfoForm = () => {
    projectInfoForm.put(route('projects.update', project.id), {
        onSuccess: () => {
            project.title = projectInfoForm.title;
            project.key = projectInfoForm.key;
            project.time_signature = projectInfoForm.time_signature;
            project.bpm = projectInfoForm.bpm;
        },
    });
};
</script>

<template>

    <Head title="Dashboard" />

    <ProjectLayout :project="project">

        <template #header>
            Dashboard
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-bold text-xl">Project information</h1>
                        <form class="mt-4" @submit.prevent="submitProjectInfoForm">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput v-model="projectInfoForm.title" id="title" type="text" class="block mt-1 w-full" />
                                <InputError class="mt-2" :message="projectInfoForm.errors.title" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="key" value="Key" />
                                <TextInput v-model="projectInfoForm.key" id="key" type="text" class="block mt-1 w-full" />
                                <InputError class="mt-2" :message="projectInfoForm.errors.key" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="time_signature" value="Time Signature" />
                                <TextInput v-model="projectInfoForm.time_signature" id="time_signature" type="text" class="block mt-1 w-full" />
                                <InputError class="mt-2" :message="projectInfoForm.errors.time_signature" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="bpm" value="BPM" />
                                <TextInput v-model="projectInfoForm.bpm" id="bpm" type="number" class="block mt-1 w-full" />
                                <InputError class="mt-2" :message="projectInfoForm.errors.bpm" />
                            </div>
                            <div class="mt-4 flex items-center gap-4">
                                <PrimaryButton :disabled="projectInfoForm.processing">Update</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="projectInfoForm.recentlySuccessful" class="text-sm text-gray-600">Updated.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </ProjectLayout>

</template>
