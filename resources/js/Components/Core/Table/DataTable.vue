<script setup>
import { defineProps, ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Definir propiedades
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

// Estado para el ordenamiento
const sortColumn = ref(null);
const sortOrder = ref('asc'); // 'asc' o 'desc'

// Función para ordenar
const sortedData = computed(() => {
    if (!sortColumn.value) return props.data;

    return [...props.data].sort((a, b) => {
        const valueA = a[sortColumn.value];
        const valueB = b[sortColumn.value];

        if (typeof valueA === 'string') {
            return sortOrder.value === 'asc'
                ? valueA.localeCompare(valueB)
                : valueB.localeCompare(valueA);
        } else {
            return sortOrder.value === 'asc' ? valueA - valueB : valueB - valueA;
        }
    });
});

const sortBy = (columnKey) => {
    if (sortColumn.value === columnKey) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = columnKey;
        sortOrder.value = 'asc';
    }
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th v-for="column in columns" :key="column.key"  scope="col" class="px-4 py-3" @click="sortBy(column.key)">
                    <div class="flex items-center">
                        {{ column.label }}
                        <svg class="w-3 h-3 ms-1.5 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                        </svg>
                    </div>
                </th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(row, index) in sortedData" :key="index" class="border-b dark:border-gray-700">
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
