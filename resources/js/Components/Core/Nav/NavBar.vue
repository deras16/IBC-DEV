<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import Dropdown from "@/Components/Core/Nav/Dropdown.vue";
import NavLink from "@/Components/Core/Nav/NavLink.vue";
import DropdownLink from "@/Components/Core/Nav/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/Core/Nav/ResponsiveNavLink.vue";
import ApplicationLogo from "@/Components/Core/ApplicationLogo.vue";
import ToggleDark from "@/Components/Core/ToggleDark.vue";
import { usePermissions } from '@/Composables/usePermissions';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav
        class="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800"
    >
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                    >
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </NavLink>
                        <div v-if="usePermissions().hasPermission('view users') || usePermissions().hasPermission('view roles')"
                             class="inline-flex items-center  border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {{ route().current('users.index') ? 'Users' : (route().current('roles.index') ? 'Roles' : 'Operations') }}
                                                    <svg
                                                        class="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                </template>

                                <template #content>
                                    <DropdownLink  v-if="usePermissions().hasPermission('view users')" :href="route('users.index')" :active="route().current('users.index')">
                                        Users
                                    </DropdownLink>
                                    <DropdownLink v-if="usePermissions().hasPermission('view roles')" :href="route('roles.index')" :active="route().current('roles.index')">
                                        Roles
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                        <NavLink
                            v-if="usePermissions().hasPermission('view case studies')"
                            :href="route('case-studies.index')"
                            :active="route().current('case-studies.index')"
                        >
                            Case Studies
                        </NavLink>
                        <NavLink
                            v-if="usePermissions().hasPermission('view marketing case studies')"
                            :href="route('marketing-case-studies.index')"
                            :active="route().current('marketing-case-studies.index')"
                        >
                            Marketing Case Studies
                        </NavLink>
                    </div>
                </div>

                <div class="hidden sm:ms-6 sm:flex sm:items-center">
                    <div>
                        <ToggleDark />
                    </div>
                    <!-- Settings Dropdown -->
                    <div class="relative ms-3">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                            </template>

                            <template #content>
                                <DropdownLink
                                    :href="route('profile.edit')"
                                >
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
            class="sm:hidden"
        >
            <div class="space-y-1 pb-3 pt-2">
                <ResponsiveNavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    Dashboard
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    v-if="usePermissions().hasPermission('view users')"
                    :href="route('users.index')"
                    :active="route().current('users.index')"
                >
                    Users
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    v-if="usePermissions().hasPermission('view roles')"
                    :href="route('roles.index')"
                    :active="route().current('roles.index')"
                >
                    Roles
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    v-if="usePermissions().hasPermission('view case studies')"
                    :href="route('case-studies.index')"
                    :active="route().current('case-studies.index')"
                >
                    Case Studies
                </ResponsiveNavLink>
                <ResponsiveNavLink
                    v-if="usePermissions().hasPermission('view marketing case studies')"
                    :href="route('marketing-case-studies.index')"
                    :active="route().current('marketing-case-studies.index')"
                >
                    Marketing Case Studies
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div
                class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600"
            >
                <div class="px-4">
                    <div
                        class="text-base font-medium text-gray-800 dark:text-gray-200"
                    >
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="text-sm font-medium text-gray-500">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
