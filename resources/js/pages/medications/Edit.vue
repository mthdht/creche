<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare, type Medication } from '@/types';

import InputError from '@/components/InputError.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child
    medication: Medication
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
        title: 'Modifier un traitement',
        href: route('daycares.children.medications.update', {daycare: props.daycare.id, child: props.child.id, medication: props.medication.id})
    },
];

const form = useForm({
    name: props.medication.name,
    note: props.medication.dosage,
    dosage: props.medication.note
});

const submit = () => {
    form.put(route('daycares.children.medications.update', {daycare: props.daycare.id, child: props.child.id, medication: props.medication.id}));
};

</script>

<template>
    <Head title="Modification d'un traitement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Modifier le traitement    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="name" class="font-semibold">Nom du traitement</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Doliprane"
                        v-model="form.name"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="dosage" class="font-semibold">dosage</label>
                    <input 
                        type="text" 
                        name="dosage" 
                        id="dosage" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="50ml tout les 6h (max 4x/J)"
                        v-model="form.dosage"
                        required
                        tabindex="2"
                    >
                    <InputError :message="form.errors.dosage" />
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
                    Modifier un traitement
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>