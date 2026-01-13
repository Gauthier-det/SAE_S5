export interface Race {
    id: number;
    raid_id: number;
    race_id: number;
    date: string;
    race_time_start?: string;
    race_time_end?: string;
    type: string;
    difficulty?: 'facile' | 'moyen' | 'difficile';
    age_range?: string;
    distance?: number;
    max_participants?: number;
    registered_participants?: number;
    price?: number;
    description?: string;
    image_url?: string;
    team_members?: number;
}

export interface RaceCard extends Race {
    available_spots?: number; 
}
