import { Container, Typography, Box, MenuItem, TextField, Stack, Button, Divider, CircularProgress } from '@mui/material';
import RaidCard from '../../components/cards/RaidCard';
import { getListOfRaids } from '../../api/raid';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import React, { useEffect, useState } from 'react';
import { Dayjs } from 'dayjs';
import 'dayjs/locale/fr';
import type { Raid } from '../../models/raid.model';
import { useNavigate } from 'react-router-dom';
import { useAlert } from '../../contexts/AlertContext';
import { parseDateToTs, getRaidStatus, getRegistrationStatus } from '../../utils/dateUtils';
import { useUser } from '../../contexts/userContext';



export default function Raids() {
    const [startDate, setStartDate] = React.useState<Dayjs | null>(null);
    const [endDate, setEndDate] = React.useState<Dayjs | null>(null);
    const [club, setClub] = React.useState('');
    const [keyword, setKeyword] = React.useState('');
    const [statusFilter, setStatusFilter] = React.useState('');
    const [registrationFilter, setRegistrationFilter] = React.useState('');
    const [sortField, setSortField] = React.useState('');
    const [sortDirection, setSortDirection] = React.useState<'asc' | 'desc'>('asc');
    const [raids, setRaids] = useState<Raid[]>([]);
    const [loading, setLoading] = useState(true);
    const { user, isClubManager } = useUser();
    const { showAlert } = useAlert();
    const navigate = useNavigate();

    useEffect(() => {
        const fetchRaids = async () => {
            try {
                const data = await getListOfRaids();
                setRaids(data);
            } catch (error) {
                console.error("Failed to fetch raids", error);
                showAlert("Impossible de charger la liste des raids", "error");
            } finally {
                setLoading(false);
            }
        };

        fetchRaids();
    }, [showAlert]); // Added dependency to suppress lint warning, though context is stable

    const filteredRaids = React.useMemo(() => {

        const startTs = startDate ? startDate.valueOf() : null;
        const endTs = endDate ? endDate.valueOf() : null;

        const result = raids.filter((raid) => {
            const raidStartTs = parseDateToTs(raid.RAI_TIME_START);
            const raidEndTs = parseDateToTs(raid.RAI_TIME_END);

            const matchesStart = startTs != null ? raidEndTs >= startTs : true;
            const matchesEnd = endTs != null ? raidStartTs <= endTs : true;

            const matchesKeyword = keyword
                ? raid.RAI_NAME.toLowerCase().includes(keyword.toLowerCase())
                : true;

            const matchesClub = club ? raid.club?.CLU_NAME === club : true;

            const currentStatus = getRaidStatus(raid.RAI_TIME_START, raid.RAI_TIME_END);
            const matchesStatus = statusFilter ? currentStatus === statusFilter : true;

            const currentRegStatus = getRegistrationStatus(raid.RAI_REGISTRATION_START, raid.RAI_REGISTRATION_END);
            const matchesRegStatus = registrationFilter ? currentRegStatus === registrationFilter : true;

            return matchesStart && matchesEnd && matchesKeyword && matchesClub && matchesStatus && matchesRegStatus;
        });

        if (sortField) {
            result.sort((a, b) => {
                const dateA = parseDateToTs(a[sortField as keyof Raid] as string);
                const dateB = parseDateToTs(b[sortField as keyof Raid] as string);

                if (sortDirection === 'asc') {
                    return dateA - dateB;
                } else {
                    return dateB - dateA;
                }
            });
        }

        return result;
    }, [raids, startDate, endDate, keyword, club, statusFilter, registrationFilter, sortField, sortDirection]);

    // Extract unique clubs for filter dropdown
    const uniqueClubs = React.useMemo(() => {
        const clubs = raids.map(r => r.club?.CLU_NAME).filter(Boolean);
        return [...new Set(clubs)] as string[];
    }, [raids]);

    return (
        <Container maxWidth={false} sx={{ display: 'flex', flexDirection: 'column', flex: 1, overflow: 'hidden', pt: 4 }}>
            <Box sx={{ display: 'flex', flexDirection: 'column', flex: 1, minHeight: 0 }}>
                <Box sx={{ display: 'flex', gap: 4, flex: 1, minHeight: 0 }}>
                    <Box
                        sx={{
                            width: 260,
                            flexShrink: 0,
                            display: 'flex',
                            flexDirection: 'column',
                            gap: 3,
                            overflowY: 'auto',
                            pr: 2,
                        }}
                    >
                        <Typography variant="h6">Filtrer les raids</Typography>
                        <Stack direction="row" spacing={1}>
                            <TextField
                                select
                                label="Critère"
                                value={sortField}
                                onChange={(e) => setSortField(e.target.value)}
                                size="small"
                                fullWidth
                            >
                                <MenuItem value="">Aucun</MenuItem>
                                <MenuItem value="RAI_TIME_START">Début Raid</MenuItem>
                                <MenuItem value="RAI_TIME_END">Fin Raid</MenuItem>
                                <MenuItem value="RAI_REGISTRATION_START">Début Inscription</MenuItem>
                                <MenuItem value="RAI_REGISTRATION_END">Fin Inscription</MenuItem>
                            </TextField>
                            <TextField
                                select
                                label="Ordre"
                                value={sortDirection}
                                onChange={(e) => setSortDirection(e.target.value as 'asc' | 'desc')}
                                size="small"
                                sx={{ minWidth: 100 }}
                            >
                                <MenuItem value="asc">Croissant</MenuItem>
                                <MenuItem value="desc">Décroissant</MenuItem>
                            </TextField>
                        </Stack>
                        <Divider />
                        <Typography variant="subtitle1" sx={{ fontWeight: 600 }}>
                            Date
                        </Typography>
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
                        <Typography variant="subtitle1" sx={{ fontWeight: 600 }}>
                            Recherche
                        </Typography>
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
                            Statut
                        </Typography>
                        <TextField
                            select
                            label="Statut du Raid"
                            value={statusFilter}
                            onChange={(e) => setStatusFilter(e.target.value)}
                            size="small"
                            fullWidth
                        >
                            <MenuItem value="">Tous</MenuItem>
                            <MenuItem value="À venir">À venir</MenuItem>
                            <MenuItem value="En cours">En cours</MenuItem>
                            <MenuItem value="Terminé">Terminé</MenuItem>
                        </TextField>

                        <TextField
                            select
                            label="Inscriptions"
                            value={registrationFilter}
                            onChange={(e) => setRegistrationFilter(e.target.value)}
                            size="small"
                            fullWidth
                        >
                            <MenuItem value="">Toutes</MenuItem>
                            <MenuItem value="Non ouverte">Non ouverte</MenuItem>
                            <MenuItem value="Ouverte">Ouverte</MenuItem>
                            <MenuItem value="Close">Close</MenuItem>
                        </TextField>


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
                            {uniqueClubs.map((c) => (
                                <MenuItem key={c} value={c}>{c}</MenuItem>
                            ))}
                        </TextField>
                    </Box>
                    <Box sx={{ flex: 1, display: 'flex', flexDirection: 'column', height: '100%', overflow: 'hidden' }}>
                        <Stack direction="row" spacing={2} alignItems="center" justifyContent="space-between" sx={{ mb: 2 }}>
                            <Stack direction="column">
                                <Typography variant="h2" component="h1" gutterBottom>
                                    Les Raids
                                </Typography>
                                <Typography variant="body1">
                                    Liste des raids disponibles à l&apos;exploration.
                                </Typography>
                                <Typography variant="subtitle1" sx={{ mb: 2 }}>
                                    {filteredRaids.length} raids trouvés
                                </Typography>
                            </Stack>
                            {user && isClubManager && <Button
                                variant="contained"
                                color="warning"
                                onClick={() => navigate('/raid/create')}
                                sx={{ color: 'white', borderRadius: '10px', fontSize: '1rem', mr: 2 }}
                            >
                                créer un raid
                            </Button>
                            }
                        </Stack>
                        <Box
                            sx={{
                                display: 'grid',
                                gap: 3,
                                gridTemplateColumns: {
                                    xs: '1fr',
                                    sm: 'repeat(2, 1fr)',
                                    md: 'repeat(3, 1fr)',
                                    lg: 'repeat(4, 1fr)'
                                },
                                alignItems: 'stretch',
                                p: 3,
                                flex: 1,
                                overflowY: 'auto',
                                borderRadius: '10px',
                                backgroundColor: 'primary.main'
                            }}
                        >
                            {loading ? (
                                <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', width: '100%', height: '200px', gridColumn: '1 / -1' }}>
                                    <CircularProgress color="warning" />
                                </Box>
                            ) : (
                                filteredRaids.map((raid) => (
                                    <Box key={raid.RAI_ID}>
                                        <RaidCard raid={raid} />
                                    </Box>
                                ))
                            )}
                        </Box>
                    </Box>
                </Box>
            </Box>
        </Container >
    );
}
