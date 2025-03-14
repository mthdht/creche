<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Daycare, type Child } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Dialog, DialogTrigger, DialogContent,  } from '@/components/ui/dialog';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import { calculateAge } from '@/lib/utils';
import { ref } from 'vue';
import { Collapsible, CollapsibleContent, CollapsibleTrigger} from '@/components/ui/collapsible';
import { ChevronDown } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Daycares',
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
        title: props.child.first_name,
        href: route('daycares.children.show', {daycare: props.daycare.id, child: props.child.id}),
    },
];

const activeTab = ref('infos')

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
                <template v-if="activeTab === 'infos'">
                    <Collapsible class="rounded">
                        <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center">
                            <span>Parents</span>
                            <ChevronDown class="w-6 h-6" />
                        </CollapsibleTrigger>

                        <CollapsibleContent class="border flex flex-col gap-4">
                            <div class="text-center py-4" v-if="child.guardians.length == 0">
                                Aucun parents enregistré !
                            </div>

                            <div class="guardians" v-else>

                            </div>

                            <Link 
                                href="route('daycares.children.guardians.create', {daycare: props.daycare.id, child: props.child.id})" 
                                class="border rounded px-3 py-2 self-center mb-4"
                            >
                                Ajouter un parent
                            </Link>
                        </CollapsibleContent>
                    </Collapsible>
                </template>

            </Transition>
            {{  child }}
        </div>
    </AppLayout>
</template>