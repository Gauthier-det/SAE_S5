import { useState } from 'react';
import { Card, CardContent, CardMedia, Typography, Button, Box, Chip } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import type { Raid } from '../../models/raid.model';
import { formatDate, getRaidStatus, getRegistrationStatus } from '../../utils/dateUtils';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import CalendarTodayIcon from '@mui/icons-material/CalendarToday';
import ImageIcon from '@mui/icons-material/Image';
import DirectionsRunIcon from '@mui/icons-material/DirectionsRun';
import { useUser } from '../../contexts/userContext';

interface RaidCardProps {
    raid: Raid
    onDetailsClick?: (raidId: number) => void;
}

function RaidCard({ raid, onDetailsClick }: RaidCardProps) {
    const navigate = useNavigate();
    const [imageError, setImageError] = useState(false);
    const { user, isRaidManager } = useUser();
    const handleClick = () => {
        navigate(`/raids/${raid.RAI_ID}`);
        if (onDetailsClick) {
            onDetailsClick(raid.RAI_ID);
        }
    };

    const registrationStatus = getRegistrationStatus(raid.RAI_REGISTRATION_START, raid.RAI_REGISTRATION_END);
    const raidStatus = getRaidStatus(raid.RAI_TIME_START, raid.RAI_TIME_END);

    const getStatusColor = (date: string) => {
        if (date.includes('Ouvert') || date.includes('En cours')) return 'success';
        if (date.includes('Fermé') || date.includes('Terminé')) return 'error';
        return 'warning';
    };

    console.log("isRaidManager : "+isRaidManager);
    console.log("user : "+user?.USE_ID);
    console.log("raid.user : "+raid.user?.USE_ID);
    return (
        <Card
            sx={{
                width: '100%',
                height: '100%',
                display: 'flex',
                flexDirection: 'column',
                borderRadius: 3,
                overflow: 'hidden',
                transition: 'all 0.3s ease',
                cursor: 'pointer',
                background: 'linear-gradient(145deg, #ffffff 0%, #f8fafc 100%)',
                border: '1px solid #e2e8f0',
                '&:hover': {
                    transform: 'translateY(-4px)',
                    boxShadow: '0 20px 40px rgba(0,0,0,0.12)',
                    borderColor: '#f97316',
                },
            }}
            onClick={handleClick}
        >
            {raid.RAI_IMAGE && !imageError ? (
                <CardMedia
                    component="img"
                    height="180"
                    image={raid.RAI_IMAGE}
                    alt={raid.RAI_NAME}
                    sx={{ objectFit: 'cover', height: 180, width: '100%' }}
                    onError={() => setImageError(true)}
                />
            ) : (
                <Box
                    sx={{
                        width: '100%',
                        height: 180,
                        backgroundColor: '#f1f5f9',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                    }}
                >
                    <ImageIcon sx={{ fontSize: 48, color: '#94a3b8' }} />
                </Box>
            )}

            <CardContent sx={{ p: 3, flex: 1, display: 'flex', flexDirection: 'column' }}>
                {raid.user?.USE_ID === user?.USE_ID && <Box sx={{ display: 'flex', gap: 1, mb: 2, flexWrap: 'wrap' }}>
                    <Chip
                        label="Vous êtes manager de ce raid"
                        size="small"
                        color="info"
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                </Box>}
                {/* Status Chips */}
                <Box sx={{ display: 'flex', gap: 1, mb: 2, flexWrap: 'wrap' }}>
                    <Chip
                        label={registrationStatus}
                        size="small"
                        color={getStatusColor(registrationStatus)}
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                    <Chip
                        label={raidStatus}
                        size="small"
                        variant="outlined"
                        color={getStatusColor(raidStatus)}
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                </Box>

                {/* Title */}
                <Typography
                    variant="h6"
                    component="h3"
                    sx={{
                        fontWeight: 700,
                        mb: 1.5,
                        fontSize: '1.1rem',
                        color: '#1e293b',
                        lineHeight: 1.3
                    }}
                >
                    {raid.RAI_NAME}
                </Typography>

                {/* Club */}
                {raid.club && (
                    <Typography
                        variant="body2"
                        sx={{
                            color: '#64748b',
                            mb: 1,
                            fontWeight: 500
                        }}
                    >
                        {raid.club.CLU_NAME}
                    </Typography>
                )}

                {/* Location */}
                {raid.address && (
                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 0.5, mb: 1.5 }}>
                        <LocationOnIcon sx={{ fontSize: 16, color: '#ef4444' }} />
                        <Typography variant="body2" sx={{ color: '#64748b' }}>
                            {raid.address.ADD_CITY}
                        </Typography>
                    </Box>
                )}
                {/* Registration */}
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 0.5, mb: 2 }}>
                    <CalendarTodayIcon sx={{ fontSize: 16, color: '#3b82f6' }} />
                    <Typography variant="body2" sx={{ color: '#64748b' }}>
                        {formatDate(raid.RAI_REGISTRATION_START)} - {formatDate(raid.RAI_REGISTRATION_END)}
                    </Typography>
                </Box>
                {/* Dates */}
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 0.5, mb: 2 }}>
                    <DirectionsRunIcon sx={{ fontSize: 16, color: '#3b82f6' }} />
                    <Typography variant="body2" sx={{ color: '#64748b' }}>
                        {formatDate(raid.RAI_TIME_START)} - {formatDate(raid.RAI_TIME_END)}
                    </Typography>
                </Box>

                {/* Button */}
                <Button
                    variant="contained"
                    fullWidth
                    sx={{
                        mt: 'auto',
                        background: 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)',
                        fontWeight: 700,
                        fontSize: '0.8rem',
                        py: 1.2,
                        borderRadius: 2,
                        textTransform: 'none',
                        boxShadow: '0 4px 14px rgba(249, 115, 22, 0.4)',
                        '&:hover': {
                            background: 'linear-gradient(135deg, #ea580c 0%, #dc2626 100%)',
                            boxShadow: '0 6px 20px rgba(249, 115, 22, 0.5)',
                        }
                    }}
                >
                    Voir les détails
                </Button>
            </CardContent>
        </Card>
    );
}

export default RaidCard;
