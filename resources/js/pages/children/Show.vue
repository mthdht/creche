<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child, type Health } from '@/types';
import { calculateAge } from '@/lib/utils';

import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Collapsible, CollapsibleContent, CollapsibleTrigger} from '@/components/ui/collapsible';
import { ChevronDown, Trash, Pencil, Info, EllipsisVertical } from 'lucide-vue-next';

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

const relationship = (relation: any) => {
    switch (relation) {
        case 'father':
            return 'Père';
        case 'mother':
            return 'Mère';
        case 'guardian':
            return 'Tuteur';
        case 'other':
            return 'Autre';
        default:
            return 'Autre';
    }
}

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
                :class="{ 'bg-sky-500 text-white': activeTab === 'activities' }" @click="activeTab = 'activities'"
                >
                Activités
                </button>
                <button class="tab-btn border-2 p-1 rounded w-1/3 " 
                :class="{ 'bg-sky-500 text-white': activeTab === 'messages' }" @click="activeTab = 'messages'"
                >
                Messages
                </button>
            </section>

            <!--
                <pre>
                    
                    {{  props.child }}
                </pre>
                -->

            <Transition mode="out-in"
                enter-active-class="transition duration-200 ease-out"
                leave-active-class="transition duration-200 ease-in"
                enter-from-class="opacity-0 -translate-y-2"
                leave-to-class="opacity-0 translate-y-2"
            >
                <section v-if="activeTab === 'infos'" class="space-y-4">
                    <Collapsible class="rounded">
                        <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                            <span>Parents</span>
                            <ChevronDown class="w-6 h-6"></ChevronDown>
                        </CollapsibleTrigger>

                        <CollapsibleContent class="flex flex-col data-[state=open]:border">
                            <div class="text-center py-4" v-if="child.guardians.length == 0">
                                Aucun tuteur enregistré !
                            </div>
                            
                            <div class="guardians px-4 mt-4" v-else v-for="guardian in child.guardians" :key="guardian.id">
                                <div class="p-4 rounded border">
                                    <p class="flex justify-between items-center">
                                        {{ guardian.name }}
                                        <div class="flex gap-2 items-center">
                                            <span class="border px-2 py-1 rounded-full">{{ relationshipMap[guardian.profile.relationship] }}</span>
                                            <DropdownMenu>
                                                <DropdownMenuTrigger>
                                                    <EllipsisVertical class="size-6"></EllipsisVertical>
                                                </DropdownMenuTrigger>

                                                <DropdownMenuContent align="end" class="mt-2">
                                                    <DropdownMenuItem>
                                                        <Link 
                                                            :href="route('daycares.children.guardians.edit', {daycare: props.daycare.id, child: props.child.id, guardian: guardian.id})"
                                                            class="flex items-center gap-2 justify-between w-full"
                                                            >
                                                            Editer
                                                            <Pencil class="size-6 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                                                        </Link>
                                                    </DropdownMenuItem>

                                                    <Dialog class="">
                                                        <DialogTrigger class="flex justify-between w-full px-2 py-1.5 text-sm hover:bg-slate-100">
                                                            Supprimer
                                                            <Trash class="size-6 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                                                        </DialogTrigger>
                                                        <DialogContent>
                                                            <p>Êtes-vous sûr de vouloir supprimer ce tuteur ?</p>
                                                            <div class="flex gap-2 justify-end">
                                                                <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                                                <Link 
                                                                    :href="route('daycares.children.guardians.destroy', {daycare: props.daycare.id, child: props.child.id, guardian: guardian.id})" 
                                                                    method="delete"
                                                                    class="bg-red-500 text-white px-3 py-2 rounded"
                                                                >
                                                                    Supprimer
                                                                </Link> 
                                                            </div>
                                                        </DialogContent>
                                                    </Dialog>
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </div>

                                    </p>
                                    
                                    <p class="text-sm">
                                        <span class="font-semibold">Email: </span> 
                                        <span>{{ guardian.email }}</span>
                                    </p>

                                    <p class="text-sm">
                                        <span class="font-semibold">Tél: </span> 
                                        <span>{{ guardian.profile.phone || 'Non renseigné' }}</span>
                                    </p>

                                </div>
                            </div>

                            <Link 
                                :href="route('daycares.children.guardians.create', {daycare: props.daycare.id, child: props.child.id})" 
                                class="border rounded px-3 py-2 self-center my-4"
                            >
                                Ajouter un tuteur
                            </Link>
                        </CollapsibleContent>
                    </Collapsible>

                    <Collapsible class="rounded ">
                        <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                            <span>Maladies</span>
                            <ChevronDown class="w-6 h-6"></ChevronDown>
                        </CollapsibleTrigger>

                        <CollapsibleContent class="flex flex-col data-[state=open]:border">
                            <div class="text-center py-4" v-if="child.health.illnesses.length == 0">
                                Aucune maladies enregistré !
                            </div>

                            
                            <div class="guardians px-4 mt-4" v-else v-for="illness in child.health.illnesses" :key="illness.id">
                                <div class="p-4 rounded border">
                                    <p class="flex justify-between items-center">
                                        {{ illness.name }}
                                        <DropdownMenu>
                                                <DropdownMenuTrigger>
                                                    <EllipsisVertical class="size-6"></EllipsisVertical>
                                                </DropdownMenuTrigger>

                                                <DropdownMenuContent align="end" class="mt-2">
                                                    <DropdownMenuItem>
                                                        <Link 
                                                            :href="route('daycares.children.illnesses.edit', {daycare: props.daycare.id, child: props.child.id, illness: illness.id})"
                                                            class="flex items-center gap-2 justify-between w-full"
                                                            >
                                                            Editer
                                                            <Pencil class="size-6 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                                                        </Link>
                                                    </DropdownMenuItem>

                                                    <Dialog class="">
                                                        <DialogTrigger class="flex justify-between w-full px-2 py-1.5 text-sm hover:bg-slate-100">
                                                            Supprimer
                                                            <Trash class="size-6 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                                                        </DialogTrigger>
                                                        <DialogContent>
                                                            <p>Êtes-vous sûr de vouloir supprimer cette maladie ?</p>
                                                            <div class="flex gap-2 justify-end">
                                                                <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                                                <Link 
                                                                    :href="route('daycares.children.illnesses.destroy', {daycare: props.daycare.id, child: props.child.id, illness: illness.id})" 
                                                                    method="delete"
                                                                    class="bg-red-500 text-white px-3 py-2 rounded"
                                                                >
                                                                    Supprimer
                                                                </Link> 
                                                            </div>
                                                        </DialogContent>
                                                    </Dialog>
                                                </DropdownMenuContent>
                                        </DropdownMenu>
                                    </p>
                                    
                                    <p class="text-sm mt-2"> 
                                        {{ illness.description }}
                                    </p>

                                    <p class="text-sm flex items-center gap-4 mt-3" v-if="illness.note">
                                        <Info class="size-6"></Info>
                                        <span>{{ illness.note}}</span>
                                    </p>
                                </div>
                            </div>

                            <Link 
                                :href="route('daycares.children.illnesses.create', {daycare: props.daycare.id, child: props.child.id})" 
                                class="border rounded px-3 py-2 self-center my-4"
                            >
                                Ajouter une maladie
                            </Link>
                        </CollapsibleContent>
                    </Collapsible>
                    

                    <Collapsible class="rounded ">
                        <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                            <span>Allergies</span>
                            <ChevronDown class="w-6 h-6"></ChevronDown>
                        </CollapsibleTrigger>

                        <CollapsibleContent class="flex flex-col data-[state=open]:border">
                            <div class="text-center py-4" v-if="child.health.allergies.length == 0">
                                Aucune maladies enregistré !
                            </div>

                            <div class="guardians px-4 mt-4" v-else v-for="allergy in child.health.allergies" :key="allergy.id">
                                <div class="p-4 rounded border">
                                    <p class="flex justify-between items-center">
                                        {{ allergy.name }}
                                        <div class="flex gap-2 items-center">
                                            <span class="border px-3 py-1 rounded-full text-sm">{{ severityMap[allergy.severity] }}</span>

                                            <DropdownMenu>
                                                <DropdownMenuTrigger>
                                                    <EllipsisVertical class="size-6"></EllipsisVertical>
                                                </DropdownMenuTrigger>
                                                
                                                <DropdownMenuContent align="end" class="mt-2">
                                                    <DropdownMenuItem>
                                                        <Link 
                                                        :href="route('daycares.children.allergies.edit', {daycare: props.daycare.id, child: props.child.id, allergy: allergy.id})"
                                                        class="flex items-center gap-2 justify-between w-full"
                                                        >
                                                        Editer
                                                        <Pencil class="size-6 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                                                    </Link>
                                                </DropdownMenuItem>
                                                
                                                <Dialog class="">
                                                    <DialogTrigger class="flex justify-between w-full px-2 py-1.5 text-sm hover:bg-slate-100">
                                                        Supprimer
                                                        <Trash class="size-6 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                                                    </DialogTrigger>
                                                    <DialogContent>
                                                        <p>Êtes-vous sûr de vouloir supprimer cette maladie ?</p>
                                                        <div class="flex gap-2 justify-end">
                                                            <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                                            <Link 
                                                            :href="route('daycares.children.allergies.destroy', {daycare: props.daycare.id, child: props.child.id, allergy: allergy.id})" 
                                                            method="delete"
                                                            class="bg-red-500 text-white px-3 py-2 rounded"
                                                            >
                                                            Supprimer
                                                        </Link> 
                                                    </div>
                                                </DialogContent>
                                            </Dialog>
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </div>
                                    </p>
                                    
                                    <p class="text-sm mt-2"> 
                                        {{ allergy.description }}
                                    </p>
                                </div>
                            </div>

                            <Link 
                                :href="route('daycares.children.allergies.create', {daycare: props.daycare.id, child: props.child.id})" 
                                class="border rounded px-3 py-2 self-center my-4"
                            >
                                Ajouter une allergie
                            </Link>
                        </CollapsibleContent>
                    </Collapsible>

                    <Collapsible class="rounded ">
                        <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                            <span>Traitements</span>
                            <ChevronDown class="w-6 h-6"></ChevronDown>
                        </CollapsibleTrigger>

                        <CollapsibleContent class="flex flex-col data-[state=open]:border">
                            <div class="text-center py-4" v-if="child.health.medications.length == 0">
                                Aucun traitement enregistré !
                            </div>

                            <div class="guardians px-4 mt-4" v-else v-for="medication in child.health.medications" :key="medication.id">
                                <div class="p-4 rounded border">
                                    <p class="flex justify-between items-center">
                                        {{ medication.name }}
                                        <div class="flex gap-2 items-center">
                                            <DropdownMenu>
                                                <DropdownMenuTrigger>
                                                    <EllipsisVertical class="size-6"></EllipsisVertical>
                                                </DropdownMenuTrigger>
                                                
                                                <DropdownMenuContent align="end" class="mt-2">
                                                    <DropdownMenuItem>
                                                        <Link 
                                                        :href="route('daycares.children.medications.edit', {daycare: props.daycare.id, child: props.child.id, medication: medication.id})"
                                                        class="flex items-center gap-2 justify-between w-full"
                                                        >
                                                        Editer
                                                        <Pencil class="size-6 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                                                    </Link>
                                                </DropdownMenuItem>
                                                
                                                <Dialog class="">
                                                    <DialogTrigger class="flex justify-between w-full px-2 py-1.5 text-sm hover:bg-slate-100">
                                                        Supprimer
                                                        <Trash class="size-6 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                                                    </DialogTrigger>
                                                    <DialogContent>
                                                        <p>Êtes-vous sûr de vouloir supprimer ce traitement ?</p>
                                                        <div class="flex gap-2 justify-end">
                                                            <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                                            <Link 
                                                            :href="route('daycares.children.medications.destroy', {daycare: props.daycare.id, child: props.child.id, medication: medication.id})" 
                                                            method="delete"
                                                            class="bg-red-500 text-white px-3 py-2 rounded"
                                                            >
                                                            Supprimer
                                                        </Link> 
                                                    </div>
                                                </DialogContent>
                                            </Dialog>
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </div>
                                    </p>
                                    
                                    <p class="text-sm mt-2"> 
                                        {{ medication.dosage }}
                                    </p>
                                    <p class="text-sm mt-2"> 
                                        {{ medication.note }}
                                    </p>
                                </div>
                            </div>

                            <Link 
                                :href="route('daycares.children.medications.create', {daycare: props.daycare.id, child: props.child.id})" 
                                class="border rounded px-3 py-2 self-center my-4"
                            >
                                Ajouter un traitement
                            </Link>
                        </CollapsibleContent>
                    </Collapsible>
                </section>



            </Transition>
        </div>
    </AppLayout>
</template>