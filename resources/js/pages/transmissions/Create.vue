<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare } from '@/types';

import InputError from '@/components/InputError.vue';
import Select from '@/components/Select.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare,
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
        title: 'Ajouter une activité',
        href: route('daycares.children.transmissions.create', {daycare: props.daycare.id, child: props.child.id})
    },
];

const form = useForm({
    type: '',
    description: '',
    severity: '',
    duration: '',
    datetime: ''
});

const submit = () => {
    form.datetime = form.datetime.replace('T', ' ') + ':00'
    form.post(route('daycares.children.transmissions.store', {daycare: props.daycare.id, child: props.child.id}));
};

</script>

<template>
    <Head title="Création d'une activité" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Ajouter une activité à {{  props.child.first_name }}    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Type d'activité</label>

                    <Select 
                        placeholder="Choisir un type d'activité"
                        name="type" 
                        id="type" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.type"
                        tabindex="5"
                        required
                        :options="[
                            {value: 'sieste', label: 'Sieste'},
                            {value: 'repas', label: 'Repas'},
                            {value: 'hygiene', label: 'Hygiène'},
                        ]"
                    ></Select>
                    <InputError :message="form.errors.type" />
                </div>

                <div class="form-control space-y-2">
                    <label for="description" class="font-semibold">Description</label>
                    <input 
                        type="text" 
                        name="description" 
                        id="description" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Arrive tout les printemps."
                        v-model="form.description"
                        tabindex="1"
                    >
                    <InputError :message="form.errors.description" />
                </div>

                <div class="form-control space-y-2">
                    <label for="datetime" class="font-semibold">Date et heure de l'activité</label>
                    <input 
                        type="datetime-local" 
                        name="datetime" 
                        id="datetime" 
                        class="w-full rounded-lg border border-gray-200 p-2"
                        v-model="form.datetime"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.datetime" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Importance</label>

                    <Select 
                        placeholder="Choisir une importance pour l'activité"
                        name="severity" 
                        id="severity" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.severity"
                        tabindex="5"
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
                    Créer une allergie
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>