<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import {router} from "@inertiajs/vue3";
import { usePermissions } from '@/Composables/usePermissions';

const props = defineProps({
    role:{
        type:Object,
        required:true
    },
});

</script>

<template>
    <AuthenticatedLayout title="Role Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Role Details</h2>
        </template>

        <div class="py-9">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap my-12">
                        <div class="mx-auto">
                            <span class="inline text-3xl h-fit">{{ props.role.name }}</span>
                            <div class="mt-2 text-lg mb-2">
                                <span class="font-semibold">Created at:</span> {{ props.role.created_at }}
                                <br>
                                <span class="font-semibold">Updated at:</span> {{ props.role.updated_at }}
                            </div>
                        </div>
                        <div class="mx-auto items-center text-center">
                            <div>
                                <PrimaryButton  v-if="usePermissions().hasPermission('edit users')" class="ml-8" @click="router.get(route('roles.edit', role.id))">
                                    Update
                                </PrimaryButton>
                            </div>
                            <div>
                                <DangerButton  v-if="usePermissions().hasPermission('delete users')" class="mt-2 ml-8">
                                    Delete
                                </DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto text-center my-4 text-gray-900 dark:text-gray-100">
                <h2 class="text-3xl font-semibold">Permissions</h2>
            </div>

            <div class="mt-4">
                <div class="flex flex-wrap justify-between gap-4 my-1">
                    <div class="flex justify-center mx-auto" >
                        <div class="flex flex-col mb-4">
                            <div class="mx-auto sm:px-6 lg:px-8">
                                <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100">
                                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow 0 dark:bg-gray-800 dark:border-gray-700 ">
                                        <div class="overflow-y-scroll" style="height: 10rem;">
                                            <div v-for="permission in props.role.permissions">
                                                <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"> {{permission.name}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
