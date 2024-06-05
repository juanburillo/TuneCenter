<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import StatusBar from '@/Components/StatusBar.vue';

const showCreateModal = ref(false);
const showUpdateModal = ref(false);
const selectedLyric = ref(null);

defineProps({
    project: {
        type: Object,
        required: true,
    },
    lyrics: {
        type: Array,
        required: true,
    }
});

const projectId = usePage().props.project.id;

const createForm = useForm({
    title: '',
    content: '',
    project_id: projectId,
});

const updateForm = useForm({
    title: '',
    content: '',
});

const deleteForm = useForm({});

const submitCreateForm = () => {
    createForm.post(route('lyrics.store'), {
        onSuccess: () => {
            closeCreateModal();
            createForm.reset('title', 'content');
        },
    });
};

const submitUpdateForm = () => {
    updateForm.put(route('lyrics.update', selectedLyric.value.id), {
        onSuccess: () => closeUpdateModal(),
    });
};

const submitDeleteForm = () => {
    deleteForm.delete(route('lyrics.destroy', selectedLyric.value.id), {
        onSuccess: () => closeUpdateModal(),
    });
}

const closeCreateModal = () => {
    showCreateModal.value = false;
}

const closeUpdateModal = () => {
    showUpdateModal.value = false;
}

const handleShowUpdateModal = (lyric) => {
    selectedLyric.value = lyric;
    updateForm.title = lyric.title;
    updateForm.content = lyric.content;
    showUpdateModal.value = true;
}
</script>

<template>

    <Head title="Lyrics" />

    <StatusBar v-if="$page.props.flash.success">
        {{ $page.props.flash.success }}
    </StatusBar>

    <ProjectLayout :project="project">

        <template #header>
            Lyrics
        </template>

        <div class="py-12 px-4 grid gap-y-6 gap-x-4 md:grid-cols-2 lg:grid-cols-3">
            <div @click="showCreateModal = true"
                class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 border-dashed mx-auto hover:opacity-80 transition ease-in-out duration-150">
                <div class="py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 mb-2 inline-block text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>

                    <h4 class="text-base font-medium text-gray-500">Create new lyric version</h4>
                </div>
            </div>

            <div v-for="lyric in lyrics" :key="lyric.id" @click="handleShowUpdateModal(lyric)"
                class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 mx-auto hover:opacity-80 transition ease-in-out duration-150">
                <div class="py-6 w-full">
                    <h3 class="text-lg font-medium overflow-hidden text-ellipsis">{{ lyric.title }}</h3>
                    <p class="overflow-hidden text-ellipsis whitespace-nowrap">{{lyric.content }}</p>
                </div>
            </div>
        </div>

        <!-- Create lyric modal -->
        <Modal :show="showCreateModal" @close="closeCreateModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a new lyric for this project
                </h2>

                <form @submit.prevent="submitCreateForm" class="mt-4">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" class="mt-1 block w-full" v-model="createForm.title" autofocus />
                        <InputError class="mt-2" :message="createForm.errors.title" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="content" value="Content" />
                        <TextAreaInput id="content" class="mt-1 block w-full h-72" v-model="createForm.content" />
                        <InputError class="mt-2" :message="createForm.errors.content" />
                    </div>

                    <div class="mt-6 flex">
                        <SecondaryButton @click="closeCreateModal">Cancel</SecondaryButton>
                        <PrimaryButton class="ms-3">Create</PrimaryButton>
                    </div>
                </form>

            </div>
        </Modal>

        <!-- Update lyric modal -->
        <Modal :show="showUpdateModal" @close="closeUpdateModal">
            <div class="p-6">
                <form @submit.prevent="submitUpdateForm">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" class="mt-1 block w-full" v-model="updateForm.title" />
                        <InputError class="mt-2" :message="updateForm.errors.title" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="content" value="Content" />
                        <TextAreaInput id="content" class="mt-1 block w-full h-72" v-model="updateForm.content" />
                        <InputError class="mt-2" :message="updateForm.errors.content" />
                    </div>

                    <div class="mt-6 flex">
                        <SecondaryButton @click="closeUpdateModal">Cancel</SecondaryButton>
                        <PrimaryButton class="ms-3">Update</PrimaryButton>
                    </div>
                </form>

                <DangerButton @click="submitDeleteForm" class="mt-4">Delete</DangerButton>
            </div>
        </Modal>

    </ProjectLayout>

</template>
