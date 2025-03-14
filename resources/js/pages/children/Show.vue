<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Baby, Locate, Pencil, Search, Store, Trash, UserPlus } from 'lucide-vue-next';
import { reactive, computed } from 'vue';
import Select from '@/components/Select.vue';
import { Dialog, DialogTrigger, DialogContent,  } from '@/components/ui/dialog';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';

const props = defineProps<{
    daycare: Daycare;
    child: Child;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daycares',
        href: '/daycares',
    },
    {
        title: props.daycare.name,
        href: route('daycares.show', {daycare: props.daycare.id}),
    },
    {
        title: 'Enfants',
        href: route('daycares.show', {daycare: props.daycare.id}),
    },
    {
        title: props.child.first_name,
        href: route('daycares.children.show', {daycare: props.daycare.id, child: props.child.id}),
    },
];
</script>

<template>
    <Head :title="`${props.child.last_name} ${props.child.first_name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Baby class="size-8 text-indigo-500"></Baby>
                    {{ props.child.first_name }} {{ props.child.last_name }}!
                </div>
                <div class="actions flex gap-2 items-start">
                    <Link :href="route('daycares.children.edit', {daycare: props.daycare.id, child: props.child.id})">
                        <Pencil class="size-8 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                    </Link>

                    
                    <Dialog>
                        <DialogTrigger>
                            <Trash class="size-8 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                        </DialogTrigger>
                        <DialogContent>
                            <p>Êtes-vous sûr de vouloir supprimer cet enfant ?</p>
                            <div class="flex gap-2 justify-end">
                                <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                <Link 
                                    :href="route('daycares.children.destroy', {daycare: props.daycare.id, child: props.child.id})" 
                                    method="delete"
                                    class="bg-red-500 text-white px-3 py-2 rounded"
                                >
                                    Supprimer
                                </Link> 
                            </div>
                        </DialogContent>
                    </Dialog>
                </div>

            </h2>

            <div class=" p-4 border shadow-sm rounded bg-white space-y-4 font-semibold">
                
            </div>
        </div>
    </AppLayout>
</template>