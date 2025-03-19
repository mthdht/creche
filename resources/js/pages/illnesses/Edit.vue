<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare, type Illness } from '@/types';

import InputError from '@/components/InputError.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child,
    illness: Illness
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crèches',
        href: '/daycares',
    },
    {
        title: props.daycare.name,
        href: route('daycares.show', {daycare: props.daycare.id}),
    },
    {
        title: props.child.first_name,
        href: route('daycares.children.show', {daycare: props.daycare.id, child: props.child.id}),
    },
    {
        title: 'Ajouter une maladie',
        href: route('daycares.children.illnesses.create', {daycare: props.daycare.id, child: props.child.id})
    },
];

const form = useForm({
    name: props.illness.name,
    description: props.illness.description,
    note: props.illness.note
});

const submit = () => {
    form.put(route('daycares.children.illnesses.update', {daycare: props.daycare.id, child: props.child.id, illness: props.illness.id}));
};

</script>

<template>
    <Head title="Modification d'une maladie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Modifier la maladie {{ props.illness.name }}    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="name" class="font-semibold">Nom de la maladie</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Asthme"
                        v-model="form.name"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="descripton" class="font-semibold">Description</label>
                    <input 
                        type="text" 
                        name="descripton" 
                        id="descripton" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Problème respiratoire"
                        v-model="form.description"
                        required
                        tabindex="2"
                    >
                    <InputError :message="form.errors.description" />
                </div>

                <div class="form-control space-y-2">
                    <label for="note" class="font-semibold">Note</label>
                    <input 
                        type="note" 
                        name="note" 
                        id="note" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Crise souvent le matin!"
                        v-model="form.note"
                        tabindex="3"
                    >
                    <InputError :message="form.errors.note" />
                </div>

                <Button type="submit" class="mt-4 self-center" :tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Modifier la maladie
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>