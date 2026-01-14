
export interface AdminClub {
    USE_ID: number;
    USE_NAME: string;
    USE_EMAIL: string;
}

export interface ClubAddress {
    ADD_ID: number;
    ADD_STREET_NUMBER: string;
    ADD_STREET_NAME: string;
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
}

export interface Club {
    CLU_ID: number;
    CLU_NAME: string;
    USE_ID: number;
    ADD_ID: number;
    admin: AdminClub;
    address: ClubAddress;
}

export interface ClubCreation {
    CLU_NAME: string;
    USE_ID: number;
    ADD_STREET_NUMBER: string;
    ADD_STREET_NAME: string;
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
}

