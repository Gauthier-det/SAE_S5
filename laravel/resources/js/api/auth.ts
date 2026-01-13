import type { User } from "../model/db/userDbModel";
import type { Login, Register } from "../model/domain/authModel";

export const apiLogin = async (login: Login): Promise<{ token: string; user: User }> => {
    return {
        token: "fake-jwt-token-123456",
        user: {
            name: "Magnin",
            last_name: "Christelle",
            email: login.email,
            role: "admin",
            id: "1",
            address: undefined,
            club: undefined,
            birth_date: "",
            phone_number: "",
            pps_form: "",
            membership_date: "",
            is_valid: false,
            gender: ""
        }
    };
}

export const apiRegister = async (register: Register): Promise<{ token: string, user: User }> => {
    return {
        token: "fake-jwt-token-123456",
        user: {
            name: register.name,
            last_name: register.last_name,
            email: register.email,
            role: "user",
            id: "2",
            address: undefined,
            club: undefined,
            birth_date: "",
            phone_number: "",
            pps_form: "",
            membership_date: "",
            is_valid: false,
            gender: ""
        }
    };
}
