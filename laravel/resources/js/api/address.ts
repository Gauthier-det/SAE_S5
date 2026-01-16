import type { Address, AddressCreation } from "../models";
import { apiClient } from "../utils/apiClient";

export const createAddress = async (address: AddressCreation): Promise<number> => {
    // Ensure all fields are present, even if empty strings
    const payload = {
        ADD_STREET_NUMBER: address.ADD_STREET_NUMBER || null,
        ADD_STREET_NAME: address.ADD_STREET_NAME || null,
        ADD_CITY: address.ADD_CITY,
        ADD_POSTAL_CODE: parseInt(address.ADD_POSTAL_CODE)
    };

    const response = await apiClient<{ data: Address }>(
        '/addresses', {
        method: 'POST',
        body: JSON.stringify(payload)
    });

    return response.data.ADD_ID;
};

export const createAddressWithFullData = async (address: AddressCreation): Promise<Address> => {
    // Ensure all fields are present, even if empty strings
    const payload = {
        ADD_STREET_NUMBER: address.ADD_STREET_NUMBER || null,
        ADD_STREET_NAME: address.ADD_STREET_NAME || null,
        ADD_CITY: address.ADD_CITY,
        ADD_POSTAL_CODE: parseInt(address.ADD_POSTAL_CODE)
    };

    const response = await apiClient<{ data: Address }>(
        '/addresses', {
        method: 'POST',
        body: JSON.stringify(payload)
    });

    return response.data;
};

export const updateAddress = async (id: number, address: Partial<Omit<Address, 'ADD_ID'>>): Promise<number> => {
    const payload: any = { ...address };
    if (address.ADD_POSTAL_CODE) {
        payload.ADD_POSTAL_CODE = parseInt(address.ADD_POSTAL_CODE as unknown as string, 10);
    }

    const response = await apiClient<{ data: Address }>(`/addresses/${id}`, {
        method: 'PUT',
        body: JSON.stringify(payload)
    });
    return response.data.ADD_ID;
};

export const saveOrUpdateAddress = async (addressId: number | null | undefined, addressData: AddressCreation): Promise<Address> => {
    if (addressId) {
        // Mise à jour d'une adresse existante
        await updateAddress(addressId, addressData);
        return { ADD_ID: addressId, ...addressData } as Address;
    } else {
        // Création d'une nouvelle adresse
        const newAddress = await createAddressWithFullData(addressData);
        return newAddress;
    }
};
