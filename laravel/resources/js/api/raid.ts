import type { RaidCreation } from '../model/domain/raidModel';
import { apiClient } from "../utils/apiClient";
import type { Raid } from '../model/db/raidDbModel';

export const createRaid = async (raid: RaidCreation): Promise<Raid> => {
    // Note: Assuming create returns the new raid in { data: ... } or direct.
    // Based on controller: return response()->json(['data' => $raid], 201);
    const response = await apiClient<{ data: any }>('/raids', {
        method: 'POST',
        body: JSON.stringify(raid)
    });
    return mapRaidFromBackend(response.data);
};

export const getListOfRaids = async (): Promise<Raid[]> => {
    const response = await apiClient<{ data: any[] }>('/raids');
    return response.data.map(mapRaidFromBackend);
}

export const getRaidById = async (id: number): Promise<Raid> => {
    const response = await apiClient<{ data: any }>(`/raids/${id}`);
    return mapRaidFromBackend(response.data);
}

const mapRaidFromBackend = (data: any): Raid => {
    return {
        id: data.RAI_ID,
        name: data.RAI_NAME,
        mail: data.RAI_MAIL,
        phone_number: data.RAI_PHONE_NUMBER || '',
        website: data.RAI_WEB_SITE || '',
        image: data.RAI_IMAGE || '',
        time_start: data.RAI_TIME_START,
        time_end: data.RAI_TIME_END,
        registration_start: data.RAI_REGISTRATION_START,
        registration_end: data.RAI_REGISTRATION_END,
        club: undefined,
        address: undefined,
        manager: undefined
    };
}