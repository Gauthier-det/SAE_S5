import type { Address } from "./address.model";
import type { Gender } from "./user.model";
import type { Club } from "./club.model";

export interface Login {
    mail: string;
    password: string;
}

export interface Register {
    name: string;
    last_name: string;
    mail: string;
    password: string;
    gender: Gender;
}

export interface AuthAPIResponse {
    data: {
        user_id: number;
        user_name: string;
        user_last_name: string;
        user_mail: string;
        user_gender: Gender;
        user_phone: string | null;
        user_birthdate: string | null;
        user_address: Address | null;
        user_club: Club | null;
        user_clubs_managed: Club[] | null;
        user_licence: string | null;
        user_pps: string | null;
        access_token: string;
        token_type: string;
    }
}
