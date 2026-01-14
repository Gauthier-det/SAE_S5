import type { Club } from "../model/db/clubDbModel";


export const getListOfClubs = () : Club[] => {
    return [
        {
            id: "1",
            name: "Club 1",
            manager: "1",
        },
        {
            id: "2",
            name: "Club 2",
            manager: "2",
        },
        {
            id: "3",
            name: "Club 3",
            manager: "3",
        },
        {
            id: "4",
            name: "Club 4",
            manager: "4",
        },
    ];
};

export const getListOfClubManagers = () => {
    return getListOfClubs().map(club => club.manager);
};