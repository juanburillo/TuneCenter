<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    project: {
        type: Object,
        required: true,
    },
    messages: {
        type: Array,
        required: true,
    },
    collaborators: {
        type: Array,
        required: true,
    }
});

const project = usePage().props.project;
const collaborators = usePage().props.collaborators;

const createForm = useForm({
    content: '',
    project_id: project.id,
});

const submitCreateForm = () => {
    createForm.post(route('messages.store'), {
        onSuccess: () => {
            createForm.reset();
        }
    });
};

const getMessageUsername = (message) => {
    const collaborator = collaborators.find(c => c.id === message.user_id);
    return collaborator ? collaborator.username : 'Unknown';
}
</script>

<template>

    <Head title="Messages" />

    <ProjectLayout :project="project">

        <template #header>
            Messages
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="font-bold text-xl">Messages</h1>

                        <div class="mt-4 h-72 border border-gray-300 rounded overflow-y-auto">
                            <p v-for="message in messages" :key="message.id" class="p-2">
                                <span v-if="message.user_id === $page.props.auth.user.id" class="font-bold text-primary">You:</span>
                                <span v-else class="font-bold">{{ getMessageUsername(message) }}:</span>
                                {{ message.content }}
                            </p>
                        </div>

                        <form @submit.prevent="submitCreateForm" class="mt-4 flex gap-x-4">
                            <div class="flex-grow">
                                <TextInput
                                    v-model="createForm.content"
                                    class="w-full"
                                    type="text"
                                    placeholder="Type your message..."
                                />
                                <InputError class="mt-2" :message="createForm.errors.content" />
                            </div>
                            <PrimaryButton :class="{ 'opacity-25': createForm.processing }" :disabled="createForm.processing">Send</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </ProjectLayout>

</template>
