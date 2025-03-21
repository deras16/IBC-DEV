<script setup>
import { Head } from '@inertiajs/vue3'
import NavBar from "@/Components/Core/Nav/NavBar.vue"
import FlashNotification from "@/Components/Core/FlashNotification.vue";
defineProps({
    title: String,
    default: "Not Defined"
})
</script>

<template>
    <Head :title="title"/>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- NavBar content -->
            <NavBar />

            <!-- Page Heading -->
            <header
                class="bg-white shadow dark:bg-gray-800"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
                <FlashNotification />
            </main>
        </div>
    </div>
</template>
