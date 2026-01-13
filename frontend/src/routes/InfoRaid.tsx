import { Container, Typography, Box, Button, Slider, ToggleButtonGroup, ToggleButton } from '@mui/material';
import { useParams, useNavigate } from 'react-router-dom';
import { getListOfRaids } from '../api/raids';
import { getListOfRacesByRaidId } from '../api/races';
import RaceCard from '../components/RaceCard';
import React from 'react';

export default function InfoRaid() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const raids = getListOfRaids();
    const raid = raids.find(r => r.id === parseInt(id || '', 10));
    const allRaces = getListOfRacesByRaidId(raid?.id || 0);

    const [difficulty, setDifficulty] = React.useState<number[]>([0, 100]);
    const [distance, setDistance] = React.useState<number[]>([0, 100]);
    const [raceType, setRaceType] = React.useState<string | null>(null);

    const filteredRaces = React.useMemo(() => {
        return allRaces.filter((race) => {
            const raceDistance = race.distance || 0;
            const matchesDistance = raceDistance >= distance[0] && raceDistance <= distance[1];

            const matchesType = !raceType || 
                (raceType === 'Compétitif' && race.type === 'compétition') ||
                (raceType === 'Randonnée' && race.type === 'rando/loisir') ||
                (raceType === 'Extrême' && race.type === 'extrême');

            return matchesDistance && matchesType;
        });
    }, [allRaces, distance, raceType]);
    

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
        <Container maxWidth="xl">
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

                        {/* Difficulté */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 600, mb: 2 }}>
                                Difficulté
                            </Typography>
                            <Box sx={{ px: 1 }}>
                                <Slider
                                    value={difficulty}
                                    onChange={(_, newValue) => setDifficulty(newValue as number[])}
                                    valueLabelDisplay="auto"
                                    min={0}
                                    max={100}
                                    sx={{
                                        color: '#9c27b0',
                                        '& .MuiSlider-thumb': {
                                            backgroundColor: '#fff',
                                            border: '2px solid #9c27b0',
                                        },
                                    }}
                                />
                                <Box sx={{ display: 'flex', justifyContent: 'space-between', mt: 1 }}>
                                    <Typography variant="caption" color="text.secondary">Facile</Typography>
                                    <Typography variant="caption" color="text.secondary">Expert</Typography>
                                </Box>
                            </Box>
                        </Box>

                        {/* Distance */}
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

                        {/* Type */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 600, mb: 2 }}>
                                Type
                            </Typography>
                            <ToggleButtonGroup
                                value={raceType}
                                exclusive
                                onChange={(_, newType) => newType && setRaceType(newType)}
                                orientation="vertical"
                                fullWidth
                                sx={{ gap: 1 }}
                            >
                                <ToggleButton 
                                    value="Compétitif" 
                                    sx={{ 
                                        textTransform: 'none',
                                        justifyContent: 'flex-start',
                                        '&.Mui-selected': {
                                            backgroundColor: '#f97316',
                                            color: 'white',
                                            '&:hover': {
                                                backgroundColor: '#ea580c',
                                            },
                                        },
                                    }}
                                >
                                    Compétitif
                                </ToggleButton>
                                <ToggleButton 
                                    value="Randonnée" 
                                    sx={{ 
                                        textTransform: 'none',
                                        justifyContent: 'flex-start',
                                        '&.Mui-selected': {
                                            backgroundColor: '#f97316',
                                            color: 'white',
                                            '&:hover': {
                                                backgroundColor: '#ea580c',
                                            },
                                        },
                                    }}
                                >
                                    Randonnée
                                </ToggleButton>
                                <ToggleButton 
                                    value="Extrême" 
                                    sx={{ 
                                        textTransform: 'none',
                                        justifyContent: 'flex-start',
                                        '&.Mui-selected': {
                                            backgroundColor: '#f97316',
                                            color: 'white',
                                            '&:hover': {
                                                backgroundColor: '#ea580c',
                                            },
                                        },
                                    }}
                                >
                                    Extrême
                                </ToggleButton>
                            </ToggleButtonGroup>
                        </Box>
                    </Box>

                    {/* Contenu principal */}
                    <Box sx={{ flex: 1 }}>
                        <Box sx={{ mb: 3 }}>
                            <Typography variant="h3" component="h1" gutterBottom sx={{ fontWeight: 'bold' }}>
                                {raid.name}
                            </Typography>
                            <Typography variant="body1" color="text.secondary" sx={{ mb: 2 }}>
                                Du {raid.start_date} au {raid.end_date}
                            </Typography>
                            <Typography variant="h6">
                                {filteredRaces.length} courses disponibles
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
                                <Box key={race.id}>
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
