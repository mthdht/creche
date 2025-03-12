<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4 bg-slate-50 h-full">
            <h2 class="font-semibold text-xl flex justify-between">
                <div class="flex gap-3 items-center">
                    <Store class="size-7 text-indigo-500"></Store>
                    Gerer les crèches !
                </div>
                <button class="bg-emerald-500 px-3 py-1 rounded shadow">
                    <UserPlus class="size-7 text-white"></UserPlus>
                </button>
            </h2>


            <div class="space-y-3">
                <div class="search relative">
                    <Search class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></Search>
                    <input 
                        type="text" 
                        class="w-full rounded border border-gray-200 p-2 pl-10" 
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
                <Link 
                    :href="'daycares/' + daycare.id" 
                    class="block daycare border shadow p-4 relative rounded space-y-2 bg-white" 
                    v-for="(daycare, index) in filteredDaycares"
                >
                    <p class="font-semibold">
                        {{  daycare.name }}
                    </p>
                    <p class="text-sm">{{ daycare.address }}</p>
                    <p class="flex gap-2 items-center"><Baby class="size-6"></Baby>{{ daycare.children_count }} enfants</p>
                </Link href="daycares/">
            </section>


            {{  filters }}
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Baby, Search, Store, UserPlus } from 'lucide-vue-next';
import { reactive, computed } from 'vue';
import Select from '@/components/Select.vue';

const props = defineProps<{
    daycares: Daycare[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];



const filters = reactive({
    search: '',
    sort: null,
});

const filteredDaycares = computed(() => {
    return props.daycares
        .filter(daycare => daycare.name.toLowerCase().includes(filters.search.toLowerCase()))
})
</script>