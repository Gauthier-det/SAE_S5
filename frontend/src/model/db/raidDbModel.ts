export type RaidStatus = 'à venir' | 'en cours' | 'terminé';
export type RegistrationStatus = 'en attente' | 'confirmée' | 'annulée' | 'non inscrit';

export interface Raid {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    events_count: number;
    image_url?: string;
    registration_start: string;
    registration_end: string;
    status: RaidStatus;
    registration_status?: RegistrationStatus;
}