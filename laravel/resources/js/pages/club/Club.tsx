import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import {
    Box,
    Typography,
    Container,
    Paper,
    List,
    ListItem,
    ListItemAvatar,
    Avatar,
    ListItemText,
    ListItemSecondaryAction,
    IconButton,
    Grid,
    Divider,
    CircularProgress,
    TextField
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
    const [searchTerm, setSearchTerm] = useState('');

    const clubId = parseInt(id || '0');

    const filteredFreeRunners = freeRunners.filter(runner =>
        runner.USE_NAME.toLowerCase().includes(searchTerm.toLowerCase()) ||
        runner.USE_LAST_NAME.toLowerCase().includes(searchTerm.toLowerCase())
    );

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

    const handleAddMember = async (userId: number) => {
        try {
            await addMemberToClub(clubId, userId);
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

            <Grid container spacing={4}>
                {/* Members List */}
                <Grid xs={12} md={6}>
                    <Paper elevation={2} sx={{ borderRadius: 2, overflow: 'hidden' }}>
                        <Box sx={{ p: 2, bgcolor: 'primary.main', color: 'white' }}>
                            <Typography variant="h6" fontWeight="bold">Membres du Club ({members.length})</Typography>
                        </Box>
                        <List sx={{ maxHeight: 500, overflow: 'auto' }}>
                            {members.length === 0 ? (
                                <ListItem>
                                    <ListItemText primary="Aucun membre dans le club." />
                                </ListItem>
                            ) : (
                                members.map((member) => (
                                    <React.Fragment key={member.USE_ID}>
                                        <ListItem
                                            sx={{
                                                '&:hover': { bgcolor: 'action.hover' },
                                                transition: 'background-color 0.2s'
                                            }}
                                        >
                                            <ListItemAvatar>
                                                <Avatar sx={{ bgcolor: 'secondary.main', color: 'white' }}>
                                                    {member.USE_NAME.charAt(0)}
                                                </Avatar>
                                            </ListItemAvatar>
                                            <ListItemText
                                                primary={<Typography fontWeight="500">{member.USE_NAME} {member.USE_LAST_NAME}</Typography>}
                                                secondary={member.USE_MAIL}
                                            />
                                            <ListItemSecondaryAction>
                                                {user && user.USE_ID !== member.USE_ID && (
                                                    <IconButton edge="end" aria-label="delete" onClick={() => handleRemoveMember(member.USE_ID)}>
                                                        <DeleteIcon color="error" />
                                                    </IconButton>
                                                )}
                                            </ListItemSecondaryAction>
                                        </ListItem>
                                        <Divider variant="inset" component="li" />
                                    </React.Fragment>
                                ))
                            )}
                        </List>
                    </Paper>
                </Grid>

                {/* Free Runners List */}
                <Grid xs={12} md={6}>
                    <Paper elevation={2} sx={{ borderRadius: 2, overflow: 'hidden' }}>
                        <Box sx={{ p: 2, bgcolor: 'secondary.main', color: 'white' }}>
                            <Typography variant="h6" fontWeight="bold">Coureurs sans club ({freeRunners.length})</Typography>
                        </Box>
                        <Box sx={{ p: 2, bgcolor: 'background.default' }}>
                            <TextField
                                label="Rechercher un coureur"
                                variant="outlined"
                                fullWidth
                                size="small"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                sx={{ bgcolor: 'white' }}
                            />
                        </Box>
                        <List sx={{ maxHeight: 428, overflow: 'auto' }}>
                            {filteredFreeRunners.length === 0 ? (
                                <ListItem>
                                    <ListItemText
                                        primary={searchTerm ? "Aucun coureur trouvé" : "Aucun coureur disponible."}
                                        sx={{ textAlign: 'center', color: 'text.secondary', py: 2 }}
                                    />
                                </ListItem>
                            ) : (
                                filteredFreeRunners.map((runner) => (
                                    <React.Fragment key={runner.USE_ID}>
                                        <ListItem
                                            sx={{
                                                '&:hover': { bgcolor: 'action.hover' },
                                                transition: 'background-color 0.2s'
                                            }}
                                        >
                                            <ListItemAvatar>
                                                <Avatar>{runner.USE_NAME.charAt(0)}</Avatar>
                                            </ListItemAvatar>
                                            <ListItemText
                                                primary={<Typography fontWeight="500">{runner.USE_NAME} {runner.USE_LAST_NAME}</Typography>}
                                                secondary={runner.USE_MAIL}
                                            />
                                            <ListItemSecondaryAction>
                                                <IconButton edge="end" aria-label="add" onClick={() => handleAddMember(runner.USE_ID)}>
                                                    <PersonAddIcon color="primary" />
                                                </IconButton>
                                            </ListItemSecondaryAction>
                                        </ListItem>
                                        <Divider variant="inset" component="li" />
                                    </React.Fragment>
                                ))
                            )}
                        </List>
                    </Paper>
                </Grid>
            </Grid>
        </Container>
    );
};

export default Club;