import { useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
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
    TextField,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions
} from '@mui/material';

import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import { createAvatar } from '@dicebear/core';
import { thumbs } from '@dicebear/collection';
import { formatDate } from '../../utils/dateUtils';
import { updateUser, deleteUser } from '../../api/user';
import { updateAddress } from '../../api/address';
import type { UserUpdate } from '../../models/user.model';

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
    const navigate = useNavigate();
    const { user, isClubManager, isRaidManager, isRaceManager, isAdmin, refreshUser, logout } = useUser();
    const { showAlert } = useAlert();
    const [isEditMode, setIsEditMode] = useState(false);
    const [isDeleteConfirmOpen, setIsDeleteConfirmOpen] = useState(false);
    const [isUpdateConfirmOpen, setIsUpdateConfirmOpen] = useState(false);
    const [formData, setFormData] = useState({
        firstName: user?.USE_NAME || '',
        lastName: user?.USE_LAST_NAME || '',
        email: user?.USE_MAIL || '',
        phone: user?.USE_PHONE_NUMBER || '',
        birthDate: user?.USE_BIRTHDATE || '',
        city: user?.address?.ADD_CITY || '',
        postalCode: user?.address?.ADD_POSTAL_CODE || '',
        street: user?.address?.ADD_STREET_NAME || '',
        streetNumber: user?.address?.ADD_STREET_NUMBER || '',
    });
    const [errors, setErrors] = useState<{ [key: string]: string }>({});

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

    const handleEditOpen = () => {
        setFormData({
            firstName: user.USE_NAME || '',
            lastName: user.USE_LAST_NAME || '',
            email: user.USE_MAIL || '',
            phone: user.USE_PHONE_NUMBER || '',
            birthDate: user.USE_BIRTHDATE || '',
            city: user.address?.ADD_CITY || '',
            postalCode: user.address?.ADD_POSTAL_CODE || '',
            street: user.address?.ADD_STREET_NAME || '',
            streetNumber: user.address?.ADD_STREET_NUMBER || '',
        });
        setIsEditMode(true);
    };

    const handleEditClose = () => {
        setIsEditMode(false);
        setErrors({});
    };

    const handleFormChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));

        // Validation du code postal
        if (name === 'postalCode') {
            const postalCode = parseInt(value);
            if (isNaN(postalCode)) {
                setErrors(prev => ({
                    ...prev,
                    postalCode: 'Le code postal doit être un nombre'
                }));
            } else if (postalCode > 99999) {
                setErrors(prev => ({
                    ...prev,
                    postalCode: 'Le code postal ne doit pas dépasser 99999'
                }));
            } else {
                setErrors(prev => {
                    const newErrors = { ...prev };
                    delete newErrors.postalCode;
                    return newErrors;
                });
            }
        }
    };

    const handleSave = () => {
        // Afficher la dialog de confirmation
        setIsUpdateConfirmOpen(true);
    };

    const handleUpdateConfirm = async () => {
        if (!user) return;
        try {
            // Mise à jour de l'utilisateur
            const updateData: UserUpdate = {
                USE_NAME: formData.firstName,
                USE_LAST_NAME: formData.lastName,
                USE_PHONE_NUMBER: formData.phone as number,
                USE_BIRTHDATE: formData.birthDate,
            };
            
            await updateUser(user.USE_ID, updateData);

            // Mise à jour de l'adresse si elle existe
            if (user.address?.ADD_ID) {
                const postalCode = parseInt(formData.postalCode);
                if (isNaN(postalCode) || postalCode > 99999) {
                    console.error('Code postal invalide:', formData.postalCode);
                    return;
                }
                
                const addressData = {
                    ADD_CITY: formData.city,
                    ADD_POSTAL_CODE: formData.postalCode,
                    ADD_STREET_NAME: formData.street || undefined,
                    ADD_STREET_NUMBER: formData.streetNumber || undefined,
                };
                console.log('Données adresse à envoyer:', addressData);
                await updateAddress(user.address.ADD_ID, addressData);
            }

            setIsUpdateConfirmOpen(false);
            setIsEditMode(false);
            // Recharger les données utilisateur depuis l'API
            await refreshUser();
            // Afficher le message de succès
            showAlert('Profil mis à jour avec succès', 'success');
            navigate('/profile');
        } catch (error: any) {
            console.error('Erreur lors de la mise à jour:', error);
            setIsUpdateConfirmOpen(false);
            showAlert('Erreur lors de la mise à jour du profil', 'error');
            // Affiche les détails de l'erreur si disponibles
            if (error.response?.data?.errors) {
                console.error('Erreurs de validation:', error.response.data.errors);
            }
        }
    };

    const handleDeleteConfirm = async () => {
        if (!user) return;
        try {
            await deleteUser(user.USE_ID);
            setIsDeleteConfirmOpen(false);
            // Afficher le message de succès
            showAlert('Votre compte a été supprimé avec succès', 'success');
            // Redirection après 2 secondes
            setTimeout(() => {
                logout();
                navigate('/');
            }, 2000);
        } catch (error) {
            console.error('Erreur lors de la suppression:', error);
            setIsDeleteConfirmOpen(false);
            showAlert('Erreur lors de la suppression du compte', 'error');
        }
    };
    return (
        <Box sx={{ flexGrow: 1, minHeight: 'calc(100vh - 64px)', py: 4 }}>
            <Container maxWidth="lg">
                <Stack direction={{ xs: 'column', md: 'row' }} spacing={4}>
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

                            <Stack direction="row" spacing={1} useFlexGap sx={{ mb: 4, flexWrap: 'wrap' }}>
                                <Chip label="Coureur" sx={{ bgcolor: '#2e7d32', color: 'white', fontWeight: 'bold' }} size="small" />
                                {isAdmin && <Chip label="ADMIN" sx={{ bgcolor: '#d32f2f', color: 'white', fontWeight: 'bold' }} size="small" />}
                                {isRaidManager && <Chip label="Responsable de RAID" color="primary" size="small" />}
                                {isClubManager && <Chip label="Responsable de CLUB" color="secondary" size="small" />}
                                {isRaceManager && <Chip label="Responsable de COURSE" color="success" size="small" />}
                            </Stack>

                            <Button
                                variant="contained"
                                fullWidth
                                startIcon={<EditIcon />}
                                onClick={handleEditOpen}
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
                                onClick={() => setIsDeleteConfirmOpen(true)}
                                sx={{ textTransform: 'none', color: '#d32f2f' }}
                            >
                                Supprimer mon compte
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
                                            value={formatDate(user.USE_BIRTHDATE!) || " "}
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
                                            value={user.USE_PHONE_NUMBER}
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
                                        value={user.USE_MAIL}
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
                                            value={`${user.address?.ADD_CITY || ''} ${user.address?.ADD_POSTAL_CODE || ''}`}
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
                                            value={`${user.address?.ADD_STREET_NUMBER || ''} ${user.address?.ADD_STREET_NAME || ''}`}
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
                                        value={user.USE_LICENCE_NUMBER || " "}
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

            {/* Dialog de modification */}
            <Dialog open={isEditMode} onClose={handleEditClose} maxWidth="sm" fullWidth>
                <DialogTitle sx={{ fontWeight: 'bold', fontSize: '1.25rem' }}>
                    Modifier mon profil
                </DialogTitle>
                <DialogContent sx={{ pt: 3 }}>
                    <Stack spacing={3}>
                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                            <TextField
                                fullWidth
                                label="Prénom"
                                name="firstName"
                                value={formData.firstName}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                            <TextField
                                fullWidth
                                label="Nom"
                                name="lastName"
                                value={formData.lastName}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                        </Stack>

                        <TextField
                            fullWidth
                            label="Email"
                            name="email"
                            type="email"
                            value={formData.email}
                            onChange={handleFormChange}
                            variant="outlined"
                            disabled
                        />

                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                            <TextField
                                fullWidth
                                label="Téléphone"
                                name="phone"
                                value={formData.phone}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                            <TextField
                                fullWidth
                                label="Date de naissance"
                                name="birthDate"
                                type="date"
                                value={formData.birthDate}
                                onChange={handleFormChange}
                                variant="outlined"
                                InputLabelProps={{ shrink: true }}
                            />
                        </Stack>

                        <Typography variant="subtitle2" sx={{ fontWeight: 'bold', mt: 2 }}>
                            Adresse
                        </Typography>

                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                            <TextField
                                fullWidth
                                label="Numéro"
                                name="streetNumber"
                                value={formData.streetNumber}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                            <TextField
                                fullWidth
                                label="Rue"
                                name="street"
                                value={formData.street}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                        </Stack>

                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                            <TextField
                                fullWidth
                                label="Ville"
                                name="city"
                                value={formData.city}
                                onChange={handleFormChange}
                                variant="outlined"
                            />
                            <TextField
                                fullWidth
                                label="Code postal"
                                name="postalCode"
                                value={formData.postalCode}
                                onChange={handleFormChange}
                                variant="outlined"
                                error={!!errors.postalCode}
                                helperText={errors.postalCode}
                                sx={{
                                    '& .MuiOutlinedInput-root': {
                                        '&.Mui-error': {
                                            color: '#d32f2f'
                                        }
                                    }
                                }}
                            />
                        </Stack>
                    </Stack>
                </DialogContent>
                <DialogActions sx={{ p: 2 }}>
                    <Button onClick={handleEditClose} sx={{ color: '#666' }}>
                        Annuler
                    </Button>
                    <Button
                        onClick={handleSave}
                        variant="contained"
                        sx={{
                            bgcolor: '#ff6d00',
                            color: 'white',
                            fontWeight: 'bold',
                            '&:hover': { bgcolor: '#e65100' }
                        }}
                    >
                        Enregistrer
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Dialog de confirmation de mise à jour */}
            <Dialog open={isUpdateConfirmOpen} onClose={() => setIsUpdateConfirmOpen(false)}>
                <DialogTitle sx={{ fontWeight: 'bold', fontSize: '1.25rem' }}>
                    Confirmer les modifications
                </DialogTitle>
                <DialogContent sx={{ pt: 3 }}>
                    <Typography variant="body1">
                        Êtes-vous sûr de vouloir mettre à jour votre profil ?
                    </Typography>
                </DialogContent>
                <DialogActions sx={{ p: 2 }}>
                    <Button onClick={() => setIsUpdateConfirmOpen(false)} sx={{ color: '#666' }}>
                        Annuler
                    </Button>
                    <Button
                        onClick={handleUpdateConfirm}
                        variant="contained"
                        sx={{
                            bgcolor: '#ff6d00',
                            color: 'white',
                            fontWeight: 'bold',
                            '&:hover': { bgcolor: '#e65100' }
                        }}
                    >
                        Confirmer
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Dialog de confirmation de suppression */}
            <Dialog open={isDeleteConfirmOpen} onClose={() => setIsDeleteConfirmOpen(false)}>
                <DialogTitle sx={{ fontWeight: 'bold', fontSize: '1.25rem', color: '#d32f2f' }}>
                    Supprimer mon compte
                </DialogTitle>
                <DialogContent sx={{ pt: 3 }}>
                    <Typography variant="body1" sx={{ mb: 2 }}>
                        Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
                    </Typography>
                    <Typography variant="body2" color="error" sx={{ fontWeight: 'bold' }}>
                        Toutes vos données seront supprimées définitivement.
                    </Typography>
                </DialogContent>
                <DialogActions sx={{ p: 2 }}>
                    <Button onClick={() => setIsDeleteConfirmOpen(false)} sx={{ color: '#666' }}>
                        Annuler
                    </Button>
                    <Button
                        onClick={handleDeleteConfirm}
                        variant="contained"
                        color="error"
                        sx={{ fontWeight: 'bold' }}
                    >
                        Supprimer définitivement
                    </Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default Profile;
