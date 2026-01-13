import type { Raid } from "./raidDbModel";
import type { User } from "./userDbModel";

export interface Race {
    id: number;
    manager : User;
    raid : Raid;
    time_start: string;
    time_end: string;
    competitive : boolean;
    difficulty : RaceDifficulty;
    min_participants : number;
    max_participants : number;
    min_team : number;
    max_team : number;
    min_age : number;
    age_middle : number;
    max_age : number;
}

export enum RaceDifficulty {
    EASY = "Facile",
    MEDIUM = "Moyen",
    HARD = "Difficile"
}
