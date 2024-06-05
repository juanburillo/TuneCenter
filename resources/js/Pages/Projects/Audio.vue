<script setup>
import { computed, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBar from '@/Components/StatusBar.vue';

const showCreateModal = ref(false);
const showHelpText = ref(false);

defineProps({
    project: {
        type: Object,
        required: true,
    },
    audios: {
        type: Array,
        required: true,
    },
});

const project = usePage().props.project;

const createForm = useForm({
    title: '',
    type: 'track',
    file: null,
    project_id: project.id,
});

const deleteForm = useForm({});

const submitCreateForm = () => {
    console.log(createForm.data());
    createForm.post(route('audio.store'), {
        onSuccess: () => {
            closeCreateModal();
            createForm.reset();
        },
    });
};

const closeCreateModal = () => {
    showCreateModal.value = false;
};

const toggleHelpText = () => {
    showHelpText.value = !showHelpText.value;
};

const handleFileUpload = (event) => {
    createForm.file = event.target.files[0];
};

const displayAudioType = (type) => {
    if (type === 'track') {
        return 'Track';
    } else if (type === 'song') {
        return 'Song';
    } else {
        return 'Voice Note';
    }
};

const getSvgColor = (type) => {
    if (type === 'track') {
        return '#22c55e';
    } else if (type === 'song') {
        return '#3b82f6';
    } else {
        return '#ec4899';
    }
};
</script>

<template>

    <Head title="Audio" />

    <StatusBar v-if="$page.props.flash.success">
        {{ $page.props.flash.success }}
    </StatusBar>

    <ProjectLayout :project="project">

        <template #header>
            Audio
        </template>

        <div class="py-12 px-4 grid gap-y-6 gap-x-4 md:grid-cols-2 lg:grid-cols-3">
            <div @click="showCreateModal = true"
                class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 border-dashed mx-auto hover:opacity-80 transition ease-in-out duration-150">
                <div class="py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 mb-2 inline-block text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9 9 10.5-3m0 6.553v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 1 1-.99-3.467l2.31-.66a2.25 2.25 0 0 0 1.632-2.163Zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a1.803 1.803 0 0 1-.99-3.467l2.31-.66A2.25 2.25 0 0 0 9 15.553Z" />
                    </svg>

                    <h4 class="text-base font-medium text-gray-500">Create new audio item</h4>
                </div>
            </div>

            <div v-for="audio in audios" :key="audio.id" class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center border-2 border-gray-400 mx-auto">
                <div class="py-6 w-full relative">
                    <svg @click="deleteForm.delete(route('audio.destroy', audio.id))" class="absolute right-0 h-5 w-5 text-gray-600 cursor-pointer hover:text-gray-800 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>

                    <h3 class="text-lg font-medium overflow-hidden text-ellipsis">{{ audio.title }}</h3>
                    <audio controls class="mt-2 m-auto">
                        <source :src="'/storage/' + audio.file">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="mt-2 flex items-center justify-center gap-x-2">
                        <svg class="h-4" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" :fill="getSvgColor(audio.type)" />
                        </svg>
                        <p>{{ displayAudioType(audio.type) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create audio modal -->
        <Modal :show="showCreateModal" @close="closeCreateModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a new audio item for this project
                </h2>

                <form @submit.prevent="submitCreateForm" enctype="multipart/form-data" class="mt-4">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" class="mt-1 block w-full" v-model="createForm.title" autofocus />
                        <InputError class="mt-2" :message="createForm.errors.title" />
                    </div>

                    <div class="mt-4">
                        <div class="flex gap-x-1 items-center">
                            <InputLabel for="type" value="Type" />
                            <svg @click="toggleHelpText"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 text-gray-700 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </div>

                        <SelectInput id="type" class="mt-1 block w-full" v-model="createForm.type">
                            <option value="track">Track</option>
                            <option value="song">Song</option>
                            <option value="voice_note">Voice note</option>
                        </SelectInput>
                        <InputError class="mt-2" :message="createForm.errors.type" />

                        <p v-if="showHelpText" class="text-sm mt-2 text-gray-500">
                            <span class="font-bold">Track:</span> An individual audio recording, such as a guitar track.
                            <br>
                            <span class="font-bold">Song:</span> A complete audio piece, like a mixed track or a finished master.
                            <br>
                            <span class="font-bold">Voice note:</span> A recording of ideas, melodies, or suggested changes.
                        </p>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="file" value="File" />

                        <div class="max-w-md">
                            <input
                                id="file"
                                type="file"
                                name="file"
                                @change="handleFileUpload"
                                accept="audio/mpeg, audio/x-wav, audio/flac, audio/mp4"
                                class="mt-2 w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500 rounded"
                            />
                            <p class="text-xs text-gray-400 mt-2">MP3, WAV, FLAC, and M4A are allowed.</p>
                        </div>

                        <InputError class="mt-2" :message="createForm.errors.file" />
                    </div>

                    <div class="mt-6 flex">
                        <SecondaryButton @click="closeCreateModal">Cancel</SecondaryButton>
                        <PrimaryButton class="ms-3">Create</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

    </ProjectLayout>

</template>
