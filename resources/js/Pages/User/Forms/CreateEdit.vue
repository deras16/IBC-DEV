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
    }
});

const form = useForm({
    id: props.user?.id ?? '',
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    password: '',
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

                                <div class="sm:col-span-2">
                                    <InputLabel for="password" value="Password" />
                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        v-model="form.password"
                                        :required="!props.user"
                                        placeholder="Leave blank to keep current password"
                                    />
                                    <InputError class="mt-2" :message="form.errors.password" />
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
