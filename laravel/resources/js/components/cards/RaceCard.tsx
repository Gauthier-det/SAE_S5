import { useNavigate } from 'react-router-dom';
import type { Race } from '../../models/race.model';
import { formatDate } from '../../utils/dateUtils';
import { useUser } from '../../contexts/userContext';
import { Card, CardContent, Typography, Button, Box, Stack, Chip, Divider } from '@mui/material';
import EventIcon from '@mui/icons-material/Event';
import GroupsIcon from '@mui/icons-material/Groups';
import PersonIcon from '@mui/icons-material/Person';
import WcIcon from '@mui/icons-material/Wc'; // Gender
import CakeIcon from '@mui/icons-material/Cake'; // Age (or access time for duration, but user asked for age)
import FlagIcon from '@mui/icons-material/Flag';
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';

interface RaceCardProps {
    race: Race;
    onDetailsClick?: (raidId: number) => void;
}

function RaceCard({ race, onDetailsClick }: RaceCardProps) {
    const navigate = useNavigate();
    const { user } = useUser();

    const handleClick = () => {
        navigate(`/races/${race.RAC_ID}`);
        if (onDetailsClick) {
            onDetailsClick(race.RAC_ID);
        }
    };


    return (
        <Card
            sx={{
                borderRadius: 4,
                boxShadow: '0 4px 20px rgba(0,0,0,0.08)',
                overflow: 'hidden',
                transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
                height: '100%',
                display: 'flex',
                flexDirection: 'column',
                '&:hover': {
                    transform: 'translateY(-4px)',
                    boxShadow: '0 12px 28px rgba(0,0,0,0.12)',
                }
            }}
        >
            {/* Header / Banner */}
            <Box
                sx={{
                    width: '100%',
                    height: 120,
                    background: race.RAC_TYPE === 'Compétitif'
                        ? 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'
                        : 'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center',
                    color: 'white',
                    position: 'relative',
                    px: 2,
                    textAlign: 'center'
                }}
            >
                <Typography variant="h5" sx={{ fontWeight: 800, textTransform: 'uppercase', letterSpacing: 1 }}>
                    {race.RAC_NAME}
                </Typography>
            </Box>

            <CardContent sx={{ p: 2.5, flexGrow: 1, display: 'flex', flexDirection: 'column', gap: 2 }}>
                <Box sx={{ display: 'flex', gap: 1, mb: 2, flexWrap: 'wrap' }}>
                    {race.user.USE_ID === user?.USE_ID && <Chip
                        label="Vous êtes manager de cette course"
                        size="small"
                        color="info"
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />}
                    <Chip
                        label={race.RAC_DIFFICULTY}
                        color="warning"
                        size="small"
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                    <Chip
                        label={race.RAC_TYPE}
                        color={race.RAC_TYPE === 'Compétitif' ? 'error' : 'success'}
                        size="small"
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                </Box>
                <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
                    <strong>Début:</strong> {formatDate(race.RAC_TIME_START)}
                    <br />
                    <strong>Fin:</strong> {formatDate(race.RAC_TIME_END)}
                    <br />
                    <strong>Participants total:</strong> {race.RAC_MIN_PARTICIPANTS} - {race.RAC_MAX_PARTICIPANTS}
                    <br />
                    <strong>Équipes:</strong> {race.RAC_MIN_TEAMS} - {race.RAC_MAX_TEAMS} équipes
                    <br />
                    <strong>Participants max/équipe:</strong> {race.RAC_MAX_TEAM_MEMBERS}
                    <br />
                    <strong>Age:</strong> {race.RAC_AGE_MIN} - {race.RAC_AGE_MAX} ans
                </Typography>

                {/* Dates */}
                <Box sx={{ display: 'flex', gap: 1.5, alignItems: 'center' }}>
                    <EventIcon color="action" fontSize="small" />
                    <Box>
                        <Typography variant="body2" sx={{ fontWeight: 600 }}>
                            {new Date(race.RAC_TIME_START).toLocaleString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                        </Typography>
                        <Typography variant="caption" color="text.secondary" display="block">
                            au {new Date(race.RAC_TIME_END).toLocaleString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                        </Typography>
                    </Box>
                </Box>

                <Divider sx={{ borderStyle: 'dashed' }} />

                {/* Info */}
                <Box sx={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 2 }}>
                    {/* Participants */}
                    <Stack spacing={0.5}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                            <PersonIcon fontSize="small" />
                            <Typography variant="caption" fontWeight="bold">PARTICIPANTS</Typography>
                        </Box>
                        <Typography variant="body2" fontWeight={500}>
                            {race.RAC_MIN_PARTICIPANTS} - {race.RAC_MAX_PARTICIPANTS}
                        </Typography>
                    </Stack>

                    {/* Équipes */}
                    <Stack spacing={0.5}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                            <FlagIcon fontSize="small" />
                            <Typography variant="caption" fontWeight="bold">ÉQUIPES</Typography>
                        </Box>
                        <Typography variant="body2" fontWeight={500}>
                            {race.RAC_MIN_TEAMS} - {race.RAC_MAX_TEAMS}
                        </Typography>
                    </Stack>

                    {/* Team Size */}
                    <Stack spacing={0.5}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                            <GroupsIcon fontSize="small" />
                            <Typography variant="caption" fontWeight="bold">PAR ÉQUIPE</Typography>
                        </Box>
                        <Typography variant="body2" fontWeight={500}>
                            Max {race.RAC_MAX_TEAM_MEMBERS} pers.
                        </Typography>
                    </Stack>

                    {/* Gender */}
                    <Stack spacing={0.5}>
                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                            <WcIcon fontSize="small" />
                            <Typography variant="caption" fontWeight="bold">GENRE</Typography>
                        </Box>
                        <Typography variant="body2" fontWeight={500}>
                            {race.RAC_GENDER}
                        </Typography>
                    </Stack>

                    {/* Age */}
                    <Box sx={{
                        gridColumn: '1 / -1',
                        display: 'flex',
                        alignItems: 'center',
                        gap: 1.5,
                        bgcolor: '#f8f9fa',
                        p: 1.5,
                        borderRadius: 2
                    }}>
                        <CakeIcon fontSize="small" color="primary" />
                        <Typography variant="body2" fontWeight={600} color="text.primary">
                            {race.RAC_AGE_MIN} - {race.RAC_AGE_MAX} ans
                        </Typography>
                    </Box>
                </Box>

                <Box sx={{ mt: 'auto', pt: 2 }}>
                    <Button
                        variant="contained"
                        fullWidth
                        onClick={handleClick}
                        endIcon={<ArrowForwardIcon />}
                        sx={{
                            backgroundColor: '#1a1a1a',
                            color: 'white',
                            fontWeight: 700,
                            borderRadius: 2,
                            textTransform: 'none',
                            py: 1.2,
                            boxShadow: 'none',
                            '&:hover': {
                                backgroundColor: '#000000',
                                boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
                            }
                        }}
                    >
                        Voir les détails
                    </Button>
                </Box>
            </CardContent>
        </Card>
    );
}

export default RaceCard;
