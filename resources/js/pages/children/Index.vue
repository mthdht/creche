<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, computed, ref } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';

import Select from '@/components/Select.vue';
import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Search, Store,  UserPlus } from 'lucide-vue-next';

const props = defineProps<{
    children: Child[],
    daycares: Daycare[]
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Enfants',
        href: '/children',
    },
];

const filters = reactive({
    search: '',
    sort: '',
});

const daycareSelectOptions = props.daycares.map(daycare => {
    return {label: daycare.name, value: daycare.id}
})

const selectedDaycare = ref()

const filteredChildren = computed(() => {
    return props.children
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
    <Head title="Tout les enfants" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                   Tout les enfants
                </div>

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
                    placeholder="Trier par" class="bg-white grow"
                ></Select>

                <Dialog class="">
                    <DialogTrigger class="p-2 text-white bg-emerald-500 rounded shadow">
                        <UserPlus class="size-6"></UserPlus>
                    </DialogTrigger>
                    <DialogContent>
                        <p>Pour quelle crèche voulez-vous ajouter un enfants ?</p>

                        <Select v-model="selectedDaycare" 
                            :options="daycareSelectOptions" 
                            class="bg-white grow"
                        ></Select>

                        <div class="flex gap-2 justify-end">
                            <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>

                            <button 
                                class="bg-emerald-500 text-white px-3 py-2 rounded"
                                @click="selectedDaycare && router.visit('/daycares/' + selectedDaycare + '/children/create')" 
                            >
                                Suivant
                            </button>
                        </div>
                    </DialogContent>
                </Dialog>
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
                        :href="route('daycares.children.show', {daycare: child.daycare_id, child: child.id})"
                        >
                        <div class="badge absolute top-2 left-2 size-4 rounded-full"
                        :class="[child.sexe == 'male' ? 'bg-sky-500' : 'bg-pink-500']">{{  child.sexe }}</div>
                        
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