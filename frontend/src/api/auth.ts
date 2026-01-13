import type { User } from "../model/db/userDbModel";
import type { Login } from "../model/domain/loginModel";



export const apiLogin = async (login: Login): Promise<{ token: string; user: User }> => {
    return {
        token: "fake-jwt-token-123456",
        user: {
            name: "Magnin",
            first_name: "Christelle",
            email: login.email,
            role: "admin",
            id: 1,
        }
    };
}