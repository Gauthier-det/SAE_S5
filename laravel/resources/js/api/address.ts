import { apiClient } from "../utils/apiClient";

export interface Address {
    ADD_STREET_NUMBER: string;
    ADD_STREET_NAME: string;
    ADD_CITY: string;
    ADD_POSTAL_CODE: string;
}

export interface AddressResponse {
    data: {
        ADD_ID: number;
        ADD_STREET_NUMBER: string;
        ADD_STREET_NAME: string;
        ADD_CITY: string;
        ADD_POSTAL_CODE: number;
    };
}

export const createAddress = async (address: Address): Promise<number> => {
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
