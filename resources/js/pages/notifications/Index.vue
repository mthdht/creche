<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Notification } from '@/types';

import { Dialog, DialogTrigger, DialogContent, DialogClose  } from '@/components/ui/dialog';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuItem } from '@/components/ui/dropdown-menu';
import { EllipsisVertical, Trash } from 'lucide-vue-next';


const props = defineProps<{
    notifications: Notification[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notifications',
        href: '/notifications',
    },
];

const borderStyle: any = {
    delete: 'border-red-500',
    edit: 'border-yellow-500',
    create: 'border-emerald-500'
}

const isRead = (notification: Notification) => {
    return notification.read_at == null ? 'bg-slate-200' : ''
}

</script>

<template>
    <Head title="Mes Crèches" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <h2 class="font-semibold text-xl flex justify-between">
                <div class="flex gap-3 items-center">
                    <Store class="size-7 text-indigo-500"></Store>
                    Toutes les notifications !
                </div>
            </h2>

            <section class="space-y-3" >
                <template v-if="props.notifications.length === 0">
                    <p class="text-center text-gray-500">Aucune notification trouvée</p>
                </template>


                <div 
                    class="shadow rounded p-4 border-l-4" v-for="notification in props.notifications"
                    :class="[borderStyle[notification.data.type], isRead(notification)]"
                >
                    <DropdownMenu>
                        <DropdownMenuTrigger class="self-start aspect-square float-right">
                            <EllipsisVertical class="size-7"></EllipsisVertical>
                        </DropdownMenuTrigger>
                        
                        <DropdownMenuContent align="end" class="mt-2">
                            <DropdownMenuItem>
                                <Link :href="route('notifications.edit', {notification: notification.id})">
                                    <span v-if="notification.read_at">Marquer comme  non lu</span>
                                    <span v-else>Marquer comme lu</span>
                                </Link>
                            </DropdownMenuItem>
                            
                            <Dialog class="">
                                <DialogTrigger class="flex justify-between w-full px-2 py-1.5 text-sm hover:bg-slate-100">
                                    Supprimer
                                    <Trash class="size-6 text-white bg-red-500 rounded p-1 shadow-lg"></Trash>
                                </DialogTrigger>
                                <DialogContent>
                                    <p>Êtes-vous sûr de vouloir supprimer cette notifications ?</p>
                                    <div class="flex gap-2 justify-end">
                                        <DialogClose @click="" class="bg-slate-200 border px-3 py-2 rounded">Annuler</DialogClose>

                                        <DialogClose>
                                            <Link 
                                            :href="route('notifications.destroy', {notification: notification.id})" 
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

                    <p>{{ notification.data.message }}</p>
                    <p>le {{ new Date(notification.created_at).toLocaleDateString() }}</p>
                    <p>{{ notification }}</p>
                </div>
            </section>
        </div>
    </AppLayout>
</template> 