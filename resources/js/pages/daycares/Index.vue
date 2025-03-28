<script setup lang="ts">
import { reactive, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare } from '@/types';

import { Baby, Plus, Search, Store } from 'lucide-vue-next';

const props = defineProps<{
    daycares: Daycare[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crèches',
        href: '/daycares',
    },
];

const filters = reactive({
    search: '',
    sort: ''
});

const filteredDaycares = computed(() => {
    return props.daycares
        .filter(daycare => daycare.name.toLowerCase().includes(filters.search.toLowerCase()))
})
</script>

<template>
    <Head title="Mes Crèches" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between">
                <div class="flex gap-3 items-center">
                    <Store class="size-7 text-indigo-500"></Store>
                    Gerer les crèches !
                </div>
                <Link :href="route('daycares.create')" class="bg-emerald-500 p-1 rounded shadow active:bg-emerald-600 transition-colors">
                    <Plus class="size-7 text-white"></Plus>
                </Link>
            </h2>


            <div class="space-y-3">
                <div class="search relative">
                    <Search class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></Search>
                    <input 
                        type="text" 
                        class="w-full rounded-lg border border-gray-200 p-2 pl-10 bg-white" 
                        placeholder="Rechercher une crèche"
                        v-model="filters.search">
                </div>
            </div>

            <!--<section class="filters flex justify-between gap-2">
                <Select v-model="filters.creche" 
                    :options="[{label: 'Toutes crèches', value: null}, {label: 'Creche 1', value: 'creche 1'}, {label: 'Creche 2', value: 'creche 2'}]" 
                    class="w-1/2 bg-white"
                    placeholder="Trier par crèche"
                ></Select>

                <Select v-model="filters.sort" 
                    :options="[{label: 'Aucun tri', value: null}, {label: 'Nom', value: 'name'}, {label: 'Sexe', value: 'sexe'}]" 
                    placeholder="Trier par" class="w-1/2 bg-white"
                ></Select>
            </section> -->

            <section class="daycares space-y-3" >
                <template v-if="filteredDaycares.length === 0">
                    <p class="text-center text-gray-500">Aucune crèche trouvée</p>
                </template>

                <Link v-else
                    :href="route('daycares.show', {id: daycare.id})" 
                    class="block daycare border shadow-sm p-4 relative rounded space-y-2 bg-white" 
                    v-for="(daycare, index) in filteredDaycares"
                    :key="index"
                >
                    <p class="font-semibold">
                        {{  daycare.name }}
                    </p>
                    <p class="text-sm">{{ daycare.address }}</p>
                    <p class="flex gap-2 items-center"><Baby class="size-6"></Baby>{{ daycare.children_count }} enfants</p>
                </Link href="daycares/">
            </section>
        </div>
    </AppLayout>
</template>