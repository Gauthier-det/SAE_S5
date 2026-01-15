export interface RaidClub {
    CLU_ID: number;
    CLU_NAME: string;
}

export interface RaidAddress {
    ADD_ID: number;
    ADD_CITY: string;
    ADD_POSTAL_CODE: number;
    ADD_STREET_NAME: string;
    ADD_STREET_NUMBER: string;
}

export interface Raid {
    RAI_ID: number;
    CLU_ID: number;
    ADD_ID: number;
    USE_ID: number;
    RAI_NAME: string;
    RAI_MAIL: string;
    RAI_PHONE_NUMBER: string | null;
    RAI_WEB_SITE: string;
    RAI_IMAGE: string;
    RAI_TIME_START: string;
    RAI_TIME_END: string;
    RAI_REGISTRATION_START: string;
    RAI_REGISTRATION_END: string;
    club?: RaidClub;
    address?: RaidAddress;
}

export interface RaidResponse {
    data: Raid[];
}

export interface RaidCreation {
    CLU_ID: number;
    ADD_ID: number;
    RAI_NAME: string;
    RAI_MAIL?: string | null;
    RAI_PHONE_NUMBER?: string | null;
    RAI_WEB_SITE?: string | null;
    RAI_IMAGE?: string | null;
    RAI_TIME_START: string | null;
    RAI_TIME_END: string | null;
    RAI_REGISTRATION_START: string | null;
    RAI_REGISTRATION_END: string | null;
    RAI_NB_RACES: number;
}
