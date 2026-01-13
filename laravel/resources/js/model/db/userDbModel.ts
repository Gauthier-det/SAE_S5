import type { Address } from "./addressDbModel";
import type { Club } from "./clubDbModel";

// Backend database model with USE_ prefix
export interface User {
    USE_ID: number;
    USE_MAIL: string;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_PASSWORD: string;
    // Optional fields
    address?: Address;
    club?: Club;
    birth_date?: string;
    phone_number?: string;
    pps_form?: string;
    membership_date?: string;
    is_valid?: boolean;
    gender?: string;
    role?: string;
}