<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { type Daycare, type Child } from '@/types';
import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Collapsible, CollapsibleContent, CollapsibleTrigger} from '@/components/ui/collapsible';
import { ChevronDown, Trash, Pencil, Info, EllipsisVertical, TriangleAlert, CircleAlert } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child;
}>();

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
    <section class="space-y-4">
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
                                <span class="border px-2 py-1 rounded-full">{{ relationshipMap[guardian.profile.relationship] || 'Autre' }}</span>
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

        <Collapsible class="rounded ">
            <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                <span>Notes</span>
                <ChevronDown class="w-6 h-6"></ChevronDown>
            </CollapsibleTrigger>

            <CollapsibleContent class="flex flex-col data-[state=open]:border">
                <div class="text-center py-4" v-if="child.additional_notes.length == 0">
                    Aucune note enregistré !
                </div>

                <div class="guardians px-4 mt-4" v-else v-for="additionalNote in child.additional_notes" :key="additionalNote.id">
                    <div class="p-4 rounded border">
                        <p class="flex justify-between items-start">
                            <div class="flex gap-2 items-center">
                                <component 
                                    :is="severityIcon[additionalNote.severity]"
                                    class="size-6 shrink-0"
                                ></component>
                                {{ additionalNote.note }}
                            </div>
                            <div class="flex gap-2 items-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger>
                                        <EllipsisVertical class="size-6"></EllipsisVertical>
                                    </DropdownMenuTrigger>
                                    
                                    <DropdownMenuContent align="end" class="mt-2">
                                        <DropdownMenuItem>
                                            <Link 
                                                :href="route('daycares.children.additionalNotes.edit', {daycare: props.daycare.id, child: props.child.id, additionalNote: additionalNote.id})"
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
                                                        :href="route('daycares.children.additionalNotes.destroy', {daycare: props.daycare.id, child: props.child.id, additionalNote: additionalNote.id})" 
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
                    </div>
                </div>

                <Link 
                    :href="route('daycares.children.additionalNotes.create', {daycare: props.daycare.id, child: props.child.id})" 
                    class="border rounded px-3 py-2 self-center my-4"
                >
                    Ajouter une note
                </Link>
            </CollapsibleContent>
        </Collapsible>
    </section>
</template>