export interface Race {
    RAC_ID: number;
    USE_ID: number;
    RAI_ID: number;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_TYPE: string;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
}

export interface RaceResponse {
    data: Race[];
}

export interface RaceCreation {
    RAI_ID: number;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_TYPE: string;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
}
