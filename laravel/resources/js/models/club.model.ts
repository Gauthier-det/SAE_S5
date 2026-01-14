import type { Address } from "./user.model";

export interface Club {
    CLU_ID: number;
    USE_ID: number;
    ADD_ID: number;
    CLU_NAME: string;
    address?: Address;
}
