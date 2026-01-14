import { useMemo } from 'react';
import {
    Box,
    Container,
    Paper,
    Typography,
    Button,
    Chip,
    Stack,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    TextField
} from '@mui/material';

import DeleteIcon from '@mui/icons-material/Delete';
import { useUser } from '../../contexts/userContext';
import { createAvatar } from '@dicebear/core';
import { thumbs } from '@dicebear/collection';
import { formatDate } from '../../utils/dateUtils';

// Mock data for UI demonstration
const mockStats = {
    racesRun: 12,
    podiums: 3,
    totalPoints: 1450
};

const mockHistory = [
    { date: '12/09/2025', raid: 'Raid Viking', race: 'Les sangliers Rapides', rank: '5ème' },
    { date: '20/08/2025', raid: 'Noctune foret', race: 'Solo', rank: '12ème' },
    { date: '05/07/2025', raid: 'Orien\'t Express', race: 'Équipe A', rank: '3ème' },
];

const Profile = () => {
    const { user, isClubManager, isRaidManager } = useUser();

    // Generate Avatar
    const avatarSvg = useMemo(() => {
        if (!user) return '';
        const avatar = createAvatar(thumbs, {
            seed: `${user.USE_NAME}${user.USE_LAST_NAME}`,
            backgroundColor: ['1a2e22', '1b5e20', 'f97316'],
        });
        return avatar.toDataUri();
    }, [user]);

    if (!user) return null;

    return (
        <Box sx={{ flexGrow: 1, minHeight: 'calc(100vh - 64px)', bgcolor: '#f5f5f5', py: 4 }}>
            <Container maxWidth="lg">
                {/* Main Layout using Stack */}
                <Stack direction={{ xs: 'column', md: 'row' }} spacing={4}>
                    {/* Left Column: Profile Card */}
                    <Box sx={{ width: { xs: '100%', md: '350px' }, flexShrink: 0 }}>
                        <Paper
                            elevation={0}
                            sx={{
                                p: 4,
                                display: 'flex',
                                flexDirection: 'column',
                                alignItems: 'center',
                                borderRadius: '24px',
                                bgcolor: 'white'
                            }}
                        >
                            <Box
                                sx={{
                                    width: 150,
                                    height: 150,
                                    mb: 2,
                                    borderRadius: '50%',
                                    overflow: 'hidden',
                                    border: '4px solid #2D5A27',
                                    boxShadow: '0 4px 14px 0 rgba(0,0,0,0.1)'
                                }}
                            >
                                <img src={avatarSvg} alt="Avatar" style={{ width: '100%', height: '100%' }} />
                            </Box>

                            <Typography variant="h5" sx={{ fontWeight: 'bold', mb: 1, textAlign: 'center' }}>
                                {user.USE_NAME} {user.USE_LAST_NAME}
                            </Typography>

                            <Stack direction="row" spacing={1} sx={{ mb: 4 }}>
                                <Chip label="Coureur" sx={{ bgcolor: '#2e7d32', color: 'white', fontWeight: 'bold' }} size="small" />
                                {isRaidManager && <Chip label="Responsable de RAID" color="primary" size="small" />}
                                {isClubManager && <Chip label="Responsable de CLUB" color="secondary" size="small" />}
                                { }
                            </Stack>

                            <Button
                                variant="contained"
                                fullWidth
                                sx={{
                                    mb: 2,
                                    bgcolor: '#ff6d00',
                                    color: 'white',
                                    fontWeight: 'bold',
                                    borderRadius: '12px',
                                    py: 1.5,
                                    '&:hover': { bgcolor: '#e65100' }
                                }}
                            >
                                MODIFIER MON PROFIL
                            </Button>

                            <Button
                                variant="text"
                                color="error"
                                startIcon={<DeleteIcon />}
                                sx={{ textTransform: 'none', color: '#d32f2f' }}
                            >
                                Archiver mon compte
                            </Button>
                        </Paper>
                    </Box>

                    {/* Right Column: Details & Stats */}
                    <Stack spacing={4} sx={{ flexGrow: 1 }}>
                        <Stack spacing={4}>
                            {/* Personal Info */}
                            <Paper elevation={0} sx={{ p: 4, borderRadius: '24px', bgcolor: 'white' }}>
                                <Typography variant="h5" sx={{ fontWeight: 'bold', mb: 3 }}>
                                    Mes coordonnées et documents
                                </Typography>

                                <Stack spacing={3}>
                                    <Stack direction={{ xs: 'column', sm: 'row' }} spacing={3}>
                                        <TextField
                                            label="Date de naissance :"
                                            defaultValue={formatDate(user.USE_BIRTHDATE!) || " "}
                                            variant="filled"
                                            fullWidth
                                            disabled
                                            InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                            sx={{
                                                '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                                '& .MuiInputLabel-root': { color: '#666' }
                                            }}
                                        />
                                        <TextField
                                            label="Téléphone : "
                                            defaultValue={user.USE_PHONE_NUMBER}
                                            variant="filled"
                                            fullWidth
                                            disabled
                                            InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                            sx={{
                                                '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                                '& .MuiInputLabel-root': { color: '#666' }
                                            }}
                                        />
                                    </Stack>

                                    <TextField
                                        label="Email :"
                                        defaultValue={user.USE_MAIL}
                                        variant="filled"
                                        fullWidth
                                        disabled
                                        InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                        sx={{
                                            '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                            '& .MuiInputLabel-root': { color: '#666' }
                                        }}
                                    />
                                </Stack>

                                <Typography variant="h5" sx={{ fontWeight: 'bold', mt: 4, mb: 3 }}>
                                    Adresse
                                </Typography>

                                <Stack spacing={3}>
                                    <Stack direction={{ xs: 'column', sm: 'row' }} spacing={3}>
                                        <TextField
                                            label="Ville / Code postal"
                                            defaultValue={`${user.address?.ADD_CITY || ''} ${user.address?.ADD_POSTAL_CODE || ''}`}
                                            variant="filled"
                                            fullWidth
                                            disabled
                                            InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                            sx={{
                                                '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                                '& .MuiInputLabel-root': { color: '#666' }
                                            }}
                                        />
                                        <TextField
                                            label="Adresse"
                                            defaultValue={`${user.address?.ADD_STREET_NUMBER || ''} ${user.address?.ADD_STREET_NAME || ''}`}
                                            variant="filled"
                                            fullWidth
                                            disabled
                                            InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                            sx={{
                                                '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                                '& .MuiInputLabel-root': { color: '#666' }
                                            }}
                                        />
                                    </Stack>
                                </Stack>

                                <Typography variant="h5" sx={{ fontWeight: 'bold', mt: 4, mb: 3 }}>
                                    Données de courses
                                </Typography>

                                <Stack direction={{ xs: 'column', sm: 'row' }} spacing={3}>
                                    <TextField
                                        label="Numéro de licence"
                                        defaultValue={user.USE_LICENCE_NUMBER || " "}
                                        variant="filled"
                                        fullWidth
                                        disabled
                                        InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                        sx={{
                                            '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                            '& .MuiInputLabel-root': { color: '#666' }
                                        }}
                                    />
                                    <TextField
                                        label="Certificat médical"
                                        defaultValue={user.USE_PPS_FORM || " "}
                                        variant="filled"
                                        fullWidth
                                        disabled
                                        InputProps={{ disableUnderline: true, style: { fontWeight: 'bold', color: 'black' } }}
                                        sx={{
                                            '& .MuiFilledInput-root': { borderRadius: '12px', bgcolor: '#f0f0f0' },
                                            '& .MuiInputLabel-root': { color: '#666' }
                                        }}
                                    />
                                </Stack>
                            </Paper>

                            {/* Stats */}
                            <Paper elevation={0} sx={{ p: 4, borderRadius: '24px', bgcolor: 'white' }}>
                                <Typography variant="h5" sx={{ fontWeight: 'bold', mb: 3 }}>
                                    Statistiques et Historique
                                </Typography>

                                <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2} sx={{ mb: 6 }}>
                                    <Box sx={{ bgcolor: '#f0f0f0', p: 3, borderRadius: '16px', flex: 1, textAlign: 'center' }}>
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Course courues : {mockStats.racesRun}</Typography>
                                    </Box>
                                    <Box sx={{ bgcolor: '#f0f0f0', p: 3, borderRadius: '16px', flex: 1, textAlign: 'center' }}>
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Podiums : {mockStats.podiums}</Typography>
                                    </Box>
                                    <Box sx={{ bgcolor: '#f0f0f0', p: 3, borderRadius: '16px', flex: 1, textAlign: 'center' }}>
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Points total : {mockStats.totalPoints} points</Typography>
                                    </Box>
                                </Stack>

                                <Typography variant="h6" sx={{ fontWeight: 'bold', mb: 2 }}>
                                    Dernières courses
                                </Typography>

                                <TableContainer>
                                    <Table size="small">
                                        <TableHead>
                                            <TableRow>
                                                <TableCell sx={{ color: 'text.secondary', borderBottom: '1px solid #f0f0f0' }}>Date</TableCell>
                                                <TableCell sx={{ color: 'text.secondary', borderBottom: '1px solid #f0f0f0' }}>Raid</TableCell>
                                                <TableCell sx={{ color: 'text.secondary', borderBottom: '1px solid #f0f0f0' }}>Course</TableCell>
                                                <TableCell align="right" sx={{ color: 'text.secondary', borderBottom: '1px solid #f0f0f0' }}>Classement</TableCell>
                                            </TableRow>
                                        </TableHead>
                                        <TableBody>
                                            {mockHistory.map((row, index) => (
                                                <TableRow key={index} sx={{ '&:last-child td, &:last-child th': { border: 0 } }}>
                                                    <TableCell component="th" scope="row" sx={{ borderBottom: '1px solid #f0f0f0' }}>
                                                        {row.date}
                                                    </TableCell>
                                                    <TableCell sx={{ borderBottom: '1px solid #f0f0f0' }}>{row.raid}</TableCell>
                                                    <TableCell sx={{ borderBottom: '1px solid #f0f0f0' }}>{row.race}</TableCell>
                                                    <TableCell align="right" sx={{ borderBottom: '1px solid #f0f0f0' }}>{row.rank}</TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </TableContainer>

                                <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 4 }}>
                                    <Button
                                        variant="contained"
                                        endIcon={<Typography component="span" sx={{ ml: 1 }}>→</Typography>}
                                        sx={{
                                            bgcolor: '#e0e0e0',
                                            color: '#333',
                                            borderRadius: '20px',
                                            textTransform: 'none',
                                            fontWeight: 'bold',
                                            boxShadow: 'none',
                                            px: 3,
                                            '&:hover': { bgcolor: '#d5d5d5', boxShadow: 'none' }
                                        }}
                                    >
                                        VOIR L'HISTORIQUE DES COURSES
                                    </Button>
                                </Box>
                            </Paper>
                        </Stack>
                    </Stack>
                </Stack>
            </Container>
        </Box >
    );
};

export default Profile;
