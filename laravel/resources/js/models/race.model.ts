import type { User } from "./user.model";
import type { Raid } from "./raid.model";

export interface Race {
    RAC_ID: number;
    user: User;
    raid: Raid;
    RAC_NAME: string;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_GENDER: 'Homme' | 'Femme' | 'Mixte';
    RAC_TYPE: string;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_MIN_TEAM_MEMBERS: number;
    RAC_MAX_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
    CAT_1_PRICE?: number;
    CAT_2_PRICE?: number;
    CAT_3_PRICE?: number;
    RAC_CHIP_MANDATORY?: number;
}

export interface RaceResponse {
    data: Race[];
}

export interface RaceCreation {
    USE_ID: number;
    RAI_ID: number;
    RAC_NAME?: string;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_GENDER: 'Homme' | 'Femme' | 'Mixte';
    RAC_TYPE: string;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_MIN_TEAM_MEMBERS: number;
    RAC_MAX_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
    CAT_1_PRICE: number;
    CAT_2_PRICE: number;
    CAT_3_PRICE: number;
    RAC_CHIP_MANDATORY?: number;
}

export interface RaceUpdate {
    USE_ID: number;
    RAI_ID: number;
    RAC_NAME: string;
    RAC_TIME_START: string;
    RAC_TIME_END: string;
    RAC_GENDER: 'Homme' | 'Femme' | 'Mixte';
    RAC_TYPE: string;
    RAC_DIFFICULTY: string;
    RAC_MIN_PARTICIPANTS: number;
    RAC_MAX_PARTICIPANTS: number;
    RAC_MIN_TEAMS: number;
    RAC_MAX_TEAMS: number;
    RAC_MIN_TEAM_MEMBERS: number;
    RAC_MAX_TEAM_MEMBERS: number;
    RAC_AGE_MIN: number;
    RAC_AGE_MIDDLE: number;
    RAC_AGE_MAX: number;
    CAT_1_PRICE: number;
    CAT_2_PRICE: number;
    CAT_3_PRICE: number;
    RAC_CHIP_MANDATORY?: number;
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
    is_valid: boolean;
}

export interface RaceDetail extends Race {
    stats: RaceStats;
    formatted_categories: FormattedCategory[];
    teams_list: TeamDetail[];
    has_results: boolean;
}

export interface RaceResultPage extends RaceDetail { }

export interface RaceDetailResponse {
    data: RaceDetail;
}
