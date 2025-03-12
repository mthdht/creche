<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Hand, Mail, MessagesSquare, NotebookPen, NotepadText, Users } from 'lucide-vue-next';

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4 bg-slate-50 h-full">
            <h2 class="font-semibold text-xl flex gap-3">
                <Hand class="size-7 text-indigo-500"></Hand>
                Welcome {{ user.profile.first_name }} {{ user.profile.last_name }}!
            </h2>

            <!-- Stats -->
            <section class="stats grid grid-cols-2 gap-4 font-semibold">
                <div class="h-24 rounded shadow flex flex-col justify-center items-center bg-indigo-50 text-indigo-700">
                    <p class="text-2xl font-bold">3</p>
                    <p>Crèches</p>
                </div>

                <div class="h-24 rounded shadow flex flex-col justify-center items-center bg-green-50 text-green-700">
                    <p class="text-2xl font-bold">32 enfants</p>
                    <p class="text-xs font-normal">27 présents</p>
                </div>
            </section>

            <!-- Accès rapide -->
        <section class="menu grid grid-cols-2 md:grid-cols-4 gap-4">
            <Link href="/journaux" class="hover:bg-sky-50 aspect-square border shadow flex flex-col items-center justify-center gap-2 rounded-lg bg-white transition-colors hover:border-sky-200">
                <NotepadText class="size-14 stroke- text-sky-500"></NotepadText>
                <p>Journaux</p>
            </Link>

            <Link href="/messages" class="aspect-square border shadow flex flex-col items-center justify-center gap-2 rounded-lg bg-white transition-colors hover:bg-emerald-50 hover:border-emerald-200">
                <Mail class="size-14 stroke- text-emerald-500"></Mail>
                <p>Messages</p>
            </Link>

            <Link href="/equipes" class="aspect-square border shadow flex flex-col items-center justify-center gap-2 rounded-lg bg-white transition-colors hover:bg-purple-50 hover:border-purple-200">
                <Users class="size-14 stroke- text-purple-600"></Users>
                <p>Équipes</p>
            </Link>

            <Link href="/notes" class="aspect-square border shadow flex flex-col items-center justify-center gap-2 rounded-lg bg-white transition-colors hover:bg-yellow-50 hover:border-yellow-200">
                <NotebookPen class="size-14 stroke- text-yellow-600"></NotebookPen>
                <p>Notes</p>
            </Link>
        </section>

        <!-- Dernière alerte -->
        <section>
            <Link href="/notifications/id">
                <div class="last-alert bg-white shadow rounded-lg p-4 flex gap-4 items-center hover:bg-sky-50 transition-colors">
                <MessagesSquare class="size-10 text-emerald-500"></MessagesSquare>
                <p class="font-semibold">Nouveau message d'un parent</p>
                </div>
            </Link>
        </section>

        </div>
    </AppLayout>
</template>
