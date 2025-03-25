import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    profile: UserProfile;
}

interface UserProfile {
    id: number;
    user_id: number;
    first_name: string;
    last_name: string;
    phone?: string;
    address?: string;
    role: string;
    relationship: 'father' | 'mother' | 'grandParent' | 'other';
}

export interface Daycare {
    id: number;
    name: string;
    email?: string;
    phone: string;
    address: string | null;
    children_count: number;
    children: Array<Child>;
}

export interface Child {
    id: number;
    first_name: string;
    last_name: string;
    sexe: string;
    birth_date: string;
    avatar: string | null;
    guardians: Array<User>;
    health: Health;
    additional_notes: AdditionalNote[];
    transmissions: [];
    last_five_days_transmissions: Transmission[],
    all_messages: Message[]
}

export interface Health {
    illnesses: Illness[];
    allergies: Allergy[];
    medications: Medication[];
}

export interface Illness {
    id: number;
    name: string;
    description: string;
    note?: string;
}

export interface Allergy {
    id: number;
    name: string;
    severity: 'low' | 'medium' | 'high';
    description: string;
}

export interface Medication {
    id: number;
    name: string;
    dosage: string;
    note: string;
}

export interface AdditionalNote {
    id: number;
    note: string;
    severity: 'low' | 'medium' | 'high';
}

export interface Transmission {
    id: number
    datetime: string
    description?: string
    type: string
    duration?: string,
    severity?: string
}

export interface Message {
    id: number
    title: string
    content: string
    severity: 'low' | 'medium' | 'high'
    target: 'child' | 'daycare' | 'all'
    created_at: string
}

export type BreadcrumbItemType = BreadcrumbItem;
