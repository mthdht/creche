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
        <main class="grow md:p-4 h-screen ">
            <div class="h-full flex flex-col overflow-hidden shadow rounded-lg">
                <AppHeader :breadcrumbs="breadcrumbs" />
                <div class=" grow space-y-4 overflow-auto p-4 bg-white">
                    <slot />
                </div>
            </div>
        </main>
        <AppBottomNavigation class="md:hidden"></AppBottomNavigation>
    </AppShell>
</template>
