<template>
    <div class="bottom-navigation fixed bottom-0 bg-white z-50 w-full border-t border-gray-200 flex">
        <Link href="/dashboard" 
            class="flex-1 px-3"
            >
            <button class="flex flex-col items-center justify-center p-2 pb-1 w-full" :class="{ 'border-t-2 border-sky-500': $page.url === '/dashboard' }">
                <House class="size-7" />
                Home
            </button>
        </Link>

        <Link href="/children" 
            class="flex-1 px-3"
            >
            <button class="flex flex-col items-center justify-center p-2 pb-1 w-full" :class="{ 'border-t-2 border-sky-500': $page.url === '/children' }">
                <Baby class="size-7" />
                Enfants
            </button>
        </Link>

        <Link href="/daycares" 
            class="flex-1 px-3"
            >
            <button class="flex flex-col items-center justify-center p-2 pb-1 w-full" :class="{ 'border-t-2 border-sky-500': $page.url === '/daycares' }">
                <Store class="size-7" />
                Crèches
            </button>
        </Link>

        <Link href="/settings" 
            class="flex-1 px-3"
            >
            <button class="flex flex-col items-center justify-center p-2 pb-1 w-full" :class="{ 'border-t-2 border-sky-500': $page.url === '/settings' }">
                <Settings class="size-7" />
                Réglages
            </button>
        </Link>
        
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Baby, House, Settings, Store } from 'lucide-vue-next'
</script>