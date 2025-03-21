<script setup>
import { toRefs, computed } from 'vue'

const props = defineProps({
    size: {
        type: String,
        default: 'base',
        validator(value) {
            return ['sm', 'base', 'lg'].includes(value)
        },
    },
    squared: {
        type: Boolean,
        default: false,
    },
    pill: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    srText: {
        type: String || undefined,
        default: undefined,
    }
})

const emit = defineEmits(['click'])

const { size, squared, pill, href, srText} = props

const { disabled } = toRefs(props)

const baseClasses = [
    'inline-flex items-center transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none',
]

const classes = computed(() => [
    ...baseClasses,
    {
        'p-1.5': size == 'sm',
        'p-2': size == 'base',
        'p-3': size == 'lg',
    },
    'bg-transparent text-gray-500 hover:bg-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-gray-200',
    {
        'rounded-md': !squared && !pill,
        'rounded-full': pill,
    },
    {
        'pointer-events-none opacity-50': href && disabled.value,
    },
])

const iconSizeClasses = [
    {
        'w-5 h-5': size == 'sm',
        'w-6 h-6': size == 'base',
        'w-7 h-7': size == 'lg',
    },
]

const handleClick = (e) => {
    if (disabled.value) {
        e.preventDefault()
        e.stopPropagation()
        return
    }
    emit('click', e)
}

</script>

<template>
    <button
        :class="classes"
        @click="handleClick"
        :disabled="disabled"
    >
        <span
            v-if="srText"
            class="sr-only"
        >
            {{ srText }}
        </span>

        <slot :iconSizeClasses="iconSizeClasses" />
    </button>
</template>
