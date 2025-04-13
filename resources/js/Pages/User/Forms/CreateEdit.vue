<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/Core/Form/InputLabel.vue";
import TextInput from "@/Components/Core/Form/TextInput.vue";
import InputError from "@/Components/Core/Form/InputError.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";

const props = defineProps({
    user: {
        type: Object,
        required: false
    },
    user_roles: {
        type: Array,
        required: false
    },
    roles:{
        type:Object,
        required:true
    },
});

const form = useForm({
    id: props.user?.id ?? '',
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    roles_id: props.user_roles ?? [],
});

const store = () => {
    form.post(route('users.store'));
};

const update = (id) => {
    form.put(route('users.update', id));
};
</script>

<template>
    <AuthenticatedLayout title="User Form">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ props.user != null ? "Update User" : "Create User" }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                        <form @submit.prevent="props.user != null ? update(form.id) : store()">
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                <div class="sm:col-span-2">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div class="sm:col-span-2">
                                    <InputLabel for="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>

                                <div class="sm:col-span-2" v-if="props.roles.length !== 0">
                                    <InputLabel for="roles" value="Roles"/>
                                    <div id="roles" class="overflow-y-auto" style="height: 8rem;">
                                        <div v-for="role in props.roles" :key="role.id">
                                            <div class="flex flex-col mb-4 ml-4 mt-3">
                                                <div class="flex items-center space-x-3 mt-1">
                                                    <input :value="role.id" v-model="form.roles_id" id="roles_id" type="checkbox"
                                                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <InputLabel for="roles_id" :value="role.name"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.roles_id" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton class="mt-4" :disabled="form.processing">
                                    {{ props.user != null ? "Update" : "Create" }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
