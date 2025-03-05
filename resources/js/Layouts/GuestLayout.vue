<script setup>
import ApplicationLogo from '@/Components/Core/ApplicationLogo.vue';
import { Link, Head } from '@inertiajs/vue3';
import ToggleDark from "@/Components/Core/ToggleDark.vue";

defineProps({
    title: String,
    default: "Not Defined"
})
</script>

<template>
    <Head :title="title"/>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 dark:bg-gray-900 bg-cover bg-center pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800"
        >
            <slot />
        </div>

        <div class="fixed right-10 top-10">
            <ToggleDark />
        </div>
    </div>
</template>
