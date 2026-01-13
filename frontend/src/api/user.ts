import type { User } from "../model/db/user"

export const getUserWithToken = (): User => {
    return {
        name: "Magnin",
        first_name: "Christelle",
        email: "christelle.m@outlook.fr",
        role: "admin",
        id: 1,
    }
}
