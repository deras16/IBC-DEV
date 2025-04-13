<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <AuthenticatedLayout title="User Details">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">User Details</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl mt-4">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 text-gray-900 dark:text-gray-100 ">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white">
                            {{ user.name }}
                        </h2>
                        <p class="mb-4 text-lg font-bold text-gray-500 dark:text-gray-400">
                            {{ user.email }}
                        </p>

                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Created At</dt>
                                <dd class="text-gray-500 dark:text-gray-400">{{ user.created_at }}</dd>
                            </div>
                            <div>
                                <dt class="mb-1 font-semibold text-gray-900 dark:text-white">Updated At</dt>
                                <dd class="text-gray-500 dark:text-gray-400">{{ user.updated_at }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <PrimaryButton @click="router.get(route('users.edit', user.id))">
                                Update User
                            </PrimaryButton>
                            <DangerButton>Delete User</DangerButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto text-center text-gray-900 dark:text-gray-100" :class="{'text-red-600 dark:text-red-400' : props.user.roles.length === 0}">
                <h2 class="text-3xl font-semibold">{{ props.user.roles.length === 0 ? 'User without Roles' : 'Roles' }}</h2>
            </div>

            <div class="flex flex-wrap justify-between items-center gap-4 my-5" v-if="props.user.roles.length !== 0">
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100">
                        <div v-for="role in props.user.roles" :key="role.id"
                                     class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow 0 dark:bg-gray-800 dark:border-gray-700 ">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> {{role.name}}</h5>
                            <div class="overflow-y-scroll" style="height: 10rem;">
                                <div v-for="role_permission in role.permissions">
                                    <p class="font-normal text-gray-700 dark:text-gray-400">{{role_permission.name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
