import type { Address } from "./addressDbModel";

export interface Club {
    id: string;
    manager : string;
    address? : Address;
    name: string;
}