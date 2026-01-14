import { Card, CardContent, Typography, Button, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import type { Race } from '../../models/race.model';
import { formatDate } from '../../utils/dateUtils';


interface RaceCardProps {
    race: Race;
    onDetailsClick?: (raidId: number) => void;
}

function RaceCard({ race, onDetailsClick }: RaceCardProps) {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`/races/${race.RAC_ID}`);
        if (onDetailsClick) {
            onDetailsClick(race.RAC_ID);
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
                    backgroundColor: race.RAC_TYPE === 'Compétitif' ? '#ef4444' : '#22c55e', // Red for competitive, green for fun
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    color: 'white',
                    flexDirection: 'column'
                }}
            >
                <Typography variant="h5" sx={{ fontWeight: 'bold' }}>{race.RAC_DIFFICULTY}</Typography>
                <Typography variant="subtitle2">{race.RAC_TYPE === 'Compétitif' ? 'Compétitif' : 'Loisir'}</Typography>
            </Box>

            <CardContent sx={{ p: 2 }}>
                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    <strong>Début:</strong> {formatDate(race.RAC_TIME_START)}
                    <br />
                    <strong>Fin:</strong> {formatDate(race.RAC_TIME_END)}
                    <br />
                    <strong>Participants total:</strong> {race.RAC_MIN_PARTICIPANTS} - {race.RAC_MAX_PARTICIPANTS}
                    <br />
                    <strong>Équipes:</strong> {race.RAC_MIN_TEAMS} - {race.RAC_MAX_TEAMS} équipes
                    <br />
                    <strong>Participants max/équipe:</strong> {race.RAC_TEAM_MEMBERS}
                    <br />
                    <strong>Age:</strong> {race.RAC_AGE_MIN} - {race.RAC_AGE_MAX} ans
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
