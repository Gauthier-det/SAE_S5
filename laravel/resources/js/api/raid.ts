import type { RaidCreation } from '../model/domain/raidModel';


export const createRaid = async (raid: RaidCreation): Promise<RaidCreation> => {
    return new Promise((resolve) => {
        setTimeout(() => {
            const newRaid: RaidCreation = raid;
            console.log('Raid created:', newRaid);
            resolve(newRaid);
        }, 1000);
    });
};


import type { Raid } from '../model/db/raidDbModel';

const mockRaidsData: Raid[] = [
    {
        id: 1, name: "Raid Explorer Quest", time_start: "15 juin 2026", time_end: "16 juin 2026", registration_start: "1 mai 2026", registration_end: "10 juin 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 2, name: "Raid de la Forêt Noire", time_start: "22 juin 2026", time_end: "23 juin 2026", registration_start: "1 mai 2026", registration_end: "17 juin 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 3, name: "Raid des Montagnes", time_start: "5 juillet 2026", time_end: "7 juillet 2026", registration_start: "1 juin 2026", registration_end: "30 juin 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 4, name: "Raid Nocturne", time_start: "12 juillet 2026", time_end: "13 juillet 2026", registration_start: "1 juin 2026", registration_end: "7 juillet 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 5, name: "Raid Côtier", time_start: "20 juillet 2026", time_end: "21 juillet 2026", registration_start: "1 juin 2026", registration_end: "15 juillet 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 6, name: "Raid du Désert", time_start: "28 juillet 2026", time_end: "30 juillet 2026", registration_start: "15 juin 2026", registration_end: "23 juillet 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 7, name: "Raid Urbain", time_start: "5 août 2026", time_end: "6 août 2026", registration_start: "15 juin 2026", registration_end: "1 août 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 8, name: "Raid des Lacs", time_start: "15 août 2026", time_end: "16 août 2026", registration_start: "1 juillet 2026", registration_end: "10 août 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 9, name: "Raid Extrême", time_start: "25 août 2026", time_end: "27 août 2026", registration_start: "1 juillet 2026", registration_end: "20 août 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 10, name: "Raid des Collines", time_start: "1 septembre 2026", time_end: "2 septembre 2026", registration_start: "1 août 2026", registration_end: "27 août 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 11, name: "Raid Aventure", time_start: "10 septembre 2026", time_end: "12 septembre 2026", registration_start: "1 août 2026", registration_end: "5 septembre 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
    {
        id: 12, name: "Raid Challenge", time_start: "20 septembre 2026", time_end: "21 septembre 2026", registration_start: "1 août 2026", registration_end: "15 septembre 2026",
        club: undefined,
        address: undefined,
        manager: undefined,
        mail: '',
        phone_number: '',
        website: '',
        image: ''
    },
];

export const getListOfRaids = () => {
    return mockRaidsData;
}