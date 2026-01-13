import type { Address } from "./addressDbModel";
import type { Club } from "./clubDbModel";

export interface User {
    id: string;
    address? : Address;
    club? : Club;
    email: string;
    name: string;
    last_name: string;
    birth_date: string;
    phone_number: string;
    pps_form: string;
    membership_date: string;
    is_valid : boolean;
    gender:string;
    role:string;
}