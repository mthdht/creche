<template>
    <div class="bottom-navigation fixed bottom-0 bg-white z-50 w-full border-t border-gray-200 flex">
        <Link href="/dashboard" class="flex-1 flex flex-col items-center justify-center p-2">
            <House class="w-6 h-6" />
            Home
        </Link>
        <Link href="/dashboard" class="flex-1 flex flex-col items-center justify-center p-2">
            <House class="w-6 h-6" />
            Crèches
        </Link>
        <Link href="/dashboard" class="flex-1 flex flex-col items-center justify-center p-2">
            <House class="w-6 h-6" />
            Enfants
        </Link>
        <slot></slot>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { House } from 'lucide-vue-next'
</script>