<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    columns: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th v-for="column in columns" :key="column.key" class="px-4 py-3">
                    {{ column.label }}
                </th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in data" :key="index" class="border-b dark:border-gray-700">
                    <td v-for="column in columns" :key="column.key" class="px-4 py-3">
                        {{ row[column.key] }}
                    </td>
                    <td class="px-4 py-3 flex items-center justify-end">
                        <slot name="actions" :row="row"></slot>
                    </td>
                </tr>
                <tr v-if="props.data.length === 0" class="text-center">
                    <td class="px-6 py-4 border-b dark:border-gray-700" colspan="4">
                        No data found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
