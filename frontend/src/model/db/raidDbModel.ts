import type { Address } from "./addressDbModel";
import type { Club } from "./clubDbModel";
import type { User } from "./userDbModel";

export interface Raid {
    id: number;
    club : Club;
    address : Address;
    manager : User;
    name: string;
    mail : string;
    phone_number : string;
    website : string;
    image : string;
    time_start : string;
    time_end : string;
    registration_start : string;
    registration_end : string;
}

export type RaidStatus = 'à venir' | 'en cours' | 'terminé';
export type RegistrationStatus = 'en attente' | 'confirmée' | 'annulée' | 'non inscrit';