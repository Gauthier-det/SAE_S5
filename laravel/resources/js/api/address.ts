import { apiClient } from "../utils/apiClient";
import type { Address } from "../models/user.model";

export interface AddressResponse {
    data: Address;
}

export const createAddress = async (address: Omit<Address, 'ADD_ID'>): Promise<Address> => {
    // Ensure all fields are present, even if empty strings
    const payload = {
        ADD_STREET_NUMBER: address.ADD_STREET_NUMBER || null,
        ADD_STREET_NAME: address.ADD_STREET_NAME || null,
        ADD_CITY: address.ADD_CITY,
        ADD_POSTAL_CODE: parseInt(address.ADD_POSTAL_CODE, 10)
    };

    const response = await apiClient<AddressResponse>('/addresses', {
        method: 'POST',
        body: JSON.stringify(payload)
    });
    return response.data;
};

export const updateAddress = async (id: number, address: Partial<Omit<Address, 'ADD_ID'>>): Promise<Address> => {
    const payload: any = { ...address };
    if (address.ADD_POSTAL_CODE) {
        payload.ADD_POSTAL_CODE = parseInt(address.ADD_POSTAL_CODE as unknown as string, 10);
    }

    const response = await apiClient<AddressResponse>(`/addresses/${id}`, {
        method: 'PUT',
        body: JSON.stringify(payload)
    });
    return response.data;
};
