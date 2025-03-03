<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div class="min-h-screen flex items-center justify-center bg-cover bg-center" 
            style="background-image: url('/images/background.png');">
            
            <div class="bg-[#43B610] text-white p-8 rounded-lg shadow-md w-full max-w-md">
                <Head title="Log in" />

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>
<!-- Email -->
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email" class="text-[#00ADB5]" />
                        <TextInput id="email" type="email" class="mt-1 block w-full text-white bg-[#222831] border border-[#00ADB5]" 
                            v-model="form.email" required autofocus autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
<!-- password -->
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" type="password" class="mt-1 block w-full"
                            v-model="form.password" required autocomplete="current-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
<!-- Remember me -->
                    <div class="mt-4 block">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-black-600 dark:text-black-400">
                                Remember me
                            </span>
                        </label>
                    </div>
<!-- Botón de Login y Forgot Password -->
                    <div class="mt-4 flex items-center justify-end">
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="rounded-md text-sm text-black-600 underline hover:text-black-900">
                            Forgot your password?
                        </Link>

                        <PrimaryButton class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Log in
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

