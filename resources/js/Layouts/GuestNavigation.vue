<script setup>

import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

</script>

<template>
    <nav class="absolute inset-x-0 top-0 z-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link href="/">
                            <ApplicationLogo class="h-9 w-auto" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-8 ms-10">
                        <Link href="/">
                            Home
                        </Link>
                        <Link href="/about">
                            About
                        </Link>
                    </div>
                </div>

                <!-- User Links -->
                <div class="flex items-center space-x-8">
                    <Link href="/projects">
                        Projects
                    </Link>
                    <Link href="/login">
                        Login
                    </Link>
                    <Link href="/register">
                        Register
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
