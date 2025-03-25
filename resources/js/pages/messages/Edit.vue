<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type Child, type BreadcrumbItem, type Daycare, type Message } from '@/types';

import InputError from '@/components/InputError.vue';
import Select from '@/components/Select.vue';
import { Store, LoaderCircle } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare,
    child: Child,
    message: Message
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
        title: 'Editer un message',
        href: route('daycares.children.messages.edit', {daycare: props.daycare.id, child: props.child.id, message: props.message.id})
    },
];

const form = useForm({
    title: props.message.title,
    content: props.message.content,
    severity: props.message.severity,
    target: props.message.target,
});

const submit = () => {
    form.put(route('daycares.children.messages.update', {daycare: props.daycare.id, child: props.child.id, message: props.message.id}));
};

</script>

<template>
    <Head title="Edition d'un message" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Modifier un message à {{  props.child.first_name }}    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="title" class="font-semibold">Object</label>

                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Arrive tout les printemps."
                        v-model="form.title"
                        tabindex="1"
                    >
                    <InputError :message="form.errors.title" />
                </div>

                <div class="form-control space-y-2">
                    <label for="content" class="font-semibold">Contenu</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Arrive tout les printemps."
                        v-model="form.content"
                        tabindex="2"
                    ></textarea>
                    <InputError :message="form.errors.content" />
                </div>

                <div class="form-control space-y-2">
                    <label for="target" class="font-semibold">Cible</label>

                    <Select 
                        placeholder="Choisir une importance pour l'activité"
                        name="target" 
                        id="target" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.target"
                        tabindex="3"
                        :options="[
                            {value: 'all', label: 'Tout le monde'},
                            {value: 'daycare', label: 'Toute la crèche'},
                            {value: 'child', label: props.child.first_name + ' ' + props.child.last_name},
                        ]"
                    ></Select>
                    <InputError :message="form.errors.target" />
                </div>

                <div class="form-control space-y-2">
                    <label for="phone" class="font-semibold">Importance</label>

                    <Select 
                        placeholder="Choisir une importance pour l'activité"
                        name="severity" 
                        id="severity" 
                        class="w-full rounded-lg border border-gray-200" 
                        v-model="form.severity"
                        tabindex="4"
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
                    Modifier
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>