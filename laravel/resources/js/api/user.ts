import type { User } from "../model/db/userDbModel"
import { apiClient } from "../utils/apiClient";

export const getUser = async (): Promise<User> => {
    return apiClient<User>('/user', {
        method: 'GET'
    });
}
