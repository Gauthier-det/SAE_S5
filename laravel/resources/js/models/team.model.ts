export interface Team {
    TEA_ID: number;
    USE_ID: number;
    TEA_NAME: string;
    TEA_IMAGE?: string;
}

export interface TeamCreation {
    name: string;
    image?: string;
}

export interface TeamMemberAdd {
    user_id: number;
    team_id: number;
    race_id: number;
}

export interface AvailableUser {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    USE_GENDER?: string;
    is_self: boolean;
    already_in_team: boolean;
    has_overlapping_race: boolean;
    is_available: boolean;
}

export interface TeamResponse {
    data: {
        team_id: number;
        team_name: string;
        owner_id: number;
        message: string;
    };
}
