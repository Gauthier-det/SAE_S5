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
}

export interface RaidResponse {
    data: Raid[];
}

export interface RaidCreation {
    CLU_ID: number;
    ADD_ID: number;
    RAI_NAME: string;
    RAI_MAIL: string;
    RAI_PHONE_NUMBER?: string;
    RAI_WEB_SITE: string;
    RAI_IMAGE: string;
    RAI_TIME_START: string;
    RAI_TIME_END: string;
    RAI_REGISTRATION_START: string;
    RAI_REGISTRATION_END: string;
}
