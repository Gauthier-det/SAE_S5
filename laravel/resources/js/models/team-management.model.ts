export interface TeamRaceMember {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    USE_LICENCE_NUMBER?: string;
    USR_CHIP_NUMBER?: string;
    USR_PPS_FORM?: string;
}

export interface TeamRaceDetails {
    team: {
        id: number;
        name: string;
        is_valid: boolean;
        race_number: number;
    };
    race: {
        id: number;
        type: string;
    };
    members: TeamRaceMember[];
}
