<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Baby, Locate, Pencil, Search, Store, Trash, UserPlus } from 'lucide-vue-next';
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
    return props.daycare.children
        .filter(child => child.first_name.toLowerCase().includes(filters.search.toLowerCase()))
        .sort((a, b) => {
            if (filters.sort === 'first_name') {
                return a.first_name.localeCompare(b.first_name);
            }

            if (filters.sort === 'sexe') {
                return a.sexe.localeCompare(b.sexe);
            }
            return 0;
        })
});

</script>

<template>
    <Head :title="props.daycare.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    {{ props.daycare.name}} !
                </div>
                <div class="actions flex gap-2 items-start">
                    <Link :href="route('daycares.edit', {daycare: props.daycare.id})">
                        <Pencil class="size-8 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                    </Link>

                    <Link :href="route('daycares.destroy', {daycare: props.daycare.id})" method="delete">
                        <Trash class="size-8 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                    </Link>
                </div>

            </h2>

            <div class=" p-4 border shadow-sm rounded bg-white space-y-4 font-semibold">
                <p class="flex gap-4">
                    <Locate class="size-8 shrink-0"></Locate>
                    {{ props.daycare.address }}
                </p>
            
                <p class="flex gap-4 items-center">
                    <Baby class="size-8 shrink-0"></Baby>
                    {{ props.daycare.children.length }} enfants
                </p>
            </div>

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
                    placeholder="Trier par" class="bg-white grow"
                ></Select>

                <button class="bg-emerald-500 px-3 py-1 rounded shadow">
                    <UserPlus class="size-7 text-white"></UserPlus>
                </button>
            </section>

            <section class="daycares" >
                <template v-if="filteredChildren.length === 0">
                    <p class="text-center text-gray-500">Aucune enfant trouvée</p>
                </template>

                <div class="grid grid-cols-3 gap-2">
                    <Link 
                        class="child aspect-square border shadow flex flex-col justify-between items-center p-2 relative rounded" 
                        v-for="(child, index) in filteredChildren"
                        :key="child.id"
                        :href="route('daycares.children.show', {daycare: daycare.id, child: child.id})"
                        >
                        <div class="badge absolute top-2 left-2 size-4 rounded-full"
                        :class="[child.sexe == 'male' ? 'bg-sky-500' : 'bg-pink-500']"></div>
                        
                        <div class="avatar self-center size-16 rounded-full border overflow-hidden">
                            <img :src="child.avatar || 'ok'" alt="" class="size-full object-cover">
                        </div>
                        
                        <span class="font-semibold">{{  child.first_name }}</span>
                    </Link>
                </div>
            </section>
        </div>
    </AppLayout>
</template>