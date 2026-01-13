import { Container, Typography, Box, MenuItem, TextField} from '@mui/material';
import RaidCard from '../components/RaidCard';
import { getListOfRaids } from '../api/raids';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import React from 'react';
import { Dayjs } from 'dayjs';
import 'dayjs/locale/fr';



export default function Raids() {
    const [startDate, setStartDate] = React.useState<Dayjs | null>(null);
    const [endDate, setEndDate] = React.useState<Dayjs | null>(null);
    const [club, setClub] = React.useState('');
    const [keyword, setKeyword] = React.useState('');

    const raids = React.useMemo(() => getListOfRaids(), []);

    const filteredRaids = React.useMemo(() => {
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

        const parseFrDateToTs = (str: string) => {
            const parts = str.trim().toLowerCase().split(/\s+/);
            const day = parseInt(parts[0], 10);
            const monthName = parts[1];
            const year = parseInt(parts[2], 10);
            const month = months[monthName];
            if (Number.isNaN(day) || Number.isNaN(year) || month === undefined) return NaN;
            return new Date(year, month, day).getTime();
        };

        const startTs = startDate ? startDate.valueOf() : null;
        const endTs = endDate ? endDate.valueOf() : null;

        return raids.filter((raid) => {
            const raidStartTs = parseFrDateToTs(raid.start_date);
            const raidEndTs = parseFrDateToTs(raid.end_date);

            const matchesStart = startTs != null ? raidEndTs >= startTs : true;
            const matchesEnd = endTs != null ? raidStartTs <= endTs : true;

            const matchesKeyword = keyword
                ? raid.name.toLowerCase().includes(keyword.toLowerCase())
                : true;

            const matchesClub = club ? true : true; 

            return matchesStart && matchesEnd && matchesKeyword && matchesClub;
        });
    }, [raids, startDate, endDate, keyword, club]);

    

    const handleRaidDetails = (raidId: number) => {
        
    };

    return (
        <Container maxWidth={false}>
            <Box sx={{ my: 4 }}>
            <Box sx={{ display: 'flex', gap: 4 }}>
                <Box
                sx={{
                    width: 260,
                    flexShrink: 0,
                    display: 'flex',
                    flexDirection: 'column',
                    gap: 3,
                }}
                >
                <Typography variant="h6">Filtrer les raids</Typography>

                <LocalizationProvider dateAdapter={AdapterDayjs} adapterLocale="fr">
                    <DatePicker
                    label="Début"
                    value={startDate}
                    onChange={(newValue: React.SetStateAction<Dayjs | null>) => setStartDate(newValue)}
                    slotProps={{ textField: { fullWidth: true, size: 'small' } }}
                    format="DD/MM/YYYY"
                    />

                    <DatePicker
                    label="Fin"
                    value={endDate}
                    onChange={(newValue: React.SetStateAction<Dayjs | null>) => setEndDate(newValue)}
                    slotProps={{ textField: { fullWidth: true, size: 'small' } }}
                    format="DD/MM/YYYY"
                    />
                </LocalizationProvider>

                <TextField
                    label="Mot clé"
                    placeholder="Nom du raid..."
                    variant="outlined"
                    size="small"
                    fullWidth
                    value={keyword}
                    onChange={(e) => setKeyword(e.target.value)}
                />

                <Typography variant="subtitle1" sx={{ fontWeight: 600 }}>
                    Club
                </Typography>
                <TextField
                    select
                    label="Club Organisateur"
                    value={club}
                    onChange={(e) => setClub(e.target.value)}
                    size="small"
                    fullWidth
                >
                    <MenuItem value="">Tous les clubs</MenuItem>
                    <MenuItem value="club1">Club 1</MenuItem>
                    <MenuItem value="club2">Club 2</MenuItem>
                </TextField>
                </Box>
                <Box sx={{ flex: 1 }}>
                <Typography variant="h2" component="h1" gutterBottom>
                    Les Raids
                </Typography>
                <Typography variant="body1">
                    Liste des raids disponibles à l&apos;exploration.
                </Typography>
                <Typography variant="subtitle1" sx={{ mb: 2 }}>
                    {filteredRaids.length} raids trouvés
                </Typography>

                <Box
                    sx={{
                        display: 'grid',
                        gap: 3,
                        gridTemplateColumns: {
                            xs: '1fr',
                            sm: 'repeat(2, 1fr)',
                            md: 'repeat(3, 1fr)',
                            lg: 'repeat(4, 1fr)'
                        }
                    }}
                >
                    {filteredRaids.map((raid) => (
                        <Box key={raid.id}>
                            <RaidCard raid={raid} onDetailsClick={handleRaidDetails} />
                        </Box>
                    ))}
                </Box>
                </Box>
            </Box>
        </Box>
    </Container>
    );
}
