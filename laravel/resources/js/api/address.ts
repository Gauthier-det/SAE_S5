import type { AddressResponse, AddressCreation } from "../models";
import { apiClient } from "../utils/apiClient";


export const createAddress = async (address: AddressCreation): Promise<number> => {
    const payload = {
        ADD_STREET_NUMBER: address.ADD_STREET_NUMBER,
        ADD_STREET_NAME: address.ADD_STREET_NAME,
        ADD_CITY: address.ADD_CITY,
        ADD_POSTAL_CODE: parseInt(address.ADD_POSTAL_CODE, 10)
    };

    console.log('Sending Address Payload:', payload);

    const response = await apiClient<AddressResponse>('/addresses', {
        method: 'POST',
        body: JSON.stringify(payload)
    });
    return response.data.ADD_ID;
};
