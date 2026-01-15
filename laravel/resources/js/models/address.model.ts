export interface Address {
    ADD_ID: number;
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
    ADD_STREET_NAME?: string;
    ADD_STREET_NUMBER?: string;
}

export interface AddressCreation {
    ADD_POSTAL_CODE: string;
    ADD_CITY: string;
    ADD_STREET_NAME: string;
    ADD_STREET_NUMBER: string;
}
