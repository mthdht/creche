<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Store, } from 'lucide-vue-next';
import { reactive, computed } from 'vue';
import Select from '@/components/Select.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daycares',
        href: '/daycares',
    },
    {
        title: 'Créer une crèche',
        href: '/daycares/create'
    },
];

const form = useForm({
    name: '',
    address: '',
    email: '',
    phone: '',
});

const submit = () => {
    form.post(route('daycares.store'))
};

</script>

<template>
    <Head title="Création d'une crèche" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between gap-3">
                <div class="flex gap-3">
                    <Store class="size-8 text-indigo-500"></Store>
                    Création d'une crèche    
                </div>
            </h2>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="form-control space-y-2">
                    <label for="name" class="font-semibold">Nom de la crèche</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="Crèche Patronille"
                        v-model="form.name"
                        required
                        tabindex="1"
                    >
                    <InputError :message="form.errors.name" />
                </div>

                <div class="form-control space-y-2">
                    <label for="address" class="font-semibold">Adresse</label>
                    <input 
                        type="text" 
                        name="address" 
                        id="address" 
                        class="w-full rounded-lg border border-gray-200 p-2" 
                        placeholder="123 rue des fleurs"
                        v-model="form.address"
                        required
                        tabindex="2"
                    >
                    <InputError :message="form.errors.address" />
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
                        required
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
                        required
                        tabindex="4"
                    >
                    <InputError :message="form.errors.phone" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Créer la crèche
                </Button>
            </form>
            
        </div>
    </AppLayout>
</template>