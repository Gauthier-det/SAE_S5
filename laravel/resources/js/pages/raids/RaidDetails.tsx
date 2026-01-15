import { Container, Typography, Box, Button, Checkbox, FormControlLabel, FormGroup, Slider } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaidById } from '../../api/raid';
import { getListOfRacesByRaidId } from '../../api/race';
import type { Raid } from '../../models/raid.model';
import { RaceType, type Race } from '../../models/race.model';
import RaceCard from '../../components/cards/RaceCard';
import React, { useEffect, useState } from 'react';
import { formatDate } from '../../utils/dateUtils';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import GroupIcon from '@mui/icons-material/Group';
import CalendarTodayIcon from '@mui/icons-material/CalendarToday';
import EventIcon from '@mui/icons-material/Event';
import EmailIcon from '@mui/icons-material/Email';
import PhoneIcon from '@mui/icons-material/Phone';
import LanguageIcon from '@mui/icons-material/Language';
import { useUser } from '../../contexts/userContext';

export default function InfoRaid() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const [raid, setRaid] = useState<Raid | null>(null);
    const [allRaces, setAllRaces] = useState<Race[]>([]);
    const { user,isRaidManager } = useUser();
    

    useEffect(() => {
        if (!id) navigate('/raids');
        const raidId = parseInt(id!);
        getRaidById(raidId).then(setRaid).catch(console.error);
        getListOfRacesByRaidId(raidId).then(setAllRaces).catch(console.error);
    }, [id]);
    const [raceType, setRaceType] = React.useState<Set<string>>(new Set());

    // Calculate global min/max for the slider bounds
    const limits = React.useMemo(() => {
        if (allRaces.length === 0) return { min: 0, max: 100 };
        const mins = allRaces.map(r => r.RAC_AGE_MIN);
        const maxs = allRaces.map(r => r.RAC_AGE_MAX);
        return {
            min: Math.min(...mins),
            max: Math.max(...maxs)
        };
    }, [allRaces]);

    const [ageRange, setAgeRange] = useState<number[]>([0, 100]);

    // Update range when limits change
    useEffect(() => {
        if (allRaces.length > 0) {
            setAgeRange([limits.min, limits.max]);
        }
    }, [limits, allRaces.length]);

    const handleTypeChange = (type: string) => {
        const newFilter = new Set(raceType);
        if (newFilter.has(type)) {
            newFilter.delete(type);
        } else {
            newFilter.add(type);
        }
        setRaceType(newFilter);
    };

    const handleAgeChange = (_event: Event, newValue: number | number[]) => {
        setAgeRange(newValue as number[]);
    };

    const filteredRaces = React.useMemo(() => {
        return allRaces.filter((race) => {
            const matchesType = raceType.size === 0 ||
                (raceType.has('Compétitif') && race.RAC_TYPE === RaceType.Competitive) ||
                (raceType.has('Loisir') && race.RAC_TYPE === RaceType.Hobby);

            const matchesAge = race.RAC_AGE_MIN >= ageRange[0] && race.RAC_AGE_MAX <= ageRange[1];

            return matchesType && matchesAge;
        });
    }, [allRaces, raceType, ageRange]);


    if (!raid) {
        return (
            <Container maxWidth="md">
                <Box sx={{ my: 4, textAlign: 'center' }}>
                    <Typography variant="h4" gutterBottom>
                        Raid non trouvé
                    </Typography>
                    <Button variant="contained" onClick={() => navigate('/raids')}>
                        Retour aux raids
                    </Button>
                </Box>
            </Container>
        );
    }

    const handleRaceDetails = (raceId: number) => {
        navigate(`/races/${raceId}`);
    }

    return (
        <Container maxWidth={false}>
            <Box sx={{ my: 4 }}>
                <Button
                    variant="text"
                    onClick={() => navigate('/raids')}
                    sx={{ mb: 2 }}
                >
                    ← Retour aux raids
                </Button>

                <Box sx={{ display: 'flex', gap: 4 }}>
                    <Box
                        sx={{
                            width: 280,
                            flexShrink: 0,
                            display: 'flex',
                            flexDirection: 'column',
                            gap: 3,
                            p: 3,
                            backgroundColor: '#f5f5f5',
                            borderRadius: 2,
                            height: 'fit-content',
                        }}
                    >
                        <Typography variant="h6" sx={{ fontWeight: 'bold' }}>
                            Filtres
                        </Typography>

                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 600, mb: 2 }}>
                                Type
                            </Typography>
                            <FormGroup>
                                <FormControlLabel
                                    control={<Checkbox
                                        checked={raceType.has('Compétitif')}
                                        onChange={() => handleTypeChange('Compétitif')}
                                    />}
                                    label="Compétitif"
                                />
                                <FormControlLabel
                                    control={<Checkbox
                                        checked={raceType.has('Loisir')}
                                        onChange={() => handleTypeChange('Loisir')}
                                    />}
                                    label="Loisir"
                                />
                            </FormGroup>
                        </Box>

                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 600, mb: 2 }}>
                                Age (ans)
                            </Typography>
                            <Box sx={{ px: 1 }}>
                                <Slider
                                    value={ageRange}
                                    onChange={handleAgeChange}
                                    valueLabelDisplay="auto"
                                    min={limits.min}
                                    max={limits.max}
                                />
                                <Box sx={{ display: 'flex', justifyContent: 'space-between' }}>
                                    <Typography variant="body2" color="text.secondary">
                                        {ageRange[0]} ans
                                    </Typography>
                                    <Typography variant="body2" color="text.secondary">
                                        {ageRange[1]} ans
                                    </Typography>
                                </Box>
                            </Box>
                        </Box>



                    </Box>
                    <Box sx={{ flex: 1 }}>
                        <Box sx={{ mb: 4 }}>
                            <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 3 }}>
                                <Typography variant="h3" component="h1" sx={{ fontWeight: 'bold', color: '#1a1a1a' }}>
                                    {raid.RAI_NAME}
                                </Typography>
                                {user && raid && user.USE_ID === raid.USE_ID && isRaidManager && (
                                    <Button
                                        variant="contained"
                                        color="success"
                                        onClick={() => navigate(`/raids/${id}/create`)}
                                        sx={{ borderRadius: '8px', fontSize: '1rem' }}
                                    >
                                        Créer une course
                                    </Button>
                                )}
                            </Box>

                            {/* Club and Location Row */}
                            <Box sx={{ display: 'flex', gap: 4, mb: 3, flexWrap: 'wrap', alignItems: 'center' }}>
                                {raid.club && (
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                        <GroupIcon color="primary" />
                                        <Typography variant="body1" sx={{ fontWeight: 500 }}>
                                            {raid.club.CLU_NAME}
                                        </Typography>
                                    </Box>
                                )}
                                {raid.address && (
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                        <LocationOnIcon color="error" />
                                        <Typography variant="body1" sx={{ fontWeight: 500 }}>
                                            {raid.address.ADD_STREET_NUMBER} {raid.address.ADD_STREET_NAME}, {raid.address.ADD_CITY} ({raid.address.ADD_POSTAL_CODE})
                                        </Typography>
                                    </Box>
                                )}
                            </Box>

                            {/* Info Cards */}
                            <Box sx={{ display: 'flex', gap: 3, mb: 4, flexWrap: 'wrap' }}>
                                <Box sx={{ p: 2, backgroundColor: '#e3f2fd', borderRadius: 2, minWidth: 200 }}>
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, mb: 1 }}>
                                        <CalendarTodayIcon fontSize="small" color="primary" />
                                        <Typography variant="caption" color="text.secondary" sx={{ textTransform: 'uppercase', letterSpacing: 1 }}>
                                            DATES DU RAID
                                        </Typography>
                                    </Box>
                                    <Typography variant="body1" sx={{ fontWeight: 600 }}>
                                        Du {formatDate(raid.RAI_TIME_START)} au {formatDate(raid.RAI_TIME_END)}
                                    </Typography>
                                </Box>
                                <Box sx={{ p: 2, backgroundColor: '#fff3e0', borderRadius: 2, minWidth: 200 }}>
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, mb: 1 }}>
                                        <EventIcon fontSize="small" color="warning" />
                                        <Typography variant="caption" color="text.secondary" sx={{ textTransform: 'uppercase', letterSpacing: 1 }}>
                                            INSCRIPTIONS
                                        </Typography>
                                    </Box>
                                    <Typography variant="body1" sx={{ fontWeight: 600 }}>
                                        Du {formatDate(raid.RAI_REGISTRATION_START)} au {formatDate(raid.RAI_REGISTRATION_END)}
                                    </Typography>
                                </Box>
                            </Box>

                            {/* Contact Info */}
                            <Box sx={{ display: 'flex', gap: 3, mb: 3, flexWrap: 'wrap' }}>
                                {raid.RAI_MAIL && (
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                        <EmailIcon fontSize="small" color="action" />
                                        <Typography variant="body2" color="text.secondary">
                                            {raid.RAI_MAIL}
                                        </Typography>
                                    </Box>
                                )}
                                {raid.RAI_PHONE_NUMBER && (
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                        <PhoneIcon fontSize="small" color="action" />
                                        <Typography variant="body2" color="text.secondary">
                                            {raid.RAI_PHONE_NUMBER}
                                        </Typography>
                                    </Box>
                                )}
                                {raid.RAI_WEB_SITE && (
                                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                        <LanguageIcon fontSize="small" color="action" />
                                        <Typography
                                            component="a"
                                            href={raid.RAI_WEB_SITE}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            variant="body2"
                                            sx={{ color: 'primary.main', textDecoration: 'none', '&:hover': { textDecoration: 'underline' } }}
                                        >
                                            Site web
                                        </Typography>
                                    </Box>
                                )}
                            </Box>

                            <Typography variant="h5" sx={{ mb: 2, fontWeight: 600, borderBottom: '2px solid #f97316', pb: 1, display: 'inline-block' }}>
                                {filteredRaces.length} épreuves disponibles
                            </Typography>
                        </Box>

                        <Box
                            sx={{
                                display: 'grid',
                                gap: 3,
                                gridTemplateColumns: {
                                    xs: '1fr',
                                    sm: 'repeat(2, 1fr)',
                                    md: 'repeat(2, 1fr)',
                                    lg: 'repeat(3, 1fr)'
                                }
                            }}
                        >
                            {filteredRaces.map((race) => (
                                <Box key={race.RAC_ID}>
                                    <RaceCard race={race} onDetailsClick={handleRaceDetails} />
                                </Box>
                            ))}
                        </Box>
                    </Box>
                </Box>
            </Box>
        </Container>
    );
}
