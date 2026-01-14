import { Container, Typography, Box, Button, Slider, Checkbox, FormControlLabel, FormGroup } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaidById } from '../../api/raid';
import { getListOfRacesByRaidId } from '../../api/race';
import type { Raid } from '../../models/raid.model';
import type { Race } from '../../models/race.model';
import RaceCard from '../../components/cards/RaceCard';
import React from 'react';
import { formatDate } from '../../utils/dateUtils';

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
    const [distance, setDistance] = React.useState<number[]>([0, 100]);
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
            // Type filter
            const matchesType = raceType.size === 0 ||
                (raceType.has('Compétitif') && race.RAC_TYPE === 'Compétitif') ||
                (raceType.has('Randonnée') && race.RAC_TYPE !== 'Compétitif') ||
                (raceType.has('Extrême') && race.RAC_TYPE === 'Compétitif');

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
                                Distance
                            </Typography>
                            <Box sx={{ px: 1 }}>
                                <Slider
                                    value={distance}
                                    onChange={(_, newValue) => setDistance(newValue as number[])}
                                    valueLabelDisplay="auto"
                                    min={0}
                                    max={100}
                                    sx={{
                                        color: '#2196f3',
                                        '& .MuiSlider-thumb': {
                                            backgroundColor: '#fff',
                                            border: '2px solid #2196f3',
                                        },
                                    }}
                                />
                                <Box sx={{ display: 'flex', justifyContent: 'space-between', mt: 1 }}>
                                    <Typography variant="caption" color="text.secondary">0</Typography>
                                    <Typography variant="caption" color="text.secondary">100km</Typography>
                                </Box>
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
                                        checked={raceType.has('Randonnée')}
                                        onChange={() => handleTypeChange('Randonnée')}
                                    />}
                                    label="Randonnée"
                                />
                                <FormControlLabel
                                    control={<Checkbox
                                        checked={raceType.has('Extrême')}
                                        onChange={() => handleTypeChange('Extrême')}
                                    />}
                                    label="Extrême"
                                />
                            </FormGroup>
                        </Box>
                    </Box>

                    <Box sx={{ flex: 1 }}>
                        <Box sx={{ mb: 3 }}>
                            <Typography variant="h3" component="h1" gutterBottom sx={{ fontWeight: 'bold' }}>
                                {raid.RAI_NAME}
                            </Typography>
                            <Box sx={{ display: 'flex', gap: 4, mb: 4, flexWrap: 'wrap' }}>
                                <Box>
                                    <Typography variant="caption" color="text.secondary" sx={{ textTransform: 'uppercase', letterSpacing: 1 }}>
                                        DATES DU RAID
                                    </Typography>
                                    <Typography variant="h6">
                                        Du {formatDate(raid.RAI_TIME_START)} au {formatDate(raid.RAI_TIME_END)}
                                    </Typography>
                                </Box>
                                <Box>
                                    <Typography variant="caption" color="text.secondary" sx={{ textTransform: 'uppercase', letterSpacing: 1 }}>
                                        INSCRIPTIONS
                                    </Typography>
                                    <Typography variant="h6">
                                        Du {formatDate(raid.RAI_REGISTRATION_START)} au {formatDate(raid.RAI_REGISTRATION_END)}
                                    </Typography>
                                </Box>
                            </Box>
                            <Typography variant="h5" sx={{ mb: 2, fontWeight: 600 }}>
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
