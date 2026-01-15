import type {  User } from './user.model';
import type { Address } from './address.model';

export interface Club {
    CLU_ID: number;
    USE_ID: number;
    ADD_ID: number;
    CLU_NAME: string;
    users_count?: number;
    address?: Address;
    user?: User;
}

