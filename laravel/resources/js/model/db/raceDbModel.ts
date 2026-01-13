import type { User } from "./userDbModel";

export interface Race {
    id: number;
    manager? : User;
    raid_id : number;
    time_start: string;
    time_end: string;
    competitive : boolean;
    difficulty : RaceDifficulty;
    min_participants : number;
    max_participants : number;
    min_team : number;
    max_team : number;
    age_min : number;
    age_middle : number;
    age_max : number;
}

export enum RaceDifficulty {
    EASY = "Facile",
    MEDIUM = "Moyen",
    HARD = "Difficile"
}
