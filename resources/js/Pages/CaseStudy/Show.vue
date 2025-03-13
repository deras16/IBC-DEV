<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";
import DataTable from "@/Components/Core/Table/DataTable.vue";
import {router, Link} from "@inertiajs/vue3";
import {DownloadIcon, DeleteIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
import SecondaryButton from "@/Components/Core/Button/SecondaryButton.vue";

const props = defineProps({
    caseStudy: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <AuthenticatedLayout title="Show Case Study">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Case Study
            </h2>
        </template>

        <div class="py-12">
            <div class="flex flex-wrap mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl mt-4">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 text-gray-900 dark:text-gray-100 ">
                        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                            <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">
                                {{ caseStudy.space_title }}
                            </h2>
                            <p class="mb-4 text-lg font-bold text-gray-500 dark:text-gray-400">
                                {{ caseStudy.client_name }}
                            </p>

                            <dl class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Space Topic</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.space_topic }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Space Type</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.space_type }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Date</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.date }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Views</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.views.toLocaleString() }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Impressions</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.impressions.toLocaleString() }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Listeners</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.listeners.toLocaleString() }}</dd>
                                </div>
                                <div>
                                    <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Followers</dt>
                                    <dd class="text-gray-500 dark:text-gray-400">{{ caseStudy.followers.toLocaleString() }}</dd>
                                </div>
                            </dl>

                            <div class="mt-6 flex items-center justify-end space-x-4">
                                <PrimaryButton @click="router.get(route('case-studies.edit',props.caseStudy.id))">
                                    Update Case Study
                                </PrimaryButton>
                                <DangerButton>Delete Case Study</DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-4">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <h2 class="text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">
                                    Documents
                                </h2>
                                <p class="mb-2 text-lg font-bold text-gray-500 dark:text-gray-400">
                                    Associated documents with this case study.
                                </p>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <PrimaryButton @click="router.get(route('case-studies.createFile',props.caseStudy.id))">
                                    Add new document
                                </PrimaryButton>
                            </div>
                        </div>
                        <div class="p-5">
                            <DataTable
                                class="rounded-lg"
                                :columns="[
                                    {key:'id', label:'ID'},
                                    {key:'original_name', label:'Document Name'},
                                ]"
                                :data=props.caseStudy.files
                            >
                                <template #actions="{row}">
                                   <div class="flex space-x-2">
                                       <a :href="route('case-studies.downloadFile', {caseStudy: props.caseStudy.id, file: row.id})"
                                          class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                                       >
                                           <DownloadIcon className="w-6 h-6 text-gray-800 dark:text-white" />
                                       </a>
                                       <SecondaryButton @click="router.delete(route('case-studies.destroyFile',{caseStudy: props.caseStudy.id, file: row.id}))">
                                           <DeleteIcon class="w-6 h-6 text-gray-800 dark:text-white"/>
                                       </SecondaryButton>
                                   </div>
                                </template>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

