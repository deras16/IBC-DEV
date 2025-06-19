<script setup>
import {reactive, watch} from "vue";
import {debounce} from "lodash";
import {Link, router} from "@inertiajs/vue3";
import { ShowIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import Pagination from "@/Components/Core/Table/Pagination.vue";
import DataTable from "@/Components/Core/Table/DataTable.vue";
import {usePermissions} from "@/Composables/usePermissions.js";

const props = defineProps({
    caseStudies:{
        type: Object,
        required:true
    },
    filters:{
        type: Object,
        required:true
    }
});

const form = reactive({
    search: props.filters?.search,
    trashed: props.filters?.trashed
});

watch(form,debounce(() => {
    router.get('/case-studies', {search: form.search , trashed: form.trashed}, { preserveState:true , replace:true });
},500));
</script>

<template>
    <AuthenticatedLayout title="Case Studies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Case Studies</h2>
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
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" v-model="form.search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search" required="">
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-auto flex items-center justify-end space-x-3">
                            <Link
                                :href="route('case-studies.index')"
                                method="get" as="button"
                                class="hover:text-green-500 dark:hover:text-green-600 hover:underline text-gray-600 dark:text-gray-400 text-sm"
                                preserve-scroll
                            >
                                clean search
                            </Link>
                            <div class="relative">
                                <select v-model="form.trashed" id="trashed" class="px-4 py-2 items-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    <option value="with">With Deleted</option>
                                    <option value="only">Only Deleted</option>
                                </select>
                            </div>
                            <PrimaryButton v-if="usePermissions().hasPermission('create case studies')" @click="router.get(route('case-studies.create'))">
                                Create Case Study
                            </PrimaryButton>
                        </div>
                    </div>

                    <DataTable
                        :columns="[
                            {key:'client_name', label:'Client Name'},
                            {key:'space_topic', label:'Space Topic'},
                            {key:'space_type', label:'Space Type'},
                            {key:'space_title', label:'Space Title'},
                            {key:'date', label:'Date'},
                            {key:'client_twitter_username', label:'Twitter User'}
                        ]"
                        :data=props.caseStudies.data
                    >
                        <template #actions="{row}">
                            <Link :href="route('case-studies.show', row.id)">
                                <ShowIcon class="block w-6 h-6" />
                            </Link>
                        </template>
                    </DataTable>

                    <Pagination
                        :links="props.caseStudies.links"
                        :currentPage="props.caseStudies.current_page"
                        :totalItems="props.caseStudies.total"
                        :itemsPerPage="props.caseStudies.per_page"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

