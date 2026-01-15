import type { RaceCreation, Race, RaceResponse, RaceDetail, RaceDetailResponse } from "../models/race.model";
import { apiClient } from "../utils/apiClient";

export const getListOfRace = async (): Promise<Race[]> => {
    const response = await apiClient<RaceResponse>('/races');
    return response.data;
};

export const getListOfRaceManagers = async (): Promise<number[]> => {
    const response = await getListOfRace();
    return response.map((race) => race.user.USE_ID);
};

export const getListOfRacesByRaidId = async (raidId: number): Promise<Race[]> => {
    const response = await apiClient<RaceResponse>(`/raids/${raidId}/races`);
    return response.data;
};

export const getRaceDetails = async (id: number): Promise<RaceDetail> => {
    const response = await apiClient<RaceDetailResponse>(`/races/${id}/details`);
    return response.data;
};

export const createRaceWithPrices = async (race: RaceCreation): Promise<Race> => {
    const response = await apiClient<{ data: Race }>('/races/with-prices', {
        method: 'POST',
        body: JSON.stringify(race)
    });
    return response.data;
};

export const getRaceById = async (id: number): Promise<Race> => {
    const response = await apiClient<{ data: Race }>(`/races/${id}`);
    return response.data;
};

export const importRaceResults = async (raceId: number, file: File) => {
    const formData = new FormData();
    formData.append('file', file);

    return await apiClient<{ message: string; details: any[] }>(`/races/${raceId}/import-results`, {
        method: 'POST',
        body: formData,
    });
};

export const deleteRaceResults = async (raceId: number) => {
    return await apiClient<{ message: string; }>(`/races/${raceId}/results`, {
        method: 'DELETE',
    });
};

export const updateRace = async (raceId: number, race: Partial<RaceCreation>): Promise<Race> => {
    const response = await apiClient<{ data: Race }>(`/races/${raceId}`, {
        method: 'PUT',
        body: JSON.stringify(race)
    });
    return response.data;
}

export const getRaceByIdWithPrice = async (id: number): Promise<Race> => {
    const response = await apiClient<{ data: Race }>(`/races/${id}/with-price`);
    return response.data;
};

export const updateRaceWithPrices = async (id: number, race: RaceCreation): Promise<Race> => {
    const response = await apiClient<{ data: Race }>(`/races/${id}`, {
        method: 'PUT',
        body: JSON.stringify(race)
    });
    return response.data;
};

export const deleteRace = async (id: number): Promise<void> => {
    await apiClient(`/races/${id}`, {
        method: 'DELETE'
    });
};
