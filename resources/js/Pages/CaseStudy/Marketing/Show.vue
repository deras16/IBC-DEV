<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import DangerButton from "@/Components/Core/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Core/Button/SecondaryButton.vue";
import DataTable from "@/Components/Core/Table/DataTable.vue";
import {DeleteIcon, DownloadIcon, TwitterIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
import Pagination from "@/Components/Core/Table/Pagination.vue";
import {reactive, ref, watch} from "vue";
import {debounce} from "lodash";
import { usePermissions } from '@/Composables/usePermissions';
import ChartCard from "@/Components/Core/Chart/ChartCard.vue";
import RestoreMessage from "@/Components/Core/Permissions/RestoreMessage.vue";
import ConfirmDeleteModal from "@/Components/Core/Modals/ConfirmDeleteModal.vue";

const props = defineProps({
    marketingCaseStudy:{
        type:Object,
        required:true
    },
    marketingFiles:{
        type:Object,
        required:true
    },
    filters:{
        type:Object,
        required:true
    }
});
const form = reactive({
    search: props.filters?.search
});

watch(form,debounce(() => {
    router.get(route('marketing-case-studies.show',{id:props.marketingCaseStudy.id}), {search: form.search}, { preserveState:true , replace:true, preserveScroll: true });
},500));

const history = props.marketingCaseStudy.follower_history || [];

const categories = history.map(item => item.loaded_at);

const series = [
    {
        name: "Followers",
        data: history.map(item => item.follower_count),
    },
];

const confirmingDestroy = ref(false);
const formDestroy = useForm({ password: '' });
function confirmDestroy() {
    confirmingDestroy.value = true;
}
function closeModalDestroy() {
    confirmingDestroy.value = false;
    formDestroy.reset();
}
function deleteCaseStudy(password) {
    formDestroy.password = password;
    formDestroy.delete(route('marketing-case-studies.destroy', props.marketingCaseStudy.id), {
        preserveScroll: true,
        onSuccess: () => closeModalDestroy(),
        onError: () => {},
        onFinish: () => formDestroy.reset(),
    });
}
</script>

<template>
    <AuthenticatedLayout title="Marketing Case Study Details">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Marketing Case Study Details
            </h2>
        </template>

        <div class="py-12">
            <div v-if="marketingCaseStudy.deleted_at != null">
                <RestoreMessage :permission="usePermissions().hasPermission('restore marketing case studies')" @restore="router.post(route('marketing-case-studies.restore',props.marketingCaseStudy.id))">
                    This Marketing Case Study is deleted. You can restore it, if you have the permission to.
                </RestoreMessage>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap my-12">
                        <div class="mx-auto">
                            <span class="inline text-3xl h-fit">{{ props.marketingCaseStudy.client_name }}</span>

                            <div class="mt-2 text-lg">
                                <span class="inline text-lg h-fit">{{ props.marketingCaseStudy.client_description }}</span>
                                <br>
                                <span class="font-semibold">Case Topic:</span> {{ props.marketingCaseStudy.marketing_case_topic }}
                                <br>
                                <span class="font-semibold">Date:</span> {{ props.marketingCaseStudy.date }}
                                <br>
                                <span class="font-semibold">Client Username:</span> {{ props.marketingCaseStudy.client_twitter_username}}
                                <br>
                                <span class="font-semibold">Created at:</span> {{ props.marketingCaseStudy.created_at }}
                                <br>
                                <span class="font-semibold">Updated at:</span> {{ props.marketingCaseStudy.updated_at }}
                                <br>
                                <span v-if="props.marketingCaseStudy.deleted_at" class="font-semibold">Deleted at:</span> {{marketingCaseStudy.deleted_at}}
                            </div>
                        </div>
                        <div class="mx-auto items-center text-center">
                            <div class="sm:pt-20">
                                <div>
                                    <PrimaryButton v-if="usePermissions().hasPermission('edit marketing case studies') && props.marketingCaseStudy.deleted_at == null"
                                                   class="ml-8" @click="router.get(route('marketing-case-studies.edit', props.marketingCaseStudy.id))">
                                        Edit
                                    </PrimaryButton>
                                </div>
                                <div>
                                    <DangerButton v-if="usePermissions().hasPermission('delete marketing case studies') && props.marketingCaseStudy.deleted_at == null"
                                                  class="mt-2 ml-8" @click="confirmDestroy()" >
                                        Delete
                                    </DangerButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <PrimaryButton v-if="usePermissions().hasPermission('upload marketing case studies files')  && props.marketingCaseStudy.deleted_at == null" @click="router.get(route('marketing-case-studies.createFile',props.marketingCaseStudy.id))">
                            Add new document
                        </PrimaryButton>
                    </div>
                </div>

                <DataTable
                    class="rounded-lg"
                    :columns="[
                                    {key:'id', label:'ID'},
                                    {key:'original_name', label:'Document Name'},
                                ]"
                    :data=props.marketingFiles.data
                >
                    <template #actions="{row}">
                        <div class="flex space-x-2">
                            <a :href="route('marketing-case-studies.downloadFile', {marketing_case_study: props.marketingCaseStudy.id, file: row.id})"
                               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                               v-if="usePermissions().hasPermission('download marketing case studies files')  && props.marketingCaseStudy.deleted_at == null"
                            >
                                <DownloadIcon className="w-6 h-6 text-gray-800 dark:text-white" />
                            </a>
                            <SecondaryButton v-if="usePermissions().hasPermission('delete marketing case studies files')  && props.marketingCaseStudy.deleted_at == null" @click="router.delete(route('marketing-case-studies.destroyFile',{marketing_case_study: props.marketingCaseStudy.id, file: row.id}))">
                                <DeleteIcon class="w-6 h-6 text-gray-800 dark:text-white"/>
                            </SecondaryButton>
                        </div>
                    </template>
                </DataTable>

                <Pagination
                    :links="props.marketingFiles.links"
                    :currentPage="props.marketingFiles.current_page"
                    :totalItems="props.marketingFiles.total"
                    :itemsPerPage="props.marketingFiles.per_page"
                />
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 p-4 md:p-6">
                    <div class="flex justify-between mb-4">
                        <div class="flex mb-2.5 space-x-3">
                            <TwitterIcon class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" />
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">X (Twitter) Analytics</h5>
                        </div>
                        <div class="flex items-center justify-end">
                            <PrimaryButton v-if="usePermissions().hasPermission('load twitter data for marketing case studies')  && props.marketingCaseStudy.deleted_at == null" @click="router.post(route('marketing-case-studies.loadTwitterData',props.marketingCaseStudy.id))">
                                load data
                            </PrimaryButton>
                        </div>
                    </div>
                    <ChartCard
                        v-if="props.marketingCaseStudy.follower_history.length > 0"
                        :x-label="'Date'"
                        :y-label="'Followers'"
                        :series="series"
                        :categories="categories"
                    />
                    <div v-else>
                        <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
                            <h2 class="text-2xl font-normal">No data found.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <ConfirmDeleteModal
        :show="confirmingDestroy"
        :processing="formDestroy.processing"
        :errors="formDestroy.errors"
        @close="closeModalDestroy"
        @confirm="deleteCaseStudy"
    />
</template>
