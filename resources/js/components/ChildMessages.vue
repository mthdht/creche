<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { type Daycare, type Child } from '@/types';

import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { Trash, Pencil, EllipsisVertical, Plus } from 'lucide-vue-next';
import Select from './Select.vue';
import { ref, computed } from 'vue';

const props = defineProps<{
    daycare: Daycare;
    child: Child;
}>();

const severityFilter = ref()
const targetFilter = ref()

const filteredMessages = computed(() => {
    return props.child.all_messages.filter((message) => {
        return (
            (!severityFilter.value || message.severity === severityFilter.value) &&
            (!targetFilter.value || message.target === targetFilter.value)
        );
    });
})

const borderStyle: any =  {
    'low': 'border-l-sky-500',
    'medium': 'border-l-yellow-500',
    'high': 'border-l-red-500'
}

const targetMap: any = {
    all: 'Générale',
    child: 'Personnel',
    daycare: 'Crèche'
}
</script>

<template>
    <section class="messages space-y-4">
        <div class="filters flex gap-2">
            <Select 
                placeholder="Importance"
                name="severity" 
                id="severity" 
                class="w-full rounded-lg border border-gray-200 grow" 
                v-model="severityFilter"
                tabindex="5"
                required
                :options="[
                    {value: '', label: 'Aucune'},
                    {value: 'high', label: 'Elevé'},
                    {value: 'medium', label: 'Normal'},
                    {value: 'low', label: 'Basse'},
                ]"
            ></Select>

            <Select 
                placeholder="Destinataire"
                name="severity" 
                id="severity" 
                class="w-full rounded-lg border border-gray-200 grow" 
                v-model="targetFilter"
                tabindex="5"
                required
                :options="[
                    {value: '', label: 'Tout le monde'},
                    {value: 'all', label: 'Générale'},
                    {value: 'daycare', label: 'Crèche'},
                    {value: 'child', label: props.child.first_name + ' ' + props.child.last_name},
                ]"
            ></Select>
                    
            <Link 
                :href="route('daycares.children.messages.create', {daycare: props.daycare.id, child: props.child.id})"
                class="flex items-center gap-2 justify-between"
                >
                <Plus class="size-6 text-white bg-emerald-500 rounded p-1 shadow-lg"></Plus>
            </Link>
        </div>

        <div class="text-center py-4" v-if="props.child.all_messages.length == 0">
            Aucun message enregistré !
        </div>

        <div class="messages p-4 border border-l-4 space-y-2 rounded" :class="borderStyle[message.severity]" v-else v-for="message in filteredMessages">
            <p class="flex justify-between font-semibold">
                <span>{{  message.title }}</span>

                <DropdownMenu>
                    <DropdownMenuTrigger>
                        <EllipsisVertical class="size-6"></EllipsisVertical>
                    </DropdownMenuTrigger>

                    <DropdownMenuContent align="end" class="mt-2">
                        <DropdownMenuItem>
                            <Link 
                                :href="route('daycares.children.messages.edit', {daycare: props.daycare.id, child: props.child.id, message: message.id})"
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
                                <p>Êtes-vous sûr de vouloir supprimer ce message ?</p>
                                <div class="flex gap-2 justify-end">
                                    <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                    <DialogClose @click="" >

                                        <Link 
                                        :href="route('daycares.children.messages.destroy', {daycare: props.daycare.id, child: props.child.id, message: message.id})" 
                                        method="delete"
                                        class="bg-red-500 text-white px-3 py-2 rounded"
                                        >
                                            Supprimer
                                        </Link> 
                                    </DialogClose>
                                </div>
                            </DialogContent>
                        </Dialog>
                    </DropdownMenuContent>
                </DropdownMenu>
            </p>
            <p class="">{{ message.content }}</p>
            <p class="flex justify-between text-sm">
                <span class="px-2 py-1 rounded-full border">{{ targetMap[message.target] }}</span>
                <span>
                    le {{ new Date(message.created_at).toLocaleDateString('fr-FR') }}
                </span>
            </p>
        </div>
    </section>
</template>