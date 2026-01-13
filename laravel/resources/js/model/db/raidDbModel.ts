import type { Address } from "./addressDbModel";

export interface Raid {
    id: string;
    club? : string;
    address? : Address;
    manager?: string;
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