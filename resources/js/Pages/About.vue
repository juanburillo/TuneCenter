<script setup>

import { Head } from '@inertiajs/vue3';
import GuestNavigation from '@/Layouts/GuestNavigation.vue';
import GuestFooter from '@/Layouts/GuestFooter.vue';

</script>

<template>
    <Head title="About" />

    <GuestNavigation />

    <div class="mx-auto max-w-2xl pt-32 pb-16 text-center">
        <h1 class="text-6xl font-bold tracking-tight sm:text-7xl lg:text-8xl">About</h1>
        <div class="mt-6">
            <p>
                <span class="font-bold text-primary">TuneCenter</span> is a tool
                made by music makers for music makers. But, what's it for?
            </p>
            <div class="mt-8">
                <h2 class="mb-4 text-4xl font-bold">Simplify Your Solo Endeavors</h2>
                <p>
                    Ever find yourself juggling between voice memos, lyric sheets, and
                    countless storage services for your music projects? TuneCenter is here
                    to change that. Our <span class="font-bold text-primary">Individual Projects</span> feature is designed
                    to be your
                    all-in-one workspace, keeping your creative ideas, lyrics, and files
                    neatly organized in one accessible place. Say goodbye to the hassle of
                    switching apps and hello to a smoother creative process.
                </p>
            </div>
            <div class="mt-8">
                <h2 class="mb-4 text-4xl font-bold">Elevate Collaboration</h2>
                <p>
                    For artists, lyricists, composers, and producers, the journey from a
                    song idea to a finished track is a collaborative marathon.
                    TuneCenter's <span class="font-bold text-primary">Collaborative Projects</span> feature is the bridge
                    that connects creative
                    minds. We offer a secure, centralized platform that streamlines the
                    song-making process, ensuring that every team member has instant access
                    to the resources they need. Collaborate effortlessly, share files
                    securely, and bring your musical vision to life together with
                    TuneCenter.
                </p>
            </div>
            <div class="mt-8">
                <h2 class="mb-4 text-4xl font-bold">Why Choose TuneCenter?</h2>
                <p>
                    Because we understand the complexities of music creation and
                    collaboration. Our platform is designed to simplify these processes,
                    allowing you to focus on what you do best: creating unforgettable music.
                    Whether you're working on a solo piece or a collaborative masterpiece,
                    TuneCenter is your go-to solution for staying organized and inspired.
                    Also, it's <span class="font-bold text-primary">completely free!</span>
                </p>
            </div>
        </div>
    </div>

    <GuestFooter />

</template>
