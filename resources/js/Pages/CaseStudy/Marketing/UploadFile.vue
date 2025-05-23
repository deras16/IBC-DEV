<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import InputError from "@/Components/Core/Form/InputError.vue";

const props = defineProps({
    marketingCaseStudyId: {
        type: Number,
        required: true
    }
});

const form = useForm({
    file: null
});

const uploadProgress = ref(0);
const handleFileUpload = (event) => {
    const file = event.target.files[0];

    if (file) {
        form.file = file;
        uploadProgress.value = 0; // Reiniciar la barra de progreso

        const reader = new FileReader();
        let simulatedProgress = 0;

        reader.onprogress = (event) => {
            if (event.lengthComputable) {
                const targetProgress = Math.round((event.loaded / event.total) * 100);

                // Animación más fluida con `setInterval`
                const interval = setInterval(() => {
                    if (simulatedProgress < targetProgress) {
                        simulatedProgress += 2; // Incremento gradual
                        uploadProgress.value = simulatedProgress;
                    } else {
                        clearInterval(interval);
                    }
                }, 50); // Intervalo cada 50ms
            }
        };

        reader.onloadend = () => {
            // Simulación de llegada al 100%
            const interval = setInterval(() => {
                if (uploadProgress.value < 100) {
                    uploadProgress.value += 2;
                } else {
                    clearInterval(interval);
                }
            }, 50);
        };

        reader.readAsDataURL(file);
    }
};
const storeFile = () => {
    form.post(route('marketing-case-studies.storeFile', props.marketingCaseStudyId));
};
</script>

<template>
    <AuthenticatedLayout title="Upload File">
        <template #header>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Upload File
            </h1>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <form @submit.prevent="storeFile()">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <div class="flex items-center justify-center w-full">
                                        <label for="files"
                                               class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                     aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>

                                                <ul v-if="form.file != null" class="mt-4">
                                                    <li class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ form.file.name }}
                                                    </li>
                                                </ul>

                                                <ul v-else class="text-center">
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                        Drag and drop or click to upload a file
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        JPG, JPEG, PNG, PDF, DOC o DOCX
                                                    </p>
                                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">MAX 2048 MB</span>
                                                    </p>
                                                </ul>
                                            </div>

                                            <input id="files" type="file" @change="handleFileUpload" class="hidden"
                                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"/>
                                            <InputError :message="form.errors.file" class="mt-2"/>
                                        </label>
                                    </div>

                                    <!-- Barra de progreso -->
                                    <div v-if="uploadProgress > 0" class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                            <div
                                                class="bg-green-600 h-4 rounded-full text-center text-xs font-semibold text-white"
                                                :style="{ width: uploadProgress + '%' }">
                                                {{ uploadProgress }}%
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <PrimaryButton class="mt-4" :disabled="form.processing || uploadProgress < 100">
                                <span v-if="form.processing || uploadProgress < 100">
                                   <div role="status">
                                        <svg aria-hidden="true" class="inline w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                   </div>
                                </span>
                                <span v-else>Upload</span>
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
