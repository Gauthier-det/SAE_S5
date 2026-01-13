import type { RaceCreation } from "../model/domain/raceModel";
import { apiClient } from "../utils/apiClient";
import { RaceDifficulty, type Race } from '../model/db/raceDbModel';

export const createRace = async (race: RaceCreation): Promise<Race> => {
    // Controller returns { data: race }
    const response = await apiClient<{ data: any }>('/races', {
        method: 'POST',
        body: JSON.stringify(race)
    });
    return mapRaceFromBackend(response.data);
};

export const getListOfRacesByRaidId = async (raidId: number): Promise<Race[]> => {
    // Controller returns { data: races[] }
    const response = await apiClient<{ data: any[] }>(`/raids/${raidId}/races`)
    return response.data.map(mapRaceFromBackend);
};

const mapRaceFromBackend = (data: any): Race => {
    return {
        id: data.RAC_ID,
        raid_id: data.RAI_ID,
        // Backend returns ISO-like 'YYYY-MM-DD HH:mm:ss' which JS Date parses OK reliably on most browsers,
        // but replacing space with T ensures standard ISO 8601 parsing.
        time_start: data.RAC_TIME_START ? data.RAC_TIME_START.replace(' ', 'T') : '',
        time_end: data.RAC_TIME_END ? data.RAC_TIME_END.replace(' ', 'T') : '',
        competitive: data.RAC_TYPE === 'competitif' || data.RAC_TYPE === 'Compétitif',
        difficulty: data.RAC_DIFFICULTY as RaceDifficulty, // Assuming string matches enum or need mapping
        min_participants: data.RAC_MIN_PARTICIPANTS,
        max_participants: data.RAC_MAX_PARTICIPANTS,
        min_team: data.RAC_MIN_TEAMS,
        max_team: data.RAC_MAX_TEAMS,
        age_min: data.RAC_AGE_MIN,
        age_middle: data.RAC_AGE_MIDDLE,
        age_max: data.RAC_AGE_MAX,
        manager: undefined // Relations not usually loaded in list
    };
}