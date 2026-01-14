import type { Club } from './club.model';

export interface User {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    CLU_ID?: number;
    USE_BIRTHDATE?: string;
    USE_PHONE_NUMBER?: string;
    USE_LICENCE_NUMBER?: string;
    USE_PPS_FORM?: string;
    USE_MEMBERSHIP_DATE?: string;
    address?: Address;
    club?: Club;
    clubs_created?: Club[];
}

export interface Address {
    ADD_ID: number;
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
    ADD_STREET_NAME: string;
    ADD_STREET_NUMBER: string;
}

export interface UserResponse {
    data: User;
}
