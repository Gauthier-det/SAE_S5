import { Container, Typography, Box, MenuItem, TextField } from '@mui/material';
import RaidCard from '../../components/cards/RaidCard';
import { getListOfRaids } from '../../api/raid';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import React from 'react';
import { Dayjs } from 'dayjs';
import 'dayjs/locale/fr';
import type { Raid } from '../../models/raid.model';
import { useNavigate } from 'react-router-dom';
import { Button } from '@mui/material';
import AddIcon from '@mui/icons-material/Add';
import { parseDateToTs } from '../../utils/dateUtils';



export default function Raids() {
    const [startDate, setStartDate] = React.useState<Dayjs | null>(null);
    const [endDate, setEndDate] = React.useState<Dayjs | null>(null);
    const [club, setClub] = React.useState('');
    const [keyword, setKeyword] = React.useState('');
    const navigate = useNavigate();

    const [raids, setRaids] = React.useState<Raid[]>([]);
    // Actually, I should use useMemo for filteredRaids but fetch in useEffect

    React.useEffect(() => {
        const fetchRaids = async () => {
            try {
                const data = await getListOfRaids();
                setRaids(data);
            } catch (error) {
                console.error("Failed to fetch raids", error);
            }
        };
        fetchRaids();
    }, []);

    const filteredRaids = React.useMemo(() => {

        const startTs = startDate ? startDate.valueOf() : null;
        const endTs = endDate ? endDate.valueOf() : null;

        return raids.filter((raid) => {
            const raidStartTs = parseDateToTs(raid.RAI_TIME_START);
            const raidEndTs = parseDateToTs(raid.RAI_TIME_END);

            const matchesStart = startTs != null ? raidEndTs >= startTs : true;
            const matchesEnd = endTs != null ? raidStartTs <= endTs : true;

            const matchesKeyword = keyword
                ? raid.RAI_NAME.toLowerCase().includes(keyword.toLowerCase())
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
                        {filteredRaids.length} raids trouvés

                        <Box sx={{ display: 'flex', justifyContent: 'flex-end', mb: 3 }}>
                            <Button
                                variant="contained"
                                color="success"
                                startIcon={<AddIcon />}
                                onClick={() => navigate('/create-raid')}
                                sx={{
                                    bgcolor: '#1b5e20',
                                    '&:hover': { bgcolor: '#144a19' }
                                }}
                            >
                                CRÉER UN RAID
                            </Button>
                        </Box>

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
                                <Box key={raid.RAI_ID}>
                                    <RaidCard raid={raid} onDetailsClick={handleRaidDetails} />
                                </Box>
                            ))}
                        </Box>
                    </Box>
                </Box>
            </Box>
        </Container >
    );
}
