import type { User } from "../models/user.model"
import { apiClient } from "../utils/apiClient";

export const getUser = async (): Promise<User> => {
    return apiClient<User>('/user', {
        method: 'GET'
    });
}
