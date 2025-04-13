import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
    const permissions = computed(() => usePage().props.auth.user_permissions || []);

    const hasPermission = (permissionName) => {
        return permissions.value.includes(permissionName);
    };

    return {
        hasPermission,
    };
}
