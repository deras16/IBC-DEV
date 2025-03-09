<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";

const props = defineProps({
    caseStudy: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Case Study
            </h2>
        </template>

        <div class="py-12">
            <div class="flex flex-wrap mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 text-gray-900 dark:text-gray-100">
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
                                <PrimaryButton>Update Case Study</PrimaryButton>
                                <DangerButton>Delete Case Study</DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="mx-auto">
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-gray-900 dark:text-gray-100">
                            <div class="p-5">
                                <span class="inline text-3xl h-fit"></span>
                                <div class="mt-2 text-lg">
                                    <span class="font-semibold">Millaje:</span>
                                    <br>
                                    <span class="font-semibold">Placas:</span>
                                    <br>
                                    <span class="font-semibold">VIN:</span>
                                    <br>
                                    <span class="font-semibold">Motor:</span>
                                    <br>
                                    <span class="font-semibold">Color:</span>
                                    <br>
                                    <span class="font-semibold">Año:</span>
                                    <br>
                                    <span class="font-semibold">Creado:</span>
                                    <br>
                                    <span class="font-semibold">Actualizado:</span>
                                    <br>
                                    <span  class="font-semibold">Eliminado el:</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

