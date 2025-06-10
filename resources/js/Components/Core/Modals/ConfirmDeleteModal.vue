<script setup>
import { ref, watch, defineEmits } from 'vue';
import InputLabel from "@/Components/Core/Form/InputLabel.vue";
import TextInput from "@/Components/Core/Form/TextInput.vue";
import InputError from "@/Components/Core/Form/InputError.vue";
import SecondaryButton from "@/Components/Core/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Core/Button/DangerButton.vue";
import Modal from "@/Components/Core/Modals/Modal.vue";

const props = defineProps({
    show: Boolean,
    processing: Boolean,
    errors: Object,
});

const emit = defineEmits(['close', 'confirm']);

const password = ref('');

watch(() => props.show, (newVal) => {
    if (!newVal) password.value = '';
});

const handleConfirm = () => {
    emit('confirm', password.value);
};
</script>

<template>
    <Modal :show="props.show" @close="() => emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to delete this record?
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once a record is deleted, all of its resources and data will be inactive. <br>
                Please enter your password to confirm.
            </p>

            <div class="mt-6">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    v-model="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    @keydown.enter="handleConfirm"
                />
                <InputError :message="props.errors?.password" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="() => emit('close')">Cancel</SecondaryButton>
                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': props.processing }"
                    :disabled="props.processing"
                    @click="handleConfirm"
                >
                    Deactivate User
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
