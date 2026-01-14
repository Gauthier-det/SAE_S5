export const formatDate = (dateStr: string, options?: Intl.DateTimeFormatOptions): string => {
    if (!dateStr) return 'N/A';
    const defaultOptions: Intl.DateTimeFormatOptions = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };
    return new Date(dateStr).toLocaleDateString('fr-FR', options || defaultOptions);
};

export const getRaidStatus = (start: string, end: string): string => {
    const now = new Date().toISOString();
    const startDate = new Date(start).toISOString();
    const endDate = new Date(end).toISOString();
    if (now < startDate) return 'À venir';
    if (startDate <= now && now <= endDate) return 'En cours';
    return 'Terminé';
};

export const getRegistrationStatus = (start: string, end: string): string => {
    const now = new Date().toISOString();
    const startDate = new Date(start).toISOString();
    const endDate = new Date(end).toISOString();
    if (now < startDate) return 'Non ouverte';
    if (startDate <= now && now <= endDate) return 'Ouverte';
    return 'Close';
};

export const parseDateToTs = (str: string): number => {
    if (!str) return NaN;
    // Handle ISO format
    if (str.includes('T') || str.includes('-')) {
        return new Date(str).getTime();
    }

    // Handle legacy French format: "15 juin 2024"
    const months: Record<string, number> = {
        janvier: 0,
        février: 1,
        fevrier: 1,
        mars: 2,
        avril: 3,
        mai: 4,
        juin: 5,
        juillet: 6,
        août: 7,
        aout: 7,
        septembre: 8,
        octobre: 9,
        novembre: 10,
        décembre: 11,
        decembre: 11,
    };

    const parts = str.trim().toLowerCase().split(/\s+/);
    if (parts.length < 3) return NaN;

    const day = parseInt(parts[0], 10);
    const monthName = parts[1];
    const year = parseInt(parts[2], 10);
    const month = months[monthName];

    if (Number.isNaN(day) || Number.isNaN(year) || month === undefined) return NaN;
    return new Date(year, month, day).getTime();
};
