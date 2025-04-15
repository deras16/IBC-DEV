<script setup>
import {reactive, watch} from "vue";
import {debounce} from "lodash";
import {Link, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import Pagination from "@/Components/Core/Table/Pagination.vue";

const props = defineProps({
    marketingCaseStudies:{
        type: Object,
        required:true
    },
    filters:{
        type: Object,
        required:true
    }
});

const form = reactive({
    search: props.filters?.search
});

watch(form,debounce(() => {
    router.get('/marketing-case-studies', {search: form.search}, { preserveState:true , replace:true });
},500));
</script>

<template>
    <AuthenticatedLayout title="Marketing Case Studies">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Marketing Case Studies</h2>
        </template>

        <div class="py-12">
            <div>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                            <PrimaryButton @click="router.get(route('marketing-case-studies.create'));">
                                Create Marketing Case Study
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="props.marketingCaseStudies.data.length !== 0 " class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-between gap-4 my-12">
                    <div v-for="marketingCaseStudy in props.marketingCaseStudies.data" class="text-base p-2">
                        <Link :preserve-scroll="false"
                              method="get" as="button" :href="route('marketing-case-studies.show',marketingCaseStudy.id)" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-white">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{marketingCaseStudy.client_name }}</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">{{marketingCaseStudy.marketing_case_topic}}</p>
                            <span class="font-semibold">Views:</span> {{ marketingCaseStudy.views }} <br>
                            <span class="font-semibold ">Impressions:</span> {{ marketingCaseStudy.impressions }} <br>
                            <span class="font-semibold">Followers:</span> {{ marketingCaseStudy.followers }}
                        </Link>
                    </div>
                </div>
                <Pagination
                    :links="props.marketingCaseStudies.links"
                    :currentPage="props.marketingCaseStudies.current_page"
                    :totalItems="props.marketingCaseStudies.total"
                    :itemsPerPage="props.marketingCaseStudies.per_page"
                />
            </div>
            <div v-else>
                <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
                    <h2 class="text-3xl font-semibold">No data found.</h2>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

