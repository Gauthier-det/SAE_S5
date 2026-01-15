export interface Address {
    ADD_ID: number;
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
    ADD_STREET_NAME?: string;
    ADD_STREET_NUMBER?: string;
}

export type AddressCreation = Omit<Address, 'ADD_ID'>;

export interface AddressResponse {
    data: {
        ADD_ID: number;
        ADD_STREET_NUMBER: string;
        ADD_STREET_NAME: string;
        ADD_CITY: string;
        ADD_POSTAL_CODE: number;
    };
}