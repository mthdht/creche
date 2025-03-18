<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child, type Health } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Dialog, DialogTrigger, DialogContent,  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import { calculateAge } from '@/lib/utils';
import { ref } from 'vue';
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

const handle = (event: Event) => {
    event.preventDefault
    console.log('ok')
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

            <Transition mode="out-in"
                enter-active-class="transition duration-200 ease-out"
                leave-active-class="transition duration-200 ease-in"
                enter-from-class="opacity-0 -translate-y-2"
                leave-to-class="opacity-0 translate-y-2"
            >
                <section v-if="activeTab === 'infos'" class="space-y-4">
                    <Collapsible class="rounded " defaultOpen>
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
                                            <span class="border px-2 py-1 rounded-full">{{ relationship(guardian.profile.relationship) }}</span>
                                            <DropdownMenu>
                                                <DropdownMenuTrigger>
                                                    <EllipsisVertical class="size-6"></EllipsisVertical>
                                                </DropdownMenuTrigger>
                                                <DropdownMenuContent align="end" class="mt-4">
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
                            <div class="text-center py-4" v-if="child.illnesses.length == 0">
                                Aucune maladies enregistré !
                            </div>

                            
                            <div class="guardians px-4 mt-4" v-else v-for="illness in child.illnesses" :key="illness.id">
                                <div class="p-4 rounded border">
                                    <p class="flex justify-between items-center">
                                        {{ illness.name }}
                                    </p>
                                    
                                    <p class="text-sm"> 
                                        {{ illness.description }}
                                    </p>

                                    <div class="flex justify-between mt-2">
                                        <p class="text-sm flex items-center gap-4">
                                            <Info class="size-6"></Info>
                                            <span>{{ illness.note}}</span>
                                        </p>

                                        <div class="actions flex gap-2 items-start">
                                            <Link :href="route('daycares.children.illnesses.edit', {daycare: props.daycare.id, child: props.child.id, illness: illness.id})">
                                                <Pencil class="size-6 text-white bg-yellow-500 rounded p-1 shadow-lg"></Pencil>
                                            </Link>

                                            
                                            <Dialog>
                                                <DialogTrigger>
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
                                        </div>
                                    </div>
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
                </section>



            </Transition>
        </div>
    </AppLayout>
</template>