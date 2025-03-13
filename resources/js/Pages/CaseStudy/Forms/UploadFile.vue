<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import InputError from "@/Components/Core/Form/InputError.vue";

const props = defineProps({
    caseStudyId:{
        type:Number,
        required:true
    },
});

const form = useForm({
    file: null,
});


const storeFile = () => {
    form.post(route('case-studies.storeFile', props.caseStudyId));
};
</script>

<template>
    <AuthenticatedLayout title="Upload File">
        <template #header>
            <h1 class="text-xl font-semibold  text-gray-800 dark:text-gray-200 leading-tight">
                Upload File
            </h1>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <form  @submit.prevent="storeFile()">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <div class="flex items-center justify-center w-full">
                                        <label for="files" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>

                                                <ul v-if="form.file != null" class="mt-4" >
                                                    <li class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ form.file.name }}
                                                    </li>
                                                </ul>

                                                <ul v-else class="text-center">
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold"></span>Drag an drop or click to upload a file</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF, PNG, JPG O JPEG</p>
                                                    <p class=" mt-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">MAX 2048</span></p>
                                                </ul>
                                            </div>

                                            <input id="files" type="file" @input="form.file =  $event.target.files[0]" multiple class="hidden" accept="application/pdf" />
                                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                {{ form.progress.percentage }}%
                                            </progress>
                                            <InputError :message="form.errors.file" class="mt-2" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <PrimaryButton class="mt-4" :disabled="form.processing">Upload</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

