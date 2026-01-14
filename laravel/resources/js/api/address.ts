import { apiClient } from "../utils/apiClient";

export interface Address {
    ADD_NUMBER?: string; // Optional (e.g. "12 bis")
    ADD_LABEL: string; // Street name
    ADD_CITY: string;
    ADD_ZIP_CODE: string;
}

export interface AddressResponse {
    data: {
        ADD_ID: number;
        // ... other fields
    };
}

export const createAddress = async (address: Address): Promise<number> => {
    // Assuming backend has POST /addresses or similar. 
    // If not, we might need to adjust or mock.
    // Based on RaidController, it expects ADD_ID, meaning address likely needs to exist.
    const response = await apiClient<AddressResponse>('/addresses', {
        method: 'POST',
        body: JSON.stringify(address)
    });
    return response.data.ADD_ID;
};
