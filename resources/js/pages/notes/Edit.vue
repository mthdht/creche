<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare, type Illness, AdditionalNote } from '@/types';

import InputError from '@/components/InputError.vue';
import Select from '@/components/Select.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child,
    additional_note: AdditionalNote
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
        title: 'Editer une note',
        href: route('daycares.children.additionalNotes.edit', {daycare: props.daycare.id, child: props.child.id, additionalNote: props.additional_note})
    },
];

const form = useForm({
    note: props.additional_note.note,
    severity: props.additional_note.severity,
});

const submit = () => {
    form.put(route('daycares.children.additionalNotes.update', {daycare: props.daycare.id, child: props.child.id, additionalNote: props.additional_note.id}));
};

</script>

<template>
    <Head title="Modification d'une note" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Modifier la note   
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="note" class="font-semibold">note</label>
                    <input 
                        type="text" 
                        name="note" 
                        id="note" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Asthme"
                        v-model="form.note"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.note" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Importance</label>

                    <Select 
                        placeholder="Choisir une importance"
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
                    Modifier la note
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>