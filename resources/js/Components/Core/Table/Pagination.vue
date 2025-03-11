<script setup>
import { Link } from "@inertiajs/vue3";
import {computed, ref} from "vue";
const props = defineProps({
    links:{
        type:Array,
        required:true
    },
    currentPage: {
        type: Number,
        required: true
    },
    totalItems: {
        type: Number,
        required: true
    },
    itemsPerPage: {
        type: Number,
        required: true
    }
});

const startItem = computed(() => (props.currentPage - 1) * props.itemsPerPage + 1);
const endItem = computed(() => Math.min(props.currentPage * props.itemsPerPage, props.totalItems));
</script>

<template>
    <nav v-if="links.length > 1" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Showing
            <span class="font-semibold text-gray-900 dark:text-white">{{ startItem }}</span>
            -
            <span class="font-semibold text-gray-900 dark:text-white">{{ endItem }}</span>
            of
            <span class="ffont-semibold text-gray-900 dark:text-white">{{ totalItems }}</span>
        </span>
        <ul class="inline-flex items-stretch -space-x-px">
            <li v-for="(link, index) in links" :key="index" class="flex flex-wrap">
                <div
                    v-if="link.url === null"
                    class="mb-1 mr-1 px-4 py-3 leading-tight border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-white dark:bg-gray-800 rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    :href="link.url ?? ''"
                    class="mb-1 mr-1 px-4 py-3 leading-tight border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-500 rounded"
                    :class="{
                        'bg-gray-200 dark:bg-gray-700': link.active
                    }"
                    v-html="link.label" preserve-scroll>
                </Link>
            </li>
        </ul>
    </nav>
</template>
