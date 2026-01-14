import type { RaceCreation, Race, RaceResponse } from "../models/race.model";
import { apiClient } from "../utils/apiClient";

export const createRace = async (race: RaceCreation): Promise<Race> => {
    // Map des prix pour l'endpoint with-prices
    const payload: any = {
        USE_ID: race.USE_ID,
        RAI_ID: race.RAI_ID,
        RAC_TIME_START: race.RAC_TIME_START,
        RAC_TIME_END: race.RAC_TIME_END,
        RAC_TYPE: race.RAC_TYPE,
        RAC_DIFFICULTY: race.RAC_DIFFICULTY,
        RAC_MIN_PARTICIPANTS: race.RAC_MIN_PARTICIPANTS,
        RAC_MAX_PARTICIPANTS: race.RAC_MAX_PARTICIPANTS,
        RAC_MIN_TEAMS: race.RAC_MIN_TEAMS,
        RAC_MAX_TEAMS: race.RAC_MAX_TEAMS,
        RAC_TEAM_MEMBERS: race.RAC_TEAM_MEMBERS,
        RAC_AGE_MIN: race.RAC_AGE_MIN,
        RAC_AGE_MIDDLE: race.RAC_AGE_MIDDLE,
        RAC_AGE_MAX: race.RAC_AGE_MAX,
        CAT_1_PRICE: race.minor,
        CAT_2_PRICE: race.major,
        CAT_3_PRICE: race.licensed,
    };

    const response = await apiClient<{ data: Race }>("/races/with-prices", {
        method: 'POST',
        body: JSON.stringify(payload)
    });
    return response.data;
};

export const getListOfRacesByRaidId = async (raidId: number): Promise<Race[]> => {
    const response = await apiClient<RaceResponse>(`/raids/${raidId}/races/with-prices`);
    return response.data;
};