export interface User {
    USE_ID: number;
    USE_NAME: string;
    USE_LAST_NAME: string;
    USE_MAIL: string;
    USE_PASSWORD: string;
    CLU_ID?: number;
}

export interface UserResponse {
    data: User;
}
