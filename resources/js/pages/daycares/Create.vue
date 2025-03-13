<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
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

            <form action="" method="post">
                <div class="space-y-3">
                    <div class="form-control">
                        <label for="name" class="font-semibold">Nom de la crèche</label>
                        <input type="text" name="name" id="name" class="w-full rounded-lg border border-gray-200 p-2" placeholder="Crèche Patronille">
                    </div>
                    <div class="form-control">
                        <label for="address" class="font-semibold">Adresse</label>
                        <input type="text" name="address" id="address" class="w-full rounded-lg border border-gray-200 p-2" placeholder="7 rue Roger Salengro, 59110 La madeleine">
                    </div>
                    <div class="form-control">
                        <label for="phone" class="font-semibold">Téléphone</label>
                        <input type="text" name="phone" id="phone" class="w-full rounded-lg border border-gray-200 p-2" placeholder="07 12 34 56 78">
                    </div>
                    <div class="form-control">
                        <label for="email" class="font-semibold">Email</label>
                        <input type="email" name="email" id="email" class="w-full rounded-lg border border-gray-200 p-2" placeholder="creche@exemple.com">
                    </div>
                </div>
            </form>
            
        </div>
    </AppLayout>
</template>