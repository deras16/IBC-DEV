<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";
import { router } from "@inertiajs/vue3";

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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                    <h2 class="text-2xl font-bold">{{ user.name }}</h2>
                    <p class="text-gray-500">{{ user.email }}</p>

                    <div class="mt-6">
                        <PrimaryButton @click="router.get(route('users.edit', user.id))">
                            Edit User
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
