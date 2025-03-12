<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Baby, Search, Store, UserPlus } from 'lucide-vue-next';
import { reactive, computed } from 'vue';
import Select from '@/components/Select.vue';

const props = defineProps<{
    daycare: Daycare;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daycares',
        href: '/daycares',
    },
    {
        title: props.daycare.name,
        href: '/daycares/' + props.daycare.id,
    },
];



const filters = reactive({
    search: '',
    sort: '',
});

const filteredChildren = computed(() => {
    console.log(props.daycare.children.filter(child => child.first_name.toLowerCase().includes(filters.search.toLowerCase())))
    return props.daycare.children.filter(child => child.first_name.toLowerCase().includes(filters.search.toLowerCase()))
})
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4 bg-slate-50 h-full">
            <h2 class="font-semibold text-xl flex justify-between">
                <div class="flex gap-3 items-center">
                    <Store class="size-7 text-indigo-500"></Store>
                    {{ props.daycare.name}} !
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
                        placeholder="Rechercher un enfant"
                        v-model="filters.search">
                </div>
            </div>

            <section class="filters flex justify-between gap-2">
                <Select v-model="filters.sort" 
                    :options="[{label: 'Aucun tri', value: null}, {label: 'Nom', value: 'first_name'}, {label: 'Sexe', value: 'sexe'}]" 
                    placeholder="Trier par" class="w-1/2 bg-white"
                ></Select>
            </section>

            <section class="daycares grid grid-cols-3 gap-2" >
                <Link 
                    class="child aspect-square border shadow flex flex-col justify-between items-center p-2 relative rounded" 
                    v-for="(child, index) in filteredChildren"
                    :href="'children/' + child.id"
                >
                    <div class="badge absolute top-2 left-2 size-4 rounded-full"
                        :class="[child.sexe == 'male' ? 'bg-sky-500' : 'bg-pink-500']"></div>
                    
                    <div class="avatar self-center size-16 rounded-full border overflow-hidden">
                        <img :src="child.avatar || 'ok'" alt="" class="size-full object-cover">
                    </div>
                    
                    <span class="font-semibold">{{  child.first_name }}</span>
                </Link>
            </section>


            {{  filters }}
        </div>
    </AppLayout>
</template>