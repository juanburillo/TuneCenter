<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const messagesContainer = ref(null);

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

defineExpose({
    messagesContainer,
});

onMounted(() => scrollToBottom());

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
            scrollToBottom();
        }
    });
};

const getMessageUsername = (message) => {
    const collaborator = collaborators.find(c => c.id === message.user_id);
    return collaborator ? collaborator.username : 'Unknown';
};

const scrollToBottom = () => {
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const formatCreatedAt = (date) => {
    return dayjs(date).fromNow(true);
};
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

                        <div ref="messagesContainer" class="mt-4 h-72 border border-gray-300 rounded overflow-y-auto">
                            <div v-for="message in messages" :key="message.id" class="p-2">
                                <span class="text-xs text-gray-400 mr-2">({{ formatCreatedAt(message.created_at) }} ago)</span>
                                <span v-if="message.user_id === $page.props.auth.user.id" class="font-bold text-primary">You:</span>
                                <span v-else class="font-bold">{{ getMessageUsername(message) }}:</span>
                                <p class="inline ml-2">{{ message.content }}</p>
                            </div>
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
