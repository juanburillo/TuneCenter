<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBar from '@/Components/StatusBar.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    connections: {
        type: Array,
        required: true,
    },
    incomingRequests: {
        type: Array,
        required: true,
    },
});

const createForm = useForm({
    username: '',
});

const deleteForm = useForm({});

const submitCreateForm = () => {
    createForm.post(route('connections.store'), {
        onSuccess: () => createForm.reset('username'),
    });
};

const handleConnectionDelete = () => {
    deleteForm.delete(route('connections.destroy'));
}
</script>

<template>

    <Head title="Connections" />

    <StatusBar v-if="$page.props.flash.success">
        {{ $page.props.flash.success }}
    </StatusBar>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Connections</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="font-bold text-xl">Send connection request</h1>
                        <form @submit.prevent="submitCreateForm" class="mt-4">
                            <div>
                                <InputLabel for="username" value="Username" />

                                <TextInput id="username" type="text" class="mt-1 block w-full" v-model="createForm.username"
                                    autofocus />

                                <InputError class="mt-2" :message="createForm.errors.username" />
                            </div>

                            <div class="mt-4">
                                <PrimaryButton :class="{ 'opacity-25': createForm.processing }"
                                    :disabled="createForm.processing">
                                    Send
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-6 bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <h1 class="font-bold text-xl">Your connections</h1>
                        <div class="mt-4" v-if="connections.length === 0">
                            <p>You don't have any connections yet... Add someone and make some music together!</p>
                        </div>
                        <div class="mt-4 flex items-center space-x-4" v-else v-for="connection in connections">
                            <p>{{ connection.username }}</p>
                            <form>
                                <DangerButton @click="handleConnectionDelete">Remove</DangerButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>


</template>
