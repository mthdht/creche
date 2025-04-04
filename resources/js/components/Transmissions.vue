<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { type Daycare, type Child } from '@/types';
import { transmissionByDate, readableTime } from '@/lib/utils';
import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { Collapsible, CollapsibleContent, CollapsibleTrigger} from '@/components/ui/collapsible';
import { ChevronDown, Trash, Pencil, EllipsisVertical, Plus, Moon, Utensils, Toilet } from 'lucide-vue-next';

const props = defineProps<{
    daycare: Daycare;
    child: Child;
}>();

const iconMap: any = {
    sieste: Moon,
    repas: Utensils,
    hygiene: Toilet
}

const readableDuration = (duration: string) => {
    const splitDuration = duration.split(':')

    if (splitDuration[0] == '00') {
        return splitDuration[1] + ' min'
    }
    return duration
}
</script>

<template>
    <section class="space-y-4">
        <div class="filters">
            <Link 
                :href="route('daycares.children.transmissions.create', {daycare: props.daycare.id, child: props.child.id})"
                class="flex items-center gap-2 justify-between w-full"
                >
                <Plus class="size-6 text-white bg-emerald-500 rounded p-1 shadow-lg"></Plus>
            </Link>
        </div>

        <Collapsible class="rounded" v-for="transmissionDay in transmissionByDate(child.last_five_days_transmissions)">
            <CollapsibleTrigger class="border p-4 w-full font-semibold flex justify-between items-center group">
                <span>{{  (new Date(transmissionDay[0])).toLocaleDateString('fr-Fr', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
                <ChevronDown 
                    class="w-6 h-6 transition-transform duration-300 ease-in-out group-data-[state=open]:rotate-180"></ChevronDown>
            </CollapsibleTrigger>

            <CollapsibleContent class="flex flex-col data-[state=open]:border">
                <div class="text-center py-4" v-if="transmissionDay[1].length == 0">
                    Aucune activité enregistré !
                </div>

                <div class="guardians px-4 mt-4 last:mb-4"  v-else v-for="transmission in transmissionDay[1]" :key="transmission.id">
                    <div class="p-4 rounded border">
                        <div class="flex justify-between items-center">
                            <p class="flex gap-2">
                                <span class="font-semibold">
                                    {{ readableTime(transmission.datetime) }}
                                </span>
                                <component :is="iconMap[transmission.type]"></component>
                                <span>{{  transmission.type == 'hygiene' ? 'Hygiène' : transmission.type.toUpperCase() }}</span>
                                <span v-if="transmission.duration">
                                    de {{ readableDuration(transmission.duration) }}
                                </span>
                            </p>
                            
                            <div class="self-start">
                                <DropdownMenu>
                                    <DropdownMenuTrigger>
                                        <EllipsisVertical class="size-6"></EllipsisVertical>
                                    </DropdownMenuTrigger>

                                    <DropdownMenuContent align="end" class="mt-2">
                                        <DropdownMenuItem>
                                            <Link 
                                                :href="route('daycares.children.transmissions.edit', {daycare: props.daycare.id, child: props.child.id, transmission: transmission.id})"
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
                                                <p>Êtes-vous sûr de vouloir supprimer cette activité ?</p>
                                                <div class="flex gap-2 justify-end">
                                                    <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>
                                                    <Link 
                                                        :href="route('daycares.children.transmissions.destroy', {daycare: props.daycare.id, child: props.child.id, transmission: transmission.id})" 
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
                        </div>
                        <p class="italic">{{ transmission.description }}</p>
                    </div>
                </div>
            </CollapsibleContent>
        </Collapsible>
    </section>
</template>