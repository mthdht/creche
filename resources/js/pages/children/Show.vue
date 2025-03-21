<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { calculateAge } from '@/lib/utils';
import ChildInfos from '@/components/ChildInfos.vue'
import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { Info, TriangleAlert, CircleAlert } from 'lucide-vue-next';
import Transmissions from '@/components/Transmissions.vue';

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
        title: props.child.first_name,
        href: route('daycares.children.show', {daycare: props.daycare.id, child: props.child.id}),
    },
];

const activeTab = ref('infos')

const relationshipMap = {
    father: 'Père',
    mother: 'Mère',
    guardian: 'tuteur',
    other: 'Autre',
    grandParent: 'grands parents'
}

const severityMap = {
    high: 'Elevé',
    medium: 'normal',
    low: 'basse'
}

const severityIcon = {
    high: TriangleAlert,
    medium: CircleAlert,
    low: Info
}

</script>

<template>
    <Head :title="`${props.child.last_name} ${props.child.first_name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <h2 class="font-semibold text-xl flex gap-3">
                <div class="avatar w-24 h-24 rounded-full overflow-hidden border-2" :class="[child.sexe == 'male' ? 'border-sky-500' : 'border-pink-500']">
                    <img :src="child.avatar || 'default-avatar.png'" alt="avatar de l'enfant" class="object-cover w-full h-full">
                </div>

                <div class="info text-center flex flex-col justify-between grow">
                    <div class="space-y-1">
                        <h3>
                            {{ props.child.first_name }} {{ props.child.last_name }}
                        </h3>
                        <p class="text-slate-500 text-sm">
                            {{ calculateAge(child.birth_date) }} |
                            <span :class="{ 'text-sky-500': child.sexe === 'male', 'text-pink-500': child.sexe === 'female' }">
                                {{ child.sexe == 'male' ? 'Garçon': 'Fille' }}
                            </span>
                        </p>
                    </div>
                    <p class="text-sm flex gap-1 justify-center">
                        <Link :href="route('daycares.children.edit', {daycare: props.daycare.id, child: props.child.id})">
                            Editer
                        </Link> 
                        
                        | 
                        
                        <Dialog>
                            <DialogTrigger>
                                Supprimer
                            </DialogTrigger>
                            <DialogContent>
                                <p>Êtes-vous sûr de vouloir supprimer cet enfant ?</p>
                                <div class="flex gap-2 justify-end">
                                    <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                    <Link 
                                        :href="route('daycares.children.destroy', {daycare: props.daycare.id, child: props.child.id})" 
                                        method="delete"
                                        class="bg-red-500 text-white px-3 py-2 rounded"
                                    >
                                        Supprimer
                                    </Link> 
                                </div>
                            </DialogContent>
                        </Dialog>
                    </p>
                </div>
            </h2>

            <!-- Tabs ou sections de contenu -->
            <section class="tabs flex gap-2 font-semibold">
                <button class="tab-btn border-2 p-1 rounded w-1/3 " 
                :class="{ 'bg-sky-500 text-white': activeTab === 'infos' }" @click="activeTab = 'infos'"
                >
                Infos 
                </button>

                <button class="tab-btn border-2 p-1 rounded w-1/3 " 
                :class="{ 'bg-sky-500 text-white': activeTab === 'transmissions' }" @click="activeTab = 'transmissions'"
                >
                Activités
                </button>
                <button class="tab-btn border-2 p-1 rounded w-1/3 " 
                :class="{ 'bg-sky-500 text-white': activeTab === 'messages' }" @click="activeTab = 'messages'"
                >
                Messages
                </button>
            </section>
                
            <Transition mode="out-in"
                enter-active-class="transition duration-200 ease-out"
                leave-active-class="transition duration-200 ease-in"
                enter-from-class="opacity-0 -translate-y-2"
                leave-to-class="opacity-0 translate-y-2"
            >
                
                <ChildInfos :daycare="props.daycare" :child="props.child" v-if="activeTab === 'infos'"></ChildInfos>
                
                <Transmissions :daycare="props.daycare" :child="props.child" v-else-if="activeTab === 'transmissions'"></Transmissions>
              
            </Transition>
        </div>
    </AppLayout>
</template>