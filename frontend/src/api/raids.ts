import type { Raid } from '../model/db/raidDbModel';

const mockRaidsData: Raid[] = [
    { id: 1, name: "Raid Explorer Quest", start_date: "15 juin 2026", end_date: "16 juin 2026", events_count: 3, registration_start: "1 mai 2026", registration_end: "10 juin 2026", status: "à venir", registration_status: "confirmée" },
    { id: 2, name: "Raid de la Forêt Noire", start_date: "22 juin 2026", end_date: "23 juin 2026", events_count: 5, registration_start: "1 mai 2026", registration_end: "17 juin 2026", status: "à venir", registration_status: "non inscrit" },
    { id: 3, name: "Raid des Montagnes", start_date: "5 juillet 2026", end_date: "7 juillet 2026", events_count: 4, registration_start: "1 juin 2026", registration_end: "30 juin 2026", status: "à venir", registration_status: "en attente" },
    { id: 4, name: "Raid Nocturne", start_date: "12 juillet 2026", end_date: "13 juillet 2026", events_count: 2, registration_start: "1 juin 2026", registration_end: "7 juillet 2026", status: "à venir", registration_status: "confirmée" },
    { id: 5, name: "Raid Côtier", start_date: "20 juillet 2026", end_date: "21 juillet 2026", events_count: 6, registration_start: "1 juin 2026", registration_end: "15 juillet 2026", status: "à venir", registration_status: "non inscrit" },
    { id: 6, name: "Raid du Désert", start_date: "28 juillet 2026", end_date: "30 juillet 2026", events_count: 3, registration_start: "15 juin 2026", registration_end: "23 juillet 2026", status: "à venir", registration_status: "confirmée" },
    { id: 7, name: "Raid Urbain", start_date: "5 août 2026", end_date: "6 août 2026", events_count: 4, registration_start: "15 juin 2026", registration_end: "1 août 2026", status: "à venir", registration_status: "en attente" },
    { id: 8, name: "Raid des Lacs", start_date: "15 août 2026", end_date: "16 août 2026", events_count: 5, registration_start: "1 juillet 2026", registration_end: "10 août 2026", status: "à venir", registration_status: "confirmée" },
    { id: 9, name: "Raid Extrême", start_date: "25 août 2026", end_date: "27 août 2026", events_count: 7, registration_start: "1 juillet 2026", registration_end: "20 août 2026", status: "à venir", registration_status: "non inscrit" },
    { id: 10, name: "Raid des Collines", start_date: "1 septembre 2026", end_date: "2 septembre 2026", events_count: 3, registration_start: "1 août 2026", registration_end: "27 août 2026", status: "à venir", registration_status: "confirmée" },
    { id: 11, name: "Raid Aventure", start_date: "10 septembre 2026", end_date: "12 septembre 2026", events_count: 6, registration_start: "1 août 2026", registration_end: "5 septembre 2026", status: "à venir", registration_status: "non inscrit" },
    { id: 12, name: "Raid Challenge", start_date: "20 septembre 2026", end_date: "21 septembre 2026", events_count: 4, registration_start: "1 août 2026", registration_end: "15 septembre 2026", status: "à venir", registration_status: "en attente" },
];



export const getListOfRaids = () => {
    return mockRaidsData;
}