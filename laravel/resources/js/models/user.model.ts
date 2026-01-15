import type { Address } from './address.model';
import type { Club } from './club.model';
import type { Race } from './race.model';

export type Gender = 'Homme' | 'Femme' | 'Autre';

export interface User {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    USE_GENDER: Gender;
    USE_BIRTHDATE?: string;
    USE_PHONE_NUMBER?: number;
    USE_LICENCE_NUMBER?: string;
    USE_MEMBERSHIP_DATE?: string;
    CLU_ID?: number;
    address?: Address;
    club?: Club;
    races?: Race[];
}

export interface UserResponse {
    data: User;
}

export interface UserUpdate {
    USE_NAME?: string;
    USE_LAST_NAME?: string;
    USE_BIRTHDATE?: string;
    USE_PHONE_NUMBER?: number;
    USE_LICENCE_NUMBER?: string;
    address?: Address;
}