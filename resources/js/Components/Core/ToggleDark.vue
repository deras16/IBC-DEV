<script setup>
import {isDark, toggleDarkMode} from "@/Composables/index.js";
import IconButton from "@/Components/Core/Button/IconButton.vue";
import {MoonIcon, SunIcon} from "@/Components/Core/Icons/BaseIcons.jsx";
</script>

<template>
    <IconButton
        @click="() => { toggleDarkMode() }"
        v-slot="{ iconSizeClasses }"
        class="p-2 hidden md:inline-flex"
        srText="Toggle dark mode"
    >
        <MoonIcon
            v-show="!isDark"
            aria-hidden="true"
            :class="iconSizeClasses"
        />
        <SunIcon
            v-show="isDark"
            aria-hidden="true"
            :class="iconSizeClasses"
        />
    </IconButton>
</template>
