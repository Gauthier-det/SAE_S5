import type { User } from "../model/db/userDbModel"

export const getUserWithToken = (): User => {
    return {
        name: "Magnin",
        first_name: "Christelle",
        email: "christelle.m@outlook.fr",
        role: "admin",
        id: 1,
    }
}
