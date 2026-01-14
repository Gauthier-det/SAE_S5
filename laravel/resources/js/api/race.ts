import type { RaceCreation, Race, RaceResponse } from "../models/race.model";
import { apiClient } from "../utils/apiClient";

export const createRace = async (race: RaceCreation): Promise<Race> => {
    const response = await apiClient<{ data: Race }>('/races', {
        method: 'POST',
        body: JSON.stringify(race)
    });
    return response.data;
};

export const getListOfRace = async (): Promise<Race[]> => {
    const response = await apiClient<RaceResponse>('/races');
    return response.data;
};

export const getListOfRaceManagers = async (): Promise<number[]> => {
    const response = await getListOfRace();
    return response.map((race) => race.RAI_ID);
};

export const getListOfRacesByRaidId = async (raidId: number): Promise<Race[]> => {
    const response = await apiClient<RaceResponse>(`/raids/${raidId}/races`);
    return response.data;
};