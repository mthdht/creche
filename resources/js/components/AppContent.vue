<script setup lang="ts">
import { SidebarInset } from '@/components/ui/sidebar';
import { computed } from 'vue';

interface Props {
    variant?: 'header' | 'sidebar';
    class?: string;
}

const props = defineProps<Props>();
const className = computed(() => props.class);
</script>

<template>
    <SidebarInset v-if="props.variant === 'sidebar'" :class="className" class="overflow-hidden">
        <slot />
    </SidebarInset>
    <main v-else class="mx-auto max-w-7xl pb-20 grow w-full md:m-4 bg-white rounded-lg shadow " :class="className">
        <slot />
    </main>
</template>
