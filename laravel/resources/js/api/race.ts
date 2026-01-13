import type { RaceCreation } from "../model/domain/raceModel";

export const createRace = async (race: RaceCreation): Promise<void> => {
    // Simulation d'un appel API
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Course créée avec succès :", race);
            resolve();
        }, 1000);
    });
};

import { RaceDifficulty, type Race } from '../model/db/raceDbModel';

const mockRacesData: Race[] = [
    {
        id: 1,
        raid_id: 1,
        time_start: '15 juin 2026',
        time_end: '12:30',
        competitive: false,
        age_min: 0,
        age_max: 99,
        difficulty: RaceDifficulty.EASY,
        max_participants: 50,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 2,
        raid_id: 1,
        time_start: '16 juin 2026',
        time_end: '14:15',
        competitive: true,
        age_min: 18,
        age_max: 65,
        difficulty: RaceDifficulty.HARD,
        max_participants: 60,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 3,
        raid_id: 1,
        time_start: '22 juin 2026',
        time_end: '18:00',
        competitive: true,
        age_min: 16,
        age_max: 99,
        difficulty: RaceDifficulty.HARD,
        max_participants: 40,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 4,
        raid_id: 3,
        time_start: '5 juillet 2026',
        time_end: '13:30',
        competitive: false,
        age_min: 6,
        age_max: 99,
        difficulty: RaceDifficulty.EASY,
        max_participants: 80,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 5,
        raid_id: 4,
        time_start: '20:00',
        time_end: '23:45',
        competitive: true,
        age_min: 18,
        age_max: 99,
        difficulty: RaceDifficulty.MEDIUM,
        max_participants: 55,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 6,
        raid_id: 5,
        time_start: '10:00',
        time_end: '14:00',
        competitive: false,
        age_min: 0,
        age_max: 99,
        difficulty: RaceDifficulty.EASY,
        max_participants: 70,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 7,
        raid_id: 6,
        time_start: '05:30',
        time_end: '19:30',
        competitive: true,
        age_min: 16,
        age_max: 99,
        difficulty: RaceDifficulty.HARD,
        max_participants: 35,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 8,
        raid_id: 7,
        time_start: '18:00',
        time_end: '20:30',
        competitive: true,
        age_min: 12,
        age_max: 99,
        difficulty: RaceDifficulty.MEDIUM,
        max_participants: 90,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 9,
        raid_id: 8,
        time_start: '09:30',
        time_end: '13:00',
        competitive: false,
        age_min: 0,
        age_max: 99,
        difficulty: RaceDifficulty.EASY,
        max_participants: 100,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
    {
        id: 10,
        raid_id: 9,
        time_start: '04:00',
        time_end: '20:00',
        competitive: true,
        age_min: 16,
        age_max: 99,
        difficulty: RaceDifficulty.HARD,
        max_participants: 30,
        manager: undefined,
        min_participants: 0,
        min_team: 0,
        max_team: 0,
        age_middle: 0
    },
];

export const getListOfRacesByRaidId = (raidId: number) => {
    return mockRacesData.filter(race => race.raid_id === raidId);
};