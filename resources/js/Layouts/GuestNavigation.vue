<script setup>

import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';

</script>

<template>
    <nav class="absolute inset-x-0 top-0 z-50">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <ApplicationLogo class="h-9 w-auto" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex space-x-8 ms-10">
                        <NavLink :href="route('home')" :active="route().current('home')">
                            Home
                        </NavLink>
                        <NavLink :href="route('about')" :active="route().current('about')">
                            About
                        </NavLink>
                    </div>
                </div>

                <!-- User Links -->
                <div class="flex space-x-8">
                    <NavLink :href="route('projects.index')" v-if="$page.props.auth.user">
                        Projects
                    </NavLink>
                    <NavLink :href="route('login')" :active="route().current('login')" v-if="!$page.props.auth.user">
                        Login
                    </NavLink>
                    <NavLink :href="route('register')" :active="route().current('register')" v-if="!$page.props.auth.user">
                        Register
                    </NavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
