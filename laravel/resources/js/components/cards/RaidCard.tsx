import { Card, CardContent, CardMedia, Typography, Button, Box } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import ImageIcon from '@mui/icons-material/Image';
import type { Raid } from '../../models/raid.model';
import { formatDate, getRaidStatus, getRegistrationStatus } from '../../utils/dateUtils';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import GroupIcon from '@mui/icons-material/Group';

interface RaidCardProps {
    raid: Raid
    onDetailsClick?: (raidId: number) => void;
}

function RaidCard({ raid, onDetailsClick }: RaidCardProps) {
    const navigate = useNavigate();

    const handleClick = () => {
        navigate(`/raids/${raid.RAI_ID}`);
        if (onDetailsClick) {
            onDetailsClick(raid.RAI_ID);
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
            {raid.RAI_IMAGE ? (
                <CardMedia
                    component="img"
                    height="160"
                    image={raid.RAI_IMAGE}
                    alt={raid.RAI_NAME}
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
                    {raid.RAI_NAME}
                </Typography>

                {raid.club && (
                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 0.5, mb: 0.5 }}>
                        <GroupIcon fontSize="small" color="action" />
                        <Typography variant="body2" color="text.secondary">
                            {raid.club.CLU_NAME}
                        </Typography>
                    </Box>
                )}

                {raid.address && (
                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 0.5, mb: 1 }}>
                        <LocationOnIcon fontSize="small" color="action" />
                        <Typography variant="body2" color="text.secondary">
                            {raid.address.ADD_CITY} ({raid.address.ADD_POSTAL_CODE})
                        </Typography>
                    </Box>
                )}

                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    Du {formatDate(raid.RAI_TIME_START)} au {formatDate(raid.RAI_TIME_END)}
                    <br />
                    Statut d'inscription: {getRegistrationStatus(raid.RAI_REGISTRATION_START, raid.RAI_REGISTRATION_END)}
                    <br />
                    Statut du raid: {getRaidStatus(raid.RAI_TIME_START, raid.RAI_TIME_END)}
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
