<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

defineProps({
    projects: {
        type: Array,
        required: true,
    }
});

const createForm = useForm({
    title: '',
});

const deleteForm = useForm({});

const submitCreateForm = () => {
    createForm.post(route('projects.store'), {
        onSuccess: () => createForm.reset('title'),
    });
};

const handleProjectDelete = (projectId) => {
    deleteForm.delete(route('projects.destroy', projectId));
};

const formatUpdatedAt = (date) => {
    return dayjs(date).fromNow(true);
};

</script>

<template>

    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="font-bold text-xl">Create new project</h1>
                        <form @submit.prevent="submitCreateForm" class="mt-4">
                            <div>
                                <InputLabel for="title" value="Title" />

                                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="createForm.title"
                                    required autofocus />

                                <InputError class="mt-2" :message="createForm.errors.title" />
                            </div>

                            <div class="mt-4">
                                <PrimaryButton :class="{ 'opacity-25': createForm.processing }"
                                    :disabled="createForm.processing">
                                    Create
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <div class="p-6" v-if="projects.length === 0">
                        <h1 class="font-bold text-xl">Your projects</h1>
                        <p class="mt-4">You don't have any projects yet... Create one and start making music!</p>
                    </div>
                    <div class="p-6 flex space-x-2" v-else v-for="project in projects" :key="project.id">
                        <svg v-if="project.is_collaborative" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 text-gray-600 -scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 -scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span>
                                        {{ project.title }}
                                    </span>
                                    <small class="ml-2 text-sm text-gray-600">
                                        {{ formatUpdatedAt(project.updated_at) }} ago
                                    </small>
                                </div>
                            </div>
                            <Link :href="route('projects.show', project)" tabindex="-1">
                            <SecondaryButton class="mt-4">Open</SecondaryButton>
                            </Link>
                        </div>
                        <svg @click="handleProjectDelete(project.id)" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="h-5 w-5 text-gray-600 cursor-pointer hover:text-gray-800 transition ease-in-out duration-150">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
