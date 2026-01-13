import { Card, CardContent, Typography, Button, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import type { Race } from '../../model/db/raceDbModel';
import { formatDate } from '../../utils/dateUtils';


interface RaceCardProps {
    race: Race;
    onDetailsClick?: (raidId: number) => void;
}

function RaceCard({ race, onDetailsClick }: RaceCardProps) {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`/races/${race.id}`);
        if (onDetailsClick) {
            onDetailsClick(race.id);
        }
    };

    return (
        <Card
            sx={{
                borderRadius: 2,
                boxShadow: 2,
                overflow: 'hidden',
                transition: 'all 0.3s',
                '&:hover': {
                    boxShadow: 6,
                }
            }}
        >
            {/* Image not actually in Race model as per previous mapping, check if it exists or use placeholder */}
            <Box
                sx={{
                    width: '100%',
                    height: 160,
                    backgroundColor: race.competitive ? '#ef4444' : '#22c55e', // Red for competitive, green for fun
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    color: 'white',
                    flexDirection: 'column'
                }}
            >
                <Typography variant="h5" sx={{ fontWeight: 'bold' }}>{race.difficulty}</Typography>
                <Typography variant="subtitle2">{race.competitive ? 'Compétitif' : 'Loisir'}</Typography>
            </Box>

            <CardContent sx={{ p: 2 }}>
                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    <strong>Début:</strong> {formatDate(race.time_start)}
                    <br />
                    <strong>Fin:</strong> {formatDate(race.time_end)}
                    <br />
                    <strong>Équipes:</strong> {race.min_team} - {race.max_team} équipes
                    <br />
                    <strong>Participants/équipe:</strong> {race.min_participants} - {race.max_participants}
                    <br />
                    <strong>Age:</strong> {race.age_min} - {race.age_max} ans
                </Typography>

                <Button
                    variant="contained"
                    fullWidth
                    onClick={handleClick}
                    sx={{
                        backgroundColor: '#f97316',
                        fontWeight: 600,
                        fontSize: '0.875rem',
                        py: 1,
                        '&:hover': {
                            backgroundColor: '#ea580c',
                        }
                    }}
                >
                    VOIR LES DÉTAILS
                </Button>
            </CardContent>
        </Card>
    );
}

export default RaceCard;
