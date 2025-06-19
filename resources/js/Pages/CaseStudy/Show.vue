<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";
import ChartCard from "@/Components/Core/Chart/ChartCard.vue";
import {router, useForm} from "@inertiajs/vue3";
import {TwitterIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
import {usePermissions} from "@/Composables/usePermissions.js";
import {ref} from "vue";
import ConfirmDeleteModal from "@/Components/Core/Modals/ConfirmDeleteModal.vue";
import RestoreMessage from "@/Components/Core/Permissions/RestoreMessage.vue";

const props = defineProps({
    caseStudy: {
        type: Object,
        required: true
    }
});

const history = props.caseStudy.follower_history || [];

const categories = history.map(item => item.loaded_at
    //new Date(item.loaded_at).toLocaleDateString("es-ES", {
        //day: "2-digit", month: "2-digit", year: "numeric", hour: "2-digit", minute: "2-digit"
    //})
);

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
    formDestroy.delete(route('case-studies.destroy', props.caseStudy.id), {
        preserveScroll: true,
        onSuccess: () => closeModalDestroy(),
        onError: () => {},
        onFinish: () => formDestroy.reset(),
    });
}
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
            <div v-if="caseStudy.deleted_at != null">
                <RestoreMessage :permission="usePermissions().hasPermission('restore case studies')" @restore="router.post(route('case-studies.restore',props.caseStudy.id))">
                    This Case Study is deleted. You can restore it, if you have the permission to.
                </RestoreMessage>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap my-12">
                        <div class="mx-auto">
                            <span class="inline text-3xl h-fit"> {{ caseStudy.space_title }}</span>

                            <div class="mt-2 text-lg">
                                <span class="inline text-lg h-fit">{{ caseStudy.client_name }}</span>
                                <br>
                                <span class="font-semibold">Space Topic:</span> {{ caseStudy.space_topic }}
                                <br>
                                <span class="font-semibold">Space Type:</span>{{ caseStudy.space_type }}
                                <br>
                                <span class="font-semibold">Date:</span> {{ caseStudy.date }}
                                <br>
                                <span class="font-semibold">Client Username:</span>{{ caseStudy.client_twitter_username }}
                                <br>
                                <span class="font-semibold">Created at:</span> {{ caseStudy.created_at }}
                                <br>
                                <span class="font-semibold">Updated at:</span> {{ caseStudy.updated_at }}
                                <br>
                                <span v-if="props.caseStudy.deleted_at" class="font-semibold">Deleted at:</span> {{caseStudy.deleted_at}}
                            </div>
                        </div>
                        <div class="mx-auto items-center text-center">
                            <div class="sm:pt-20">
                                <div>
                                    <PrimaryButton v-if="(usePermissions().hasPermission('edit case studies') && props.caseStudy.deleted_at == null )" @click="router.get(route('case-studies.edit',props.caseStudy.id))">
                                        Update Case Study
                                    </PrimaryButton>
                                </div>
                                <div>
                                    <DangerButton v-if="(usePermissions().hasPermission('delete case studies') && props.caseStudy.deleted_at == null )" @click="confirmDestroy()" class="mt-2">
                                        Delete Case Study
                                    </DangerButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <PrimaryButton v-if="(usePermissions().hasPermission('load twitter data for case studies') && props.caseStudy.deleted_at == null )"
                                           @click="router.post(route('case-studies.loadTwitterData',props.caseStudy.id))">
                                load data
                            </PrimaryButton>
                        </div>
                    </div>
                    <ChartCard
                        v-if="props.caseStudy.follower_history.length > 0"
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

