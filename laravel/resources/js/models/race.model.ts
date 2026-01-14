export interface Race {
    RAC_ID: number;
    USE_ID: number;
    RAI_ID: number;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_TYPE: RaceType;
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
    USE_ID: number;
    RAI_ID: number;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_TYPE: RaceType;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
    prices?: {
        minor: number;
        major: number;
        licensed: number;
    };
}


export enum RaceType {
    Competitive = 'Compétitif',
    Hobby = 'Loisir'
}

export interface RaceStats {
    teams_count: number;
    participants_count: number;
    places_remaining: number;
    filling_rate: number;
    participants_expected_min: number;
    participants_expected_max: number;
}

export interface FormattedCategory {
    id: number;
    label: string;
    price: string;
}

export interface TeamMember {
    id: number;
    name: string;
    email: string;
}

export interface TeamResponsible {
    id: number;
    name: string;
}

export interface TeamDetail {
    id: number;
    name: string;
    image: string | null;
    members_count: number;
    responsible: TeamResponsible | null;
    members: TeamMember[];
}

export interface RaceDetail extends Race {
    stats: RaceStats;
    formatted_categories: FormattedCategory[];
    teams_list: TeamDetail[];
}

export interface RaceDetailResponse {
    data: RaceDetail;
}