import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import {
    Box,
    Typography,
    Container,
    Paper,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Autocomplete,
    Button,
    TextField,
    CircularProgress,
    IconButton
} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import { getClub, getUsersByClub, addMemberToClub, removeMemberFromClub } from '../../api/club';
import { getFreeRunners } from '../../api/user';
import type { Club as ClubModel } from '../../models/club.model';
import type { User } from '../../models/user.model';
import { useAlert } from '../../contexts/AlertContext';

import { useUser } from '../../contexts/userContext';

const Club = () => {
    const { id } = useParams<{ id: string }>();
    const { showAlert, showConfirm } = useAlert();
    const { user } = useUser();
    const [club, setClub] = useState<ClubModel | null>(null);
    const [members, setMembers] = useState<User[]>([]);
    const [freeRunners, setFreeRunners] = useState<User[]>([]);
    const [loading, setLoading] = useState(true);
    const [selectedRunner, setSelectedRunner] = useState<User | null>(null);

    const clubId = parseInt(id || '0');

    const fetchData = async () => {
        try {
            setLoading(true);
            const [clubData, membersData, freeRunnersData] = await Promise.all([
                getClub(clubId),
                getUsersByClub(clubId),
                getFreeRunners()
            ]);
            setClub(clubData);
            setMembers(membersData);
            setFreeRunners(freeRunnersData);
            setSelectedRunner(null); // Reset selection after refresh
        } catch (error) {
            console.error("Error fetching club data:", error);
            showAlert('Erreur lors du chargement des données', 'error');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        if (clubId) {
            fetchData();
        }
    }, [clubId]);

    const handleAddMember = async () => {
        if (!selectedRunner) return;

        try {
            await addMemberToClub(clubId, selectedRunner.USE_ID);
            showAlert('Membre ajouté avec succès', 'success');
            fetchData(); // Refresh lists
        } catch (error) {
            console.error("Error adding member:", error);
            showAlert('Erreur lors de l\'ajout du membre', 'error');
        }
    };

    const handleRemoveMember = async (userId: number) => {
        showConfirm({
            message: 'Êtes-vous sûr de vouloir retirer ce membre du club ?',
            onAccept: async () => {
                try {
                    await removeMemberFromClub(clubId, userId);
                    showAlert('Membre retiré du club', 'success');
                    fetchData(); // Refresh lists
                } catch (error) {
                    console.error("Error removing member:", error);
                    showAlert('Erreur lors du retrait du membre', 'error');
                }
            }
        });
    };

    if (loading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
                <CircularProgress />
            </Box>
        );
    }

    if (!club) {
        return (
            <Container>
                <Typography variant="h5" sx={{ mt: 4 }}>Club introuvable</Typography>
            </Container>
        );
    }

    return (
        <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
            <Typography variant="h3" gutterBottom sx={{ fontFamily: '"Archivo Black", sans-serif', color: 'primary.main', mb: 3 }}>
                {club.CLU_NAME}
            </Typography>

            <Paper elevation={3} sx={{ p: 3, mb: 4, borderRadius: 2 }}>
                <Typography variant="h6" gutterBottom color="secondary.main" fontWeight="bold">
                    Ajouter un membre
                </Typography>
                <Box sx={{ display: 'flex', gap: 2, alignItems: 'center' }}>
                    <Autocomplete
                        options={freeRunners}
                        getOptionLabel={(option) => `${option.USE_NAME} ${option.USE_LAST_NAME} (${option.USE_MAIL})`}
                        value={selectedRunner}
                        onChange={(event, newValue) => setSelectedRunner(newValue)}
                        sx={{ flexGrow: 1 }}
                        renderInput={(params) => <TextField {...params} label="Rechercher un coureur sans club" variant="outlined" />}
                        noOptionsText="Aucun coureur disponible"
                    />
                    <Button
                        variant="contained"
                        color="success"
                        startIcon={<PersonAddIcon />}
                        onClick={handleAddMember}
                        disabled={!selectedRunner}
                        sx={{ height: 56, borderRadius: '4px', px: 3, color: 'white' }}
                    >
                        Ajouter
                    </Button>
                </Box>
            </Paper>

            <Paper elevation={3} sx={{ borderRadius: 2, overflow: 'hidden' }}>
                <Box sx={{ p: 2, bgcolor: 'primary.main', color: 'white' }}>
                    <Typography variant="h6" fontWeight="bold">Membres du Club ({members.length})</Typography>
                </Box>
                <TableContainer>
                    <Table>
                        <TableHead>
                            <TableRow>
                                <TableCell sx={{ fontWeight: 'bold' }}>Nom</TableCell>
                                <TableCell sx={{ fontWeight: 'bold' }}>Prénom</TableCell>
                                <TableCell sx={{ fontWeight: 'bold' }}>Email</TableCell>
                                <TableCell align="right" sx={{ fontWeight: 'bold' }}>Actions</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {members.length === 0 ? (
                                <TableRow>
                                    <TableCell colSpan={4} align="center">
                                        Aucun membre dans le club.
                                    </TableCell>
                                </TableRow>
                            ) : (
                                members.map((member) => (
                                    <TableRow key={member.USE_ID} hover>
                                        <TableCell>{member.USE_LAST_NAME}</TableCell>
                                        <TableCell>{member.USE_NAME}</TableCell>
                                        <TableCell>{member.USE_MAIL}</TableCell>
                                        <TableCell align="right">
                                            {user && user.USE_ID !== member.USE_ID && (
                                                <IconButton
                                                    aria-label="delete"
                                                    onClick={() => handleRemoveMember(member.USE_ID)}
                                                    color="error"
                                                    size="small"
                                                >
                                                    <DeleteIcon />
                                                </IconButton>
                                            )}
                                        </TableCell>
                                    </TableRow>
                                ))
                            )}
                        </TableBody>
                    </Table>
                </TableContainer>
            </Paper>
        </Container>
    );
};

export default Club;