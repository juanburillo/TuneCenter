<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBar from '@/Components/StatusBar.vue';

const form = useForm({
    username: '',
});

const submitForm = () => {
    form.post(route('connections.store'), {
        onSuccess: () => form.reset('username'),
        onError: (error) => console.error(error),
    });
};
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
                        <form @submit.prevent="submitForm" class="mt-4">
                            <div>
                                <InputLabel for="username" value="Username" />

                                <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username"
                                    autofocus />

                                <InputError class="mt-2" :message="form.errors.username" />
                            </div>

                            <div class="mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Send
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>


</template>
