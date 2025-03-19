<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare } from '@/types';

import InputError from '@/components/InputError.vue';
import Select from '@/components/Select.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child
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
        title: 'Ajouter un traitement',
        href: route('daycares.children.additionalNotes.create', {daycare: props.daycare.id, child: props.child.id})
    },
];

const form = useForm({
    note: '',
    severity: ''
});

const submit = () => {
    form.post(route('daycares.children.additionalNotes.store', {daycare: props.daycare.id, child: props.child.id}));
};

</script>

<template>
    <Head title="Création d'une note" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Ajouter une note à {{  props.child.first_name }}    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="note" class="font-semibold">Note</label>
                    <input 
                        type="text" 
                        name="note" 
                        id="note" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Ne pas reveiller Oscar avant 16h"
                        v-model="form.note"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.note" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Importance</label>

                    <Select 
                        placeholder="Choisir une importance pour la note"
                        name="severity" 
                        id="severity" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.severity"
                        tabindex="5"
                        required
                        :options="[
                            {value: 'high', label: 'Elevé'},
                            {value: 'medium', label: 'Normal'},
                            {value: 'low', label: 'Basse'},
                        ]"
                    ></Select>
                    <InputError :message="form.errors.severity" />
                </div>

                <Button type="submit" class="mt-4 self-center" :tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Créer une note
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>