import type { RaidCreation, Raid, RaidResponse } from '../models/raid.model';
import { apiClient } from "../utils/apiClient";

export const createRaid = async (raid: RaidCreation): Promise<Raid> => {
    const response = await apiClient<{ data: Raid }>('/raids', {
        method: 'POST',
        body: JSON.stringify(raid)
    });
    return response.data;
};

export const getListOfRaids = async (): Promise<Raid[]> => {
    const response = await apiClient<RaidResponse>('/raids');
    return response.data;
}

export const getRaidById = async (id: number): Promise<Raid> => {
    const response = await apiClient<{ data: Raid }>(`/raids/${id}`);
    return response.data;
}