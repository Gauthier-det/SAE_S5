import { Container, Typography, Box, Button, Checkbox, FormControlLabel, FormGroup } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaidById } from '../../api/raid';
import { getListOfRacesByRaidId } from '../../api/race';
import type { Raid } from '../../models/raid.model';
import type { Race } from '../../models/race.model';
import RaceCard from '../../components/cards/RaceCard';
import React from 'react';
import { formatDate } from '../../utils/dateUtils';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import GroupIcon from '@mui/icons-material/Group';
import CalendarTodayIcon from '@mui/icons-material/CalendarToday';
import EventIcon from '@mui/icons-material/Event';
import EmailIcon from '@mui/icons-material/Email';
import PhoneIcon from '@mui/icons-material/Phone';
import LanguageIcon from '@mui/icons-material/Language';

export default function InfoRaid() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const [raid, setRaid] = React.useState<Raid | null>(null);
    const [allRaces, setAllRaces] = React.useState<Race[]>([]);

    React.useEffect(() => {
        if (id) {
            const raidId = parseInt(id, 10);
            getRaidById(raidId).then(setRaid).catch(console.error);
            getListOfRacesByRaidId(raidId).then(setAllRaces).catch(console.error);
        }
    }, [id]);

    const [difficultyFilter, setDifficultyFilter] = React.useState<Set<string>>(new Set(['facile', 'moyen', 'difficile']));
    const [raceType, setRaceType] = React.useState<Set<string>>(new Set());

    const handleDifficultyChange = (level: string) => {
        const newFilter = new Set(difficultyFilter);
        if (newFilter.has(level)) {
            newFilter.delete(level);
        } else {
            newFilter.add(level);
        }
        setDifficultyFilter(newFilter);
    };

    const handleTypeChange = (type: string) => {
        const newFilter = new Set(raceType);
        if (newFilter.has(type)) {
            newFilter.delete(type);
        } else {
            newFilter.add(type);
        }
        setRaceType(newFilter);
    };

    const filteredRaces = React.useMemo(() => {
        return allRaces.filter((race) => {
            // Type filter - Compétitif or Loisir
            const matchesType = raceType.size === 0 ||
                (raceType.has('Compétitif') && race.RAC_TYPE === 'Compétitif') ||
                (raceType.has('Loisir') && race.RAC_TYPE === 'Loisir');

            // Difficulty filter - normalize to lowercase for comparison
            const raceDifficulty = (race.RAC_DIFFICULTY || 'moyen').toLowerCase();
            const matchesDifficulty = difficultyFilter.size === 0 || difficultyFilter.has(raceDifficulty);

            return matchesType && matchesDifficulty;
        });
    }, [allRaces, raceType, difficultyFilter]);


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
                <Box sx={{ display: 'flex', gap: 2, mb: 2 }}>
                    <Button
                        variant="text"
                        onClick={() => navigate('/raids')}
                    >
                        ← Retour aux raids
                    </Button>
                    <Button
                        variant="contained"
                        color="primary"
                        onClick={() => navigate(`/create-race?raidId=${raid.RAI_ID}`)}
                    >
                        Créer une course
                    </Button>
                </Box>

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
                                Difficulté
                            </Typography>
                            <Box sx={{ px: 1 }}>
                                <FormGroup>
                                    <FormControlLabel
                                        control={<Checkbox
                                            checked={difficultyFilter.has('facile')}
                                            onChange={() => handleDifficultyChange('facile')}
                                        />}
                                        label="Facile"
                                    />
                                    <FormControlLabel
                                        control={<Checkbox
                                            checked={difficultyFilter.has('moyen')}
                                            onChange={() => handleDifficultyChange('moyen')}
                                        />}
                                        label="Moyen"
                                    />
                                    <FormControlLabel
                                        control={<Checkbox
                                            checked={difficultyFilter.has('difficile')}
                                            onChange={() => handleDifficultyChange('difficile')}
                                        />}
                                        label="Difficile"
                                    />
                                </FormGroup>
                            </Box>
                        </Box>

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
                    </Box>

                    <Box sx={{ flex: 1 }}>
                        <Box sx={{ mb: 4 }}>
                            <Typography variant="h3" component="h1" gutterBottom sx={{ fontWeight: 'bold', color: '#1a1a1a' }}>
                                {raid.RAI_NAME}
                            </Typography>

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
