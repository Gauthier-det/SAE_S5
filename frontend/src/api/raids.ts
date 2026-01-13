const mockRaidsData = [
    { id: 1, name: "Raid du sanglier Fou", start_date: "15 juin 2026", end_date: "16 juin 2026", events_count: 3 },
    { id: 2, name: "Raid de la Forêt Noire", start_date: "22 juin 2026", end_date: "23 juin 2026", events_count: 5 },
    { id: 3, name: "Raid des Montagnes", start_date: "5 juillet 2026", end_date: "7 juillet 2026", events_count: 4 },
    { id: 4, name: "Raid Nocturne", start_date: "12 juillet 2026", end_date: "13 juillet 2026", events_count: 2 },
    { id: 5, name: "Raid Côtier", start_date: "20 juillet 2026", end_date: "21 juillet 2026", events_count: 6 },
    { id: 6, name: "Raid du Désert", start_date: "28 juillet 2026", end_date: "30 juillet 2026", events_count: 3 },
    { id: 7, name: "Raid Urbain", start_date: "5 août 2026", end_date: "6 août 2026", events_count: 4 },
    { id: 8, name: "Raid des Lacs", start_date: "15 août 2026", end_date: "16 août 2026", events_count: 5 },
    { id: 9, name: "Raid Extrême", start_date: "25 août 2026", end_date: "27 août 2026", events_count: 7 },
    { id: 10, name: "Raid des Collines", start_date: "1 septembre 2026", end_date: "2 septembre 2026", events_count: 3 },
    { id: 11, name: "Raid Aventure", start_date: "10 septembre 2026", end_date: "12 septembre 2026", events_count: 6 },
    { id: 12, name: "Raid Challenge", start_date: "20 septembre 2026", end_date: "21 septembre 2026", events_count: 4 },
];



export const getListOfRaids = () => {
    return mockRaidsData;
}