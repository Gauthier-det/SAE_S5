import type { User } from "../model/db/userDbModel"
import { getListOfClubManagers } from "./club";
import { getListOfRaidManagers } from "./raid";

export const getUserWithToken = (): User => {
    return {
        name: "Magnin",
        last_name: "Christelle",
        email: "christelle.m@outlook.fr",
        role: "admin",
        id: "1",
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


export const isClubManager = (userId: string) => {
    return getListOfClubManagers().includes(userId);
}

export const isRaidManager = (userId: string) => {
    return getListOfRaidManagers().includes(userId);
}
    