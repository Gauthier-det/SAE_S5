import type { Race } from "./raceDbModel";

export interface RaceCategorie {
    race : Race;
    categorie : Categorie;
}

export interface Categorie {
    id: number;
    name: string;
}
