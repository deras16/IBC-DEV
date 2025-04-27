<script setup>
import {reactive, watch} from "vue";
import {debounce} from "lodash";
import {Link, router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import DataTable from "@/Components/Core/Table/DataTable.vue";
import Pagination from "@/Components/Core/Table/Pagination.vue";
import {ShowIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePermissions } from '@/Composables/usePermissions';

const props = defineProps({
    roles: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true
    }
});

const form = reactive({
    search: props.filters?.search
});

watch(form, debounce(() => {
    router.get('/roles', { search: form.search }, { preserveState: true, replace: true });
}, 500));
</script>

<template>
    <AuthenticatedLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Roles</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <div class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" v-model="form.search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search">
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-auto flex items-center justify-end">
                            <PrimaryButton v-if="usePermissions().hasPermission('create roles')" @click="router.get(route('roles.create'))">
                                Create Role
                            </PrimaryButton>
                        </div>
                    </div>

                    <DataTable
                        :columns="[
                            { key: 'id', label: 'ID' },
                            { key: 'name', label: 'Name' },
                            { key: 'created_at', label: 'Created At' },
                            { key: 'updated_at', label: 'Updated At' }
                        ]"
                        :data="props.roles.data"
                    >
                        <template #actions="{ row }">
                            <Link :href="route('roles.show', row.id)">
                                <ShowIcon class="block w-6 h-6" />
                            </Link>
                        </template>
                    </DataTable>

                    <Pagination
                        :links="props.roles.links"
                        :currentPage="props.roles.current_page"
                        :totalItems="props.roles.total"
                        :itemsPerPage="props.roles.per_page"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

