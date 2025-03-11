<script setup>
import { onMounted, ref, defineEmits, defineProps } from 'vue';

const props = defineProps({
    options: Array,
    modelValue: [String, Number]
});

const emit = defineEmits(['update:modelValue']);
const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
        id="dynamic_select"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
        :value="modelValue"
        @change="emit('update:modelValue', $event.target.value)"
        ref="select"
        required
    >
        <option v-for="option in options" :value="option" :key="option">
            {{ option }}
        </option>
    </select>
</template>
