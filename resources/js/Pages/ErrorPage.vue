<script setup>
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue'

const props = defineProps({ status: Number })

const description = computed(() => {
    return {
        503: "SERVICE UNAVAILABLE.",
        500: "SERVER ERROR.",
        404: "PAGE NOT FOUND.",
        403: "ACTION NOT AUTHORIZED.",
    }[props.status]
})
</script>

<template>
    <Head title="Error" />
    <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                <div class="px-4 text-lg text-gray-300 border-r border-gray-400 tracking-wider">
                    {{ status }}
                </div>
                <div class="ml-4 text-lg text-gray-300 uppercase tracking-wider">
                    {{ description }}
                </div>
            </div>
        </div>
    </div>
</template>
