import { useMemo, useState, useEffect } from 'react';
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
    DialogContent,
    DialogActions
} from '@mui/material';

import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import PersonIcon from '@mui/icons-material/Person';
import EmailIcon from '@mui/icons-material/Email';
import PhoneIcon from '@mui/icons-material/Phone';
import BadgeIcon from '@mui/icons-material/Badge';
import CakeIcon from '@mui/icons-material/Cake';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import CloseIcon from '@mui/icons-material/Close';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import { createAvatar } from '@dicebear/core';
import { thumbs } from '@dicebear/collection';
import { formatDate } from '../../utils/dateUtils';
import { updateUser, deleteUser, getUserStats, getUserHistory } from '../../api/user';
import { saveOrUpdateAddress } from '../../api/address';
import type { UserUpdate } from '../../models/user.model';
import type { AddressCreation } from '../../models';
import type { UserStats, UserHistoryItem } from '../../api/user';

const Profile = () => {
    const navigate = useNavigate();
    const { user, isClubManager, isRaidManager, isRaceManager, isAdmin, refreshUser, logout } = useUser();
    const { showAlert } = useAlert();
    const [isEditMode, setIsEditMode] = useState(false);
    const [isDeleteConfirmOpen, setIsDeleteConfirmOpen] = useState(false);
    const [isUpdateConfirmOpen, setIsUpdateConfirmOpen] = useState(false);
    const [stats, setStats] = useState<UserStats | null>(null);
    const [history, setHistory] = useState<UserHistoryItem[]>([]);

    const [formData, setFormData] = useState({
        firstName: user?.USE_NAME || '',
        lastName: user?.USE_LAST_NAME || '',
        email: user?.USE_MAIL || '',
        phone: (user?.USE_PHONE_NUMBER || '').toString(),
        birthDate: user?.USE_BIRTHDATE || '',
        licenceNumber: (user?.USE_LICENCE_NUMBER || '').toString(),
        city: user?.address?.ADD_CITY || '',
        postalCode: (user?.address?.ADD_POSTAL_CODE || '').toString(),
        street: user?.address?.ADD_STREET_NAME || '',
        streetNumber: (user?.address?.ADD_STREET_NUMBER || '').toString(),
    });
    const [errors, setErrors] = useState<{ [key: string]: string }>({});

    // Charger les statistiques et l'historique
    useEffect(() => {
        if (user) {
            const loadUserData = async () => {
                try {
                    const userStats = await getUserStats(user.USE_ID);
                    setStats(userStats);

                    const userHistory = await getUserHistory(user.USE_ID);
                    setHistory(userHistory);
                } catch (error) {
                    console.error('Erreur lors du chargement des données:', error);
                }
            };

            loadUserData();
        }
    }, [user]);

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
            phone: (user.USE_PHONE_NUMBER || '').toString(),
            birthDate: user.USE_BIRTHDATE || '',
            licenceNumber: (user.USE_LICENCE_NUMBER || '').toString(),
            city: user.address?.ADD_CITY || '',
            postalCode: (user.address?.ADD_POSTAL_CODE || '').toString(),
            street: user.address?.ADD_STREET_NAME || '',
            streetNumber: (user.address?.ADD_STREET_NUMBER || '').toString(),
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
            // Validation du code postal
            const postalCode = parseInt(formData.postalCode);
            if (isNaN(postalCode) || postalCode > 99999) {
                throw new Error('Code postal invalide: ' + formData.postalCode);
            }

            // Mise à jour de l'utilisateur
            const updateData: UserUpdate = {
                USE_NAME: formData.firstName,
                USE_LAST_NAME: formData.lastName,
                USE_PHONE_NUMBER: formData.phone ? parseInt(formData.phone as string) : undefined,
                USE_BIRTHDATE: formData.birthDate || undefined,
                USE_LICENCE_NUMBER: formData.licenceNumber || undefined,
            };
            
            await updateUser(user.USE_ID, updateData);

            // Mise à jour ou création de l'adresse
            const addressData: AddressCreation = {
                ADD_CITY: formData.city,
                ADD_POSTAL_CODE: formData.postalCode,
                ADD_STREET_NAME: formData.street || '',
                ADD_STREET_NUMBER: formData.streetNumber || '',
            };
            
            const savedAddress = await saveOrUpdateAddress(user.address?.ADD_ID, addressData);
            
            // Si création d'une nouvelle adresse, lier l'utilisateur à l'adresse
            if (!user.address?.ADD_ID && savedAddress.ADD_ID) {
                await updateUser(user.USE_ID, { ADD_ID: savedAddress.ADD_ID } as any);
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
            
            // Affiche les détails de l'erreur si disponibles
            if (error?.data?.errors) {
                console.error('Erreurs de validation:', error.data.errors);
                const errorMessages = Object.entries(error.data.errors)
                    .map(([field, msgs]: [string, any]) => `${field}: ${Array.isArray(msgs) ? msgs.join(', ') : msgs}`)
                    .join('\n');
                showAlert(`Erreur de validation:\n${errorMessages}`, 'error');
            } else if (error?.message) {
                showAlert(`Erreur: ${error.message}`, 'error');
            } else {
                showAlert('Erreur lors de la mise à jour du profil', 'error');
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
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Course courues : {stats?.racesRun || 0}</Typography>
                                    </Box>
                                    <Box sx={{ bgcolor: '#f0f0f0', p: 3, borderRadius: '16px', flex: 1, textAlign: 'center' }}>
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Podiums : {stats?.podiums || 0}</Typography>
                                    </Box>
                                    <Box sx={{ bgcolor: '#f0f0f0', p: 3, borderRadius: '16px', flex: 1, textAlign: 'center' }}>
                                        <Typography variant="body2" color="text.secondary" sx={{ mb: 1 }}>Points total : {stats?.totalPoints || 0} points</Typography>
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
                                            {history.map((row, index) => (
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
                            </Paper>
                        </Stack>
                    </Stack>
                </Stack>
            </Container>

            {/* Dialog de modification */}
            <Dialog open={isEditMode} onClose={handleEditClose} maxWidth="sm" fullWidth PaperProps={{ sx: { borderRadius: '20px' } }}>
                <Box sx={{ background: 'linear-gradient(135deg, #2D5A27 0%, #1b5e20 100%)', p: 3, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <Typography variant="h5" sx={{ fontWeight: 'bold', color: 'white', display: 'flex', alignItems: 'center', gap: 1 }}>
                        <EditIcon /> Modifier mon profil
                    </Typography>
                    <Button onClick={handleEditClose} sx={{ color: 'white', minWidth: 'auto', p: 0 }}>
                        <CloseIcon />
                    </Button>
                </Box>
                
                <DialogContent sx={{ pt: 4, pb: 2 }}>
                    <Stack spacing={4}>
                        {/* Informations personnelles */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 'bold', color: '#2D5A27', mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                                <PersonIcon fontSize="small" /> Informations personnelles
                            </Typography>
                            <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                                <TextField
                                    fullWidth
                                    label="Prénom"
                                    name="firstName"
                                    value={formData.firstName}
                                    onChange={handleFormChange}
                                    variant="outlined"
                                    InputProps={{ startAdornment: <PersonIcon sx={{ mr: 1, color: '#2D5A27' }} /> }}
                                    sx={{
                                        '& .MuiOutlinedInput-root': {
                                            borderRadius: '12px',
                                            '&:hover fieldset': { borderColor: '#ff6d00' }
                                        }
                                    }}
                                />
                                <TextField
                                    fullWidth
                                    label="Nom"
                                    name="lastName"
                                    value={formData.lastName}
                                    onChange={handleFormChange}
                                    variant="outlined"
                                    InputProps={{ startAdornment: <PersonIcon sx={{ mr: 1, color: '#2D5A27' }} /> }}
                                    sx={{
                                        '& .MuiOutlinedInput-root': {
                                            borderRadius: '12px',
                                            '&:hover fieldset': { borderColor: '#ff6d00' }
                                        }
                                    }}
                                />
                            </Stack>
                        </Box>

                        {/* Coordonnées */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 'bold', color: '#2D5A27', mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                                <PhoneIcon fontSize="small" /> Coordonnées
                            </Typography>
                            <Stack spacing={2}>
                                <TextField
                                    fullWidth
                                    label="Email"
                                    name="email"
                                    type="email"
                                    value={formData.email}
                                    onChange={handleFormChange}
                                    variant="outlined"
                                    disabled
                                    InputProps={{ startAdornment: <EmailIcon sx={{ mr: 1, color: '#999' }} /> }}
                                    sx={{
                                        '& .MuiOutlinedInput-root': {
                                            borderRadius: '12px',
                                            bgcolor: '#f5f5f5'
                                        }
                                    }}
                                />
                                <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                                    <TextField
                                        fullWidth
                                        label="Téléphone"
                                        name="phone"
                                        value={formData.phone}
                                        onChange={handleFormChange}
                                        variant="outlined"
                                        InputProps={{ startAdornment: <PhoneIcon sx={{ mr: 1, color: '#2D5A27' }} /> }}
                                        sx={{
                                            '& .MuiOutlinedInput-root': {
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
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
                                        InputProps={{ startAdornment: <CakeIcon sx={{ mr: 1, color: '#2D5A27' }} /> }}
                                        sx={{
                                            '& .MuiOutlinedInput-root': {
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
                                    />
                                </Stack>
                            </Stack>
                        </Box>

                        {/* Données de courses */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 'bold', color: '#2D5A27', mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                                <BadgeIcon fontSize="small" /> Données de courses
                            </Typography>
                            <TextField
                                fullWidth
                                label="Numéro de licence"
                                name="licenceNumber"
                                value={formData.licenceNumber}
                                onChange={handleFormChange}
                                variant="outlined"
                                InputProps={{ startAdornment: <BadgeIcon sx={{ mr: 1, color: '#2D5A27' }} /> }}
                                sx={{
                                    '& .MuiOutlinedInput-root': {
                                        borderRadius: '12px',
                                        '&:hover fieldset': { borderColor: '#ff6d00' }
                                    }
                                }}
                            />
                        </Box>

                        {/* Adresse */}
                        <Box>
                            <Typography variant="subtitle1" sx={{ fontWeight: 'bold', color: '#2D5A27', mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                                <LocationOnIcon fontSize="small" /> Adresse
                            </Typography>
                            <Stack spacing={2}>
                                <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2}>
                                    <TextField
                                        fullWidth
                                        label="Numéro"
                                        name="streetNumber"
                                        value={formData.streetNumber}
                                        onChange={handleFormChange}
                                        variant="outlined"
                                        sx={{
                                            '& .MuiOutlinedInput-root': {
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
                                    />
                                    <TextField
                                        fullWidth
                                        label="Rue"
                                        name="street"
                                        value={formData.street}
                                        onChange={handleFormChange}
                                        variant="outlined"
                                        sx={{
                                            '& .MuiOutlinedInput-root': {
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
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
                                        sx={{
                                            '& .MuiOutlinedInput-root': {
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
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
                                                borderRadius: '12px',
                                                '&:hover fieldset': { borderColor: '#ff6d00' }
                                            }
                                        }}
                                    />
                                </Stack>
                            </Stack>
                        </Box>
                    </Stack>
                </DialogContent>
                
                <DialogActions sx={{ p: 2, gap: 1, background: '#f5f5f5', borderTop: '1px solid #e0e0e0', borderRadius: '0 0 20px 20px' }}>
                    <Button 
                        onClick={handleEditClose} 
                        sx={{ 
                            color: '#666',
                            borderRadius: '12px',
                            '&:hover': { bgcolor: '#e0e0e0' }
                        }}
                        startIcon={<CloseIcon />}
                    >
                        Annuler
                    </Button>
                    <Button
                        onClick={handleSave}
                        variant="contained"
                        sx={{
                            bgcolor: '#ff6d00',
                            color: 'white',
                            fontWeight: 'bold',
                            borderRadius: '12px',
                            '&:hover': { bgcolor: '#e65100' }
                        }}
                        startIcon={<CheckCircleIcon />}
                    >
                        Enregistrer
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Dialog de confirmation de mise à jour */}
            <Dialog open={isUpdateConfirmOpen} onClose={() => setIsUpdateConfirmOpen(false)} PaperProps={{ sx: { borderRadius: '20px' } }}>
                <Box sx={{ background: 'linear-gradient(135deg, #ff6d00 0%, #e65100 100%)', p: 3, borderRadius: '20px 20px 0 0' }}>
                    <Typography variant="h6" sx={{ fontWeight: 'bold', color: 'white', display: 'flex', alignItems: 'center', gap: 1 }}>
                        <CheckCircleIcon /> Confirmer les modifications
                    </Typography>
                </Box>
                <DialogContent sx={{ pt: 4, pb: 2 }}>
                    <Stack spacing={2}>
                        <Typography variant="body1">
                            Êtes-vous sûr de vouloir mettre à jour votre profil ?
                        </Typography>
                        <Box sx={{ bgcolor: '#f5f5f5', p: 2, borderRadius: '12px', borderLeft: '4px solid #ff6d00' }}>
                            <Typography variant="body2" color="textSecondary">
                                Vos informations personnelles, adresse et données de course seront mises à jour.
                            </Typography>
                        </Box>
                    </Stack>
                </DialogContent>
                <DialogActions sx={{ p: 2, gap: 1, background: '#f5f5f5', borderTop: '1px solid #e0e0e0', borderRadius: '0 0 20px 20px' }}>
                    <Button onClick={() => setIsUpdateConfirmOpen(false)} sx={{ color: '#666', borderRadius: '12px' }} startIcon={<CloseIcon />}>
                        Annuler
                    </Button>
                    <Button
                        onClick={handleUpdateConfirm}
                        variant="contained"
                        sx={{
                            bgcolor: '#ff6d00',
                            color: 'white',
                            fontWeight: 'bold',
                            borderRadius: '12px',
                            '&:hover': { bgcolor: '#e65100' }
                        }}
                        startIcon={<CheckCircleIcon />}
                    >
                        Confirmer
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Dialog de confirmation de suppression */}
            <Dialog open={isDeleteConfirmOpen} onClose={() => setIsDeleteConfirmOpen(false)} PaperProps={{ sx: { borderRadius: '20px' } }}>
                <Box sx={{ background: 'linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%)', p: 3, borderRadius: '20px 20px 0 0' }}>
                    <Typography variant="h6" sx={{ fontWeight: 'bold', color: 'white', display: 'flex', alignItems: 'center', gap: 1 }}>
                        <DeleteIcon /> Supprimer mon compte
                    </Typography>
                </Box>
                <DialogContent sx={{ pt: 4, pb: 2 }}>
                    <Stack spacing={2}>
                        <Typography variant="body1">
                            Êtes-vous sûr de vouloir supprimer votre compte ? <strong>Cette action est irréversible.</strong>
                        </Typography>
                        <Box sx={{ bgcolor: '#ffebee', p: 2, borderRadius: '12px', borderLeft: '4px solid #d32f2f' }}>
                            <Typography variant="body2" sx={{ color: '#d32f2f', fontWeight: 'bold' }}>
                                Toutes vos données seront supprimées définitivement, y compris vos courses, statistiques et adresse.
                            </Typography>
                        </Box>
                    </Stack>
                </DialogContent>
                <DialogActions sx={{ p: 2, gap: 1, background: '#f5f5f5', borderTop: '1px solid #e0e0e0', borderRadius: '0 0 20px 20px' }}>
                    <Button onClick={() => setIsDeleteConfirmOpen(false)} sx={{ color: '#666', borderRadius: '12px' }} startIcon={<CloseIcon />}>
                        Annuler
                    </Button>
                    <Button
                        onClick={handleDeleteConfirm}
                        variant="contained"
                        color="error"
                        sx={{ 
                            fontWeight: 'bold',
                            borderRadius: '12px',
                            '&:hover': { bgcolor: '#b71c1c' }
                        }}
                        startIcon={<DeleteIcon />}
                    >
                        Supprimer définitivement
                    </Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default Profile;
