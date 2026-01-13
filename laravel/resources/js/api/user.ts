import type { User } from "../model/db/userDbModel"

export const getUserWithToken = (): User => {
    return {
        name: "Magnin",
        last_name: "Christelle",
        email: "christelle.m@outlook.fr",
        role: "admin",
        id: 1,
        address: undefined,
        club: undefined,
        birth_date: "",
        phone_number: "",
        pps_form: "",
        membership_date: "",
        is_valid: false,
        gender: "",
    }
}
