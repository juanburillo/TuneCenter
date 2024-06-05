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

const showModal = ref(false);

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

const submitCreateForm = () => {
    createForm.post(route('lyrics.store'), {
        onSuccess: () => {
            closeModal();
            createForm.reset('title', 'content');
        },
    });
};

const closeModal = () => {
    showModal.value = false;
}
</script>

<template>

    <Head title="Lyrics" />

    <ProjectLayout :project="project">

        <template #header>
            Lyrics
        </template>

        <div class="py-12 px-4 grid gap-y-6 gap-x-4 md:grid-cols-2 lg:grid-cols-3">
            <div @click="showModal = true" class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 border-dashed mx-auto">
                <div class="py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 mb-2 inline-block text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    <h4 class="text-base font-medium text-gray-500">Create new lyric version</h4>
                </div>
            </div>

            <div v-for="lyric in lyrics" class="bg-gray-50 w-full h-40 text-center px-4 rounded max-w-md flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 mx-auto">
                <div class="py-6 w-full">
                    <h3 class="text-lg font-medium overflow-hidden text-ellipsis">{{ lyric.title }}</h3>
                    <p class="overflow-hidden text-ellipsis whitespace-nowrap">{{lyric.content }}</p>
                </div>
            </div>
        </div>


        <Modal :show="showModal" @close="closeModal">
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

                        <TextAreaInput id="content" class="mt-1 block w-full h-72" v-model="createForm.content" autofocus />

                        <InputError class="mt-2" :message="createForm.errors.content" />
                        <InputError class="mt-2" :message="createForm.errors.user_id" />
                        <InputError class="mt-2" :message="createForm.errors.project_id" />
                    </div>

                    <div class="mt-6 flex">
                        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                        <PrimaryButton class="ms-3">Create</PrimaryButton>
                    </div>
                </form>

            </div>
        </Modal>

    </ProjectLayout>

</template>
