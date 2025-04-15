<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/Core/Form/InputLabel.vue";
import TextInput from "@/Components/Core/Form/TextInput.vue";
import InputError from "@/Components/Core/Form/InputError.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import SelectInput from "@/Components/Core/Form/SelectInput.vue";
import TextAreaInput from "@/Components/Core/Form/TextAreaInput.vue";


const props = defineProps({
    marketingCaseStudy: {
        type: Object,
        required: false
    },
    marketingTopics: {
        type: Array,
        required: true
    }
})

const form = useForm({
    id: props.marketingCaseStudy?.id ?? '',
    client_name: props.marketingCaseStudy?.client_name ?? '',
    client_description: props.marketingCaseStudy?.client_description ?? '',
    marketing_case_topic : props.marketingCaseStudy?.marketing_case_topic ?? '',
    date: props.marketingCaseStudy?.date ?? '',
    views: props.marketingCaseStudy?.views ?? '',
    impressions: props.marketingCaseStudy?.impressions ?? '',
    listeners: props.marketingCaseStudy?.listeners ?? '',
    followers: props.marketingCaseStudy?.followers ?? '',
});
const store = () => {
    form.post(route('marketing-case-studies.store'));
};
const update = (id) => {
    form.patch(route('marketing-case-studies.update', props.marketingCaseStudy?.id));
};
</script>

<template>
    <AuthenticatedLayout title="Marketing Case Study Form">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ props.marketingCaseStudy != null ? "Update Marketing Case Study": "Create Marketing Case Study"}}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <form @submit.prevent="props.marketingCaseStudy != null ? update(form.id) : store()" >
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <InputLabel for="client_name" value="Client Name" />

                                    <TextInput
                                        id="client_name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.client_name"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.client_name" />
                                </div>
                                <div class="sm:col-span-2">
                                    <InputLabel for="client_description" value="Client Description" />

                                    <TextAreaInput
                                        id="client_name"
                                        class="mt-1 block w-full"
                                        v-model="form.client_description"
                                        rows="3"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.client_description" />
                                </div>
                                <div>
                                    <InputLabel for="date" value="Date" />

                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 end-0 flex items-center ps-3.5 mr-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input required type="date" id="date" v-model="form.date"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" />
                                    </div>

                                    <InputError class="mt-2" :message="form.errors.date" />
                                </div>
                                <div>
                                    <InputLabel for="space_topic" value="Space Topic" />
                                    <SelectInput
                                        id="space_topic"
                                        class="mt-1 block w-full"
                                        :options="props.marketingTopics"
                                        v-model="form.marketing_case_topic"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.marketing_case_topic" />
                                </div>
                                <div class="w-full">
                                    <InputLabel for="views" value="Views" />

                                    <TextInput
                                        id="views"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.views"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.views" />
                                </div>
                                <div>
                                    <InputLabel for="impressions" value="Impressions" />

                                    <TextInput
                                        id="impressions"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.impressions"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.impressions" />
                                </div>
                                <div class="w-full">
                                    <InputLabel for="listeners" value="Listeners" />

                                    <TextInput
                                        id="listeners"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.listeners"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.listeners" />
                                </div>
                                <div>
                                    <InputLabel for="followers" value="Followers" />

                                    <TextInput
                                        id="followers"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.followers"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.followers" />
                                </div>

                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton class="mt-4" :disabled="form.processing">
                                    {{props.marketingCaseStudy != null ? 'Update' : 'Create'}}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

