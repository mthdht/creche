<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Store, } from 'lucide-vue-next';
import Select from '@/components/Select.vue';


const props = defineProps<{
    daycare: Daycare;
    child: Child;
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
        title: 'Enfants',
        href: route('daycares.show', {daycare: props.daycare.id}),
    },
    {
        title: 'Editer',
        href: route('daycares.children.create', {daycare: props.daycare.id}),
    },
    
];

const form = useForm({
    first_name: props.child.first_name,
    last_name: props.child.last_name,
    sexe: props.child.sexe,
    birth_date: props.child.birth_date,
});

const submit = () => {
    form.put(route('daycares.children.update', {daycare: props.daycare.id, child: props.child.id}))
};

</script>

<template>
    <Head title="Edition d'un enfant" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Editer un enfant    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="first_name" class="font-semibold">Prénom</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Oscar"
                        v-model="form.first_name"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.first_name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="last_name" class="font-semibold">Nom</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Dehondt"
                        v-model="form.last_name"
                        required
                        tabindex="2"
                    >
                    <InputError :message="form.errors.last_name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="birth_date" class="font-semibold">Date de naissance</label>
                    <input 
                        type="date" 
                        name="birth_date" 
                        id="birth_date" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="patronille @gmail.com"
                        v-model="form.birth_date"
                        tabindex="3"
                    >
                    <InputError :message="form.errors.birth_date" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Sexe</label>
                    <Select 
                        placeholder="Sélectionner le sexe"
                        v-model="form.sexe" 
                        :options="[
                            { value: 'male', label: 'Masculin' },
                            { value: 'female', label: 'Féminin' },
                        ]"
                        tabindex="4"
                    />
                    <InputError :message="form.errors.sexe" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Modifier
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>