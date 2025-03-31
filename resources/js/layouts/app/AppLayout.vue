<script setup lang="ts">
import AppBottomNavigation from '@/components/AppBottomNavigation.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';

import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell>
        <AppSidebar />
        <main class="grow md:p-4 h-screen overflow-hidden">
            <div class="h-full flex flex-col max-w-full overflow-hidden shadow rounded-lg pb-16 lg:p-0">
                <AppHeader :breadcrumbs="breadcrumbs" />
                <div class="grow overflow-auto p-4 bg-white">
                    <slot />
                </div>
            </div>
        </main>
        <AppBottomNavigation class="md:hidden"></AppBottomNavigation>
    </AppShell>
</template>
