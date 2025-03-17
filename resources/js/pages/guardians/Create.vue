<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { type Child, type BreadcrumbItem, type Daycare } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Store } from 'lucide-vue-next';
import Select from '@/components/Select.vue';

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
        title: 'Ajouter un tuteur',
        href: '/daycares/create'
    },
];

const form = useForm({
    last_name: '',
    first_name: '',
    email: '',
    address: '',
    phone: '',
    relationship: ''
});

const submit = () => {
    form.post(route('daycares.children.guardians.store', {daycare: props.daycare.id, child: props.child.id}));
};

</script>

<template>
    <Head title="Création d'une crèche" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Ajouter un tuteur à {{  props.child.first_name }}    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="last_name" class="font-semibold">Nom</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Crèche Patronille"
                        v-model="form.last_name"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.last_name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="first_name" class="font-semibold">Prénom</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="123 rue des fleurs"
                        v-model="form.first_name"
                        required
                        tabindex="2"
                    >
                    <InputError :message="form.errors.first_name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="email" class="font-semibold">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="patronille @gmail.com"
                        v-model="form.email"
                        tabindex="3"
                    >
                    <InputError :message="form.errors.email" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Téléphone</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="123-456-7890"
                        v-model="form.phone"
                        tabindex="4"
                        required
                    >
                    <InputError :message="form.errors.phone" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Relation avec {{ props.child.first_name }}</label>

                    <Select 
                        placeholder="Choisir une relation"
                        name="relationship" 
                        id="relationship" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.relationship"
                        tabindex="5"
                        required
                        :options="[
                            {value: 'mother', label: 'Mère'},
                            {value: 'father', label: 'Père'},
                            {value: 'grandparent', label: 'Grand parent'},
                            {value: 'legalGuardian', label: 'Tuteur légal'},
                            {value: 'other', label: 'Autre'},
                        ]"
                    ></Select>
                    <InputError :message="form.errors.relationship" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Créer le tuteur
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>