import { useEffect, useState, useMemo } from 'react';
import {
    Box,
    Container,
    Paper,
    Typography,
    Button,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Stack,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    TextField,
    Alert,
    CircularProgress,
    Chip,
    MenuItem
} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import { useAlert } from '../contexts/AlertContext';
import { getClubForManager, addUserToClub, removeUserFromClub, getMyManagedClub } from '../api/club';
import { getAllUsers } from '../api/user';
import type { Club } from '../models';
import type { User } from '../models/user.model';

const ClubPage = () => {
    const { showAlert } = useAlert();
    const [club, setClub] = useState<Club & { users: User[] } | null>(null);
    const [loading, setLoading] = useState(true);
    const [openAddMemberDialog, setOpenAddMemberDialog] = useState(false);
    const [allUsers, setAllUsers] = useState<User[]>([]);
    const [selectedUserId, setSelectedUserId] = useState<number | null>(null);
    const [loadingAddMember, setLoadingAddMember] = useState(false);

    useEffect(() => {
        const fetchClubData = async () => {
            try {
                const clubData = await getMyManagedClub();
                setClub(clubData);
                const usersData = await getAllUsers();
                setAllUsers(usersData);
            } catch (error) {
                console.error('Error fetching club data', error);

                // If 404, it means user has no club, specific message
                if ((error as any)?.response?.status === 404) {
                    showAlert('Vous ne gérez aucun club.', 'error');
                } else {
                    showAlert('Erreur lors du chargement du club', 'error');
                }
            } finally {
                setLoading(false);
            }
        };

        fetchClubData();
    }, [showAlert]);

    const handleOpenAddMemberDialog = () => {
        setOpenAddMemberDialog(true);
    };

    const handleCloseAddMemberDialog = () => {
        setOpenAddMemberDialog(false);
        setSelectedUserId(null);
    };

    const handleAddMember = async () => {
        if (!selectedUserId || !club) return;

        setLoadingAddMember(true);
        try {
            await addUserToClub(club.CLU_ID, selectedUserId);
            showAlert('Utilisateur ajouté au club avec succès', 'success');

            // Refresh club data
            const updatedClub = await getClubForManager(club.CLU_ID);
            setClub(updatedClub);
            handleCloseAddMemberDialog();
        } catch (error: any) {
            console.error('Error adding member', error);
            const errorMessage = error.response?.data?.message || 'Erreur lors de l\'ajout du membre';
            showAlert(errorMessage, 'error');
        } finally {
            setLoadingAddMember(false);
        }
    };

    const handleRemoveMember = async (memberId: number) => {
        if (!club) return;

        if (confirm('Êtes-vous sûr de vouloir retirer ce membre du club ?')) {
            try {
                await removeUserFromClub(club.CLU_ID, memberId);
                showAlert('Membre retiré du club avec succès', 'success');

                // Refresh club data
                const updatedClub = await getClubForManager(club.CLU_ID);
                setClub(updatedClub);
            } catch (error: any) {
                console.error('Error removing member', error);
                const errorMessage = error.response?.data?.message || 'Erreur lors du retrait du membre';
                showAlert(errorMessage, 'error');
            }
        }
    };

    // Get users not in the club (excluding club manager)
    const availableUsers = useMemo(() => {
        if (!club) return [];
        return allUsers.filter(u =>
            u.CLU_ID !== club.CLU_ID && u.USE_ID !== club.USE_ID
        );
    }, [allUsers, club]);

    if (loading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh' }}>
                <CircularProgress />
            </Box>
        );
    }

    if (!club) {
        return (
            <Container maxWidth="lg" sx={{ py: 4 }}>
                <Alert severity="error">Vous n'êtes pas responsable d'un club</Alert>
            </Container>
        );
    }

    return (
        <Box sx={{ flexGrow: 1, minHeight: 'calc(100vh - 64px)', py: 4, bgcolor: '#f5f5f5' }}>
            <Container maxWidth="lg">
                {/* Club Header */}
                <Paper
                    elevation={0}
                    sx={{
                        p: 4,
                        mb: 4,
                        borderRadius: '24px',
                        bgcolor: 'white',
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center'
                    }}
                >
                    <Box>
                        <Typography variant="h3" sx={{ fontWeight: 'bold', mb: 1 }}>
                            {club.CLU_NAME}
                        </Typography>
                        <Stack direction="row" spacing={2} sx={{ mt: 2 }}>
                            {club.address && (
                                <Typography variant="body2" color="textSecondary">
                                    📍 {club.address.ADD_STREET_NUMBER} {club.address.ADD_STREET_NAME}, {club.address.ADD_POSTAL_CODE} {club.address.ADD_CITY}
                                </Typography>
                            )}
                            <Chip
                                label={`${club.users?.length || 0} membre${(club.users?.length || 0) > 1 ? 's' : ''}`}
                                color="primary"
                                size="small"
                            />
                        </Stack>
                    </Box>
                    <Button
                        variant="contained"
                        startIcon={<AddIcon />}
                        onClick={handleOpenAddMemberDialog}
                        sx={{
                            bgcolor: '#2e7d32',
                            color: 'white',
                            fontWeight: 'bold',
                            borderRadius: '12px',
                            py: 1.5,
                            px: 3,
                            '&:hover': { bgcolor: '#1b5e20' }
                        }}
                    >
                        Ajouter un membre
                    </Button>
                </Paper>

                {/* Members Table */}
                <Paper elevation={0} sx={{ borderRadius: '24px', bgcolor: 'white', overflow: 'hidden' }}>
                    <TableContainer>
                        <Table>
                            <TableHead>
                                <TableRow sx={{ bgcolor: '#f5f5f5' }}>
                                    <TableCell sx={{ fontWeight: 'bold' }}>Nom</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold' }}>Email</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold' }}>Téléphone</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold' }}>Rôle</TableCell>
                                    <TableCell align="right" sx={{ fontWeight: 'bold' }}>Actions</TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {club.users && club.users.length > 0 ? (
                                    club.users.map((member) => (
                                        <TableRow key={member.USE_ID} hover>
                                            <TableCell>
                                                <Stack direction="row" spacing={1} alignItems="center">
                                                    <Typography variant="body2">
                                                        {member.USE_NAME} {member.USE_LAST_NAME}
                                                    </Typography>
                                                </Stack>
                                            </TableCell>
                                            <TableCell>
                                                <Typography variant="body2">{member.USE_MAIL}</Typography>
                                            </TableCell>
                                            <TableCell>
                                                <Typography variant="body2">{member.USE_PHONE_NUMBER || '-'}</Typography>
                                            </TableCell>
                                            <TableCell>
                                                {member.USE_ID === club.USE_ID ? (
                                                    <Chip label="Responsable" color="primary" size="small" />
                                                ) : (
                                                    <Chip label="Membre" size="small" />
                                                )}
                                            </TableCell>
                                            <TableCell align="right">
                                                {member.USE_ID !== club.USE_ID && (
                                                    <Button
                                                        startIcon={<DeleteIcon />}
                                                        color="error"
                                                        size="small"
                                                        onClick={() => handleRemoveMember(member.USE_ID)}
                                                        sx={{ textTransform: 'none' }}
                                                    >
                                                        Retirer
                                                    </Button>
                                                )}
                                            </TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={5} align="center" sx={{ py: 4 }}>
                                            <Typography color="textSecondary">Aucun membre dans ce club</Typography>
                                        </TableCell>
                                    </TableRow>
                                )}
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Paper>

                {/* Add Member Dialog */}
                <Dialog open={openAddMemberDialog} onClose={handleCloseAddMemberDialog} maxWidth="sm" fullWidth>
                    <DialogTitle sx={{ fontWeight: 'bold' }}>Ajouter un membre</DialogTitle>
                    <DialogContent sx={{ pt: 3 }}>
                        {availableUsers.length === 0 ? (
                            <Alert severity="info">Aucun utilisateur disponible à ajouter</Alert>
                        ) : (
                            <TextField
                                select
                                fullWidth
                                label="Sélectionner un utilisateur"
                                value={selectedUserId || ''}
                                onChange={(e) => setSelectedUserId(Number(e.target.value))}
                            >
                                {availableUsers.map((u) => (
                                    <MenuItem key={u.USE_ID} value={u.USE_ID}>
                                        {u.USE_NAME} {u.USE_LAST_NAME} ({u.USE_MAIL})
                                    </MenuItem>
                                ))}
                            </TextField>
                        )}
                    </DialogContent>
                    <DialogActions sx={{ p: 2 }}>
                        <Button onClick={handleCloseAddMemberDialog}>Annuler</Button>
                        <Button
                            onClick={handleAddMember}
                            variant="contained"
                            disabled={!selectedUserId || loadingAddMember}
                            sx={{
                                bgcolor: '#2e7d32',
                                color: 'white',
                                '&:hover': { bgcolor: '#1b5e20' },
                                '&:disabled': { bgcolor: '#ccc' }
                            }}
                        >
                            {loadingAddMember ? <CircularProgress size={24} /> : 'Ajouter'}
                        </Button>
                    </DialogActions>
                </Dialog>
            </Container>
        </Box>
    );
};

export default ClubPage;
