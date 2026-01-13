import { Card, CardContent, CardMedia, Typography, Button, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import ImageIcon from '@mui/icons-material/Image';
import type { Raid } from '../../model/db/raidDbModel';
import { formatDate, getRaidStatus, getRegistrationStatus } from '../../utils/dateUtils';

interface RaidCardProps {
    raid: Raid
    onDetailsClick?: (raidId: number) => void;
}

function RaidCard({ raid, onDetailsClick }: RaidCardProps) {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`/raids/${raid.id}`);
        if (onDetailsClick) {
            onDetailsClick(raid.id);
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
            {raid.image ? (
                <CardMedia
                    component="img"
                    height="160"
                    image={raid.image}
                    alt={raid.name}
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
                    {raid.name}
                </Typography>

                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    Du {formatDate(raid.time_start)} au {formatDate(raid.time_end)}
                    <br />
                    Statut d'inscription: {getRegistrationStatus(raid.registration_start, raid.registration_end)}
                    <br />
                    Statut du raid: {getRaidStatus(raid.time_start, raid.time_end)}
                    <br />
                    Dates d'inscription: {formatDate(raid.registration_start)} - {formatDate(raid.registration_end)}
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

export default RaidCard;
