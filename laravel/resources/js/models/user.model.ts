import type { Address } from './address.model';
import type { Club } from './club.model';

export interface User {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    USE_BIRTHDATE?: string;
    USE_PHONE_NUMBER?: string;
    USE_LICENCE_NUMBER?: string;
    USE_PPS_FORM?: string;
    USE_MEMBERSHIP_DATE?: string;
    CLU_ID?: number;
    address?: Address;
    club?: Club;
}

export interface UserResponse {
    data: User;
}
