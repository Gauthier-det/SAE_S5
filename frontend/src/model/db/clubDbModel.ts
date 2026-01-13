import type { Address } from "./addressDbModel";
import type { User } from "./userDbModel";

export interface Club {
    id: number;
    manager : User;
    address : Address;
    name: string;
}