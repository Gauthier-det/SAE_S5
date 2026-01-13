import { Card, CardContent, CardMedia, Typography, Button, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import ImageIcon from '@mui/icons-material/Image';
import type { Race } from '../model/db/raceDbModel';


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
            {race.image_url ? (
                <CardMedia
                    component="img"
                    height="160"
                    image={race.image_url}
                    alt={race.name}
                    sx={{ objectFit: 'cover' }}
                />
            ) : (
                <Box
                    sx={{
                        width: '100%',
                        height: 160,
                        backgroundColor: '#d1d5db',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                    }}
                >
                    <ImageIcon sx={{ fontSize: 64, color: '#6b7280' }} />
                </Box>
            )}
            
            <CardContent sx={{ p: 2 }}>
                <Typography variant="h6" component="h3" sx={{ fontWeight: 'bold', mb: 1 }}>
                    {race.name}
                </Typography>
                
                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    {race.date }
                    <br />
                    {race.type}
                    <br />
                    {race.age_range} 
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
