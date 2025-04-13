<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/Core/Form/InputLabel.vue";
import TextInput from "@/Components/Core/Form/TextInput.vue";
import InputError from "@/Components/Core/Form/InputError.vue";
import PrimaryButton from "@/Components/Core/Button/PrimaryButton.vue";

const props = defineProps({
    role:{
        type:Object,
        required:false
    },
    role_permissions:{
        type:Object,
        required:false
    },
    permissions:{
        type:Object,
        required:true
    },
});

const form = useForm({
    id: props.role?.id ?? '',
    name:props.role?.name ?? '',
    permissions_id: props.role_permissions ?? [],

});

const store = () => {
    form.post(route('roles.store'));
};

const update = () => {
    form.patch(route('roles.update',{id: form.id}));
};
</script>

<template>
    <AuthenticatedLayout title="Role Form">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ props.role == null ? 'Create Role': 'Update Role' }}
            </h2>
        </template>

        <div class="py-6">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                            <form @submit.prevent="props.role != null ? update(form.id) : store()">
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
                                        <div class="border-b border-gray-400 font-semibold text-xl text-gray-800 dark:text-gray-200 flex justify-between margin-b mb-4">
                                            <h2 class="text-2xl font-bold mt-3 ">
                                                Permissions
                                            </h2>
                                        </div>
                                        <div class="overflow-y-auto " style="height: 20rem;">
                                            <div v-for="permission in props.permissions" :key="permission.id">
                                                <div class="flex flex-col mb-4 ml-4">
                                                    <div class="flex items-center space-x-3 mt-1">
                                                        <input :value="permission.id" v-model="form.permissions_id" id="permissions_id" type="checkbox"
                                                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <InputLabel for="permissions_id" :value="permission.name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <InputError class="mt-2" :message="form.errors.permissions_id" />
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <PrimaryButton class="mt-4" :disabled="form.processing">
                                        {{ props.role != null ? "Update" : "Create" }}
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
