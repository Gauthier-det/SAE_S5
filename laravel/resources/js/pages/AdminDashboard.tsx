import { useEffect, useState } from 'react';
import {
    Box,
    Container,
    Button,
    Paper,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Stack,
    IconButton,
    CircularProgress
} from '@mui/material';
import DeleteIcon from '@mui/icons-material/Delete';
import EditIcon from '@mui/icons-material/Edit';
import { useNavigate } from 'react-router-dom';
import { useUser } from '../contexts/userContext';
import { useAlert } from '../contexts/AlertContext';
import { getListOfClubs, deleteClub } from '../api/club';
import { getAllUsers } from '../api/user';
import type { Club } from '../models/club.model';
import type { User } from '../models/user.model';
import ClubFormModal from '../components/admin/ClubFormModal';

const AdminDashboard = () => {
    const { isAdmin, loading } = useUser();
    const navigate = useNavigate();
    const { showAlert, showConfirm } = useAlert();
    const [clubs, setClubs] = useState<Club[]>([]);
    const [users, setUsers] = useState<User[]>([]);
    const [modalOpen, setModalOpen] = useState(false);
    const [selectedClub, setSelectedClub] = useState<Club | null>(null);
    const [dataLoading, setDataLoading] = useState(true);

    useEffect(() => {
        if (!loading && !isAdmin) {
            navigate('/');
        }
    }, [isAdmin, loading, navigate]);

    const fetchData = async () => {
        setDataLoading(true);
        try {
            const [clubsData, usersData] = await Promise.all([
                getListOfClubs(),
                getAllUsers()
            ]);
            setClubs(clubsData);
            setUsers(usersData);
        } catch (error) {
            console.error("Failed to fetch data", error);
            showAlert('Erreur lors du chargement des données', 'error');
        } finally {
            setDataLoading(false);
        }
    };

    useEffect(() => {
        if (isAdmin) {
            fetchData();
        }
    }, [isAdmin]);

    const handleCreate = () => {
        setSelectedClub(null);
        setModalOpen(true);
    };

    const handleEdit = (club: Club) => {
        setSelectedClub(club);
        setModalOpen(true);
    };

    const handleDelete = (id: number) => {
        showConfirm({
            message: 'Êtes-vous sûr de vouloir supprimer ce club ? Cette action est irréversible.',
            onAccept: async () => {
                try {
                    await deleteClub(id);
                    showAlert('Club supprimé avec succès', 'success');
                    fetchData();
                } catch (error) {
                    console.error("Failed to delete club", error);
                    showAlert('Erreur lors de la suppression du club', 'error');
                }
            }
        });
    };

    const handleModalSuccess = () => {
        fetchData();
    };

    if (loading) return null;

    if (dataLoading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh', bgcolor: '#1a2e22' }}>
                <CircularProgress color="warning" />
            </Box>
        );
    }

    return (
        <Box sx={{ minHeight: '100vh', bgcolor: '#1a2e22', py: 4 }}>
            <Container maxWidth="xl">
                <Box sx={{ display: 'flex', mb: 4 }}>
                    <Button
                        variant="contained"
                        onClick={handleCreate}
                        sx={{
                            bgcolor: '#f57c00',
                            color: 'white',
                            fontWeight: 'bold',
                            textTransform: 'none',
                            px: 4,
                            py: 1.5,
                            borderRadius: '8px',
                            '&:hover': { bgcolor: '#e65100' }
                        }}
                    >
                        Créer un club
                    </Button>
                </Box>

                <Paper sx={{ width: '100%', mb: 2, bgcolor: '#e0e0e0', borderRadius: '4px', overflow: 'hidden' }}>
                    <TableContainer>
                        <Table sx={{ minWidth: 750 }} aria-labelledby="tableTitle">
                            <TableHead>
                                <TableRow sx={{ bgcolor: '#d0d0d0' }}>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }}>Nom du Club</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }}>Année de création</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }}>Lieu</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }}>Nombre de licenciés</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }}>Responsable du club</TableCell>
                                    <TableCell sx={{ fontWeight: 'bold', color: '#333' }} align="right">Actions</TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {clubs.map((club, index) => (
                                    <TableRow
                                        hover
                                        key={club.CLU_ID}
                                        sx={{
                                            bgcolor: index % 2 === 0 ? '#f5f5f5' : '#ffffff',
                                            '&:hover': { bgcolor: '#eeeeee' }
                                        }}
                                    >
                                        <TableCell component="th" scope="row">
                                            {club.CLU_NAME}
                                        </TableCell>
                                        <TableCell>15/08/2025</TableCell>
                                        <TableCell>{club.address?.ADD_CITY || 'N/A'}</TableCell>
                                        <TableCell>{club.users_count || 0}</TableCell>
                                        <TableCell>{club.user?.USE_NAME} {club.user?.USE_LAST_NAME}</TableCell>
                                        <TableCell align="right">
                                            <Stack direction="row" spacing={1} justifyContent="flex-end">
                                                <IconButton
                                                    color="warning"
                                                    onClick={() => handleEdit(club)}
                                                    size="small"
                                                >
                                                    <EditIcon />
                                                </IconButton>
                                                <IconButton
                                                    color="error"
                                                    onClick={() => handleDelete(club.CLU_ID)}
                                                    size="small"
                                                >
                                                    <DeleteIcon />
                                                </IconButton>
                                            </Stack>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Paper>
            </Container>

            <ClubFormModal
                open={modalOpen}
                onClose={() => setModalOpen(false)}
                onSuccess={handleModalSuccess}
                club={selectedClub}
                users={users}
            />
        </Box>
    );
};

export default AdminDashboard;
