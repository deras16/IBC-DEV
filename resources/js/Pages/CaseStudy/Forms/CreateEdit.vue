<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/Core/Form/InputLabel.vue";
import TextInput from "@/Components/Core/Form/TextInput.vue";
import InputError from "@/Components/Core/Form/InputError.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import SelectInput from "@/Components/Core/Form/SelectInput.vue";


const props = defineProps({
    caseStudy: {
        type: Object,
        required: false
    },
    spaceTopics: {
        type: Array,
        required: true
    },
    spaceTypes: {
        type: Array,
        required: true
    }
})

const form = useForm({
    id: props.caseStudy?.id ?? '',
    space_title: props.caseStudy?.space_title ?? '',
    client_name: props.caseStudy?.client_name ?? '',
    space_topic: props.caseStudy?.space_topic ?? '',
    space_type: props.caseStudy?.space_type ?? '',
    date: props.caseStudy?.date ?? '',
    views: props.caseStudy?.views ?? '',
    impressions: props.caseStudy?.impressions ?? '',
    listeners: props.caseStudy?.listeners ?? '',
    followers: props.caseStudy?.followers ?? '',
});
const store = () => {
    form.post(route('case-studies.store'));
};
const update = (id) => {
    form.put(route('case-studies.update', id));
};
</script>

<template>
    <AuthenticatedLayout title="Case Study Form">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ props.caseStudy != null ? "Update Case Study": "Create Case Study"}}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <form @submit.prevent="props.caseStudy != null ? update(form.id) : store()" >
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <InputLabel for="space_title" value="Space Title" />

                                    <TextInput
                                        id="space_title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.space_title"
                                        required
                                    />

                                    <InputError class="mt-2" :message="form.errors.space_title" />
                                </div>
                                <div>
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
                                        :options="props.spaceTopics"
                                        v-model="form.space_topic"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.space_topic" />
                                </div>
                                <div>
                                    <InputLabel for="space_type" value="Space Type" />

                                    <SelectInput
                                        id="space_type"
                                        class="mt-1 block w-full"
                                        :options="props.spaceTypes"
                                        v-model="form.space_type"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.space_type" />
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
                                    {{props.caseStudy != null ? 'Update' : 'Create'}}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

