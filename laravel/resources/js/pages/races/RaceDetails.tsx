import { useEffect, useState, useMemo } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaceDetails, importRaceResults, deleteRaceResults, deleteRace } from '../../api/race';
import { validateTeamForRace, unvalidateTeamForRace } from '../../api/team';
import type { RaceDetail, TeamDetail } from '../../models/race.model';
import dayjs from 'dayjs';
import {
    Container, Box, Typography, Button, LinearProgress, Card, Chip, Paper,
    TextField, Dialog, DialogTitle, DialogContent, DialogActions, List, ListItem, ListItemText, ListItemAvatar, Avatar, IconButton, InputAdornment, Collapse,
    Tooltip, Stack, CircularProgress
} from '@mui/material';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import GroupsIcon from '@mui/icons-material/Groups';
import EventIcon from '@mui/icons-material/Event';
import PersonIcon from '@mui/icons-material/Person';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import CancelIcon from '@mui/icons-material/Cancel';
import RuleIcon from '@mui/icons-material/Rule';
import SearchIcon from '@mui/icons-material/Search';
import CloseIcon from '@mui/icons-material/Close';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import KeyboardArrowUpIcon from '@mui/icons-material/KeyboardArrowUp';
import ReportProblemIcon from '@mui/icons-material/ReportProblem';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import LockIcon from '@mui/icons-material/Lock';
import StarIcon from '@mui/icons-material/Star';
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import { formatDateWithHour } from '../../utils/dateUtils';

export default function RaceDetails() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const { user, isAuthenticated, isAdmin } = useUser();
    const { showAlert } = useAlert();
    const [race, setRace] = useState<RaceDetail | null>(null);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedTeam, setSelectedTeam] = useState<TeamDetail | null>(null);
    const [modalOpen, setModalOpen] = useState(false);
    const [resultsModalOpen, setResultsModalOpen] = useState(false);
    const [resultFile, setResultFile] = useState<File | null>(null);
    const [importing, setImporting] = useState(false);
    const [importError, setImportError] = useState<string | null>(null);
    const [importSuccess, setImportSuccess] = useState<string | null>(null);
    const [teamsListOpen, setTeamsListOpen] = useState(false);
    const [deleteModalOpen, setDeleteModalOpen] = useState(false);
    const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (id) {
            setLoading(true);
            getRaceDetails(parseInt(id))
                .then(setRace)
                .catch(console.error)
                .finally(() => setLoading(false));
        }
    }, [id]);

    const handleDeleteResults = async () => {
        if (!race) return;
        try {
            await deleteRaceResults(race.RAC_ID);
            setDeleteModalOpen(false);
            // Refresh details
            getRaceDetails(race.RAC_ID).then(setRace).catch(console.error);
        } catch (error) {
            console.error("Failed to delete results", error);
        }
    };

    const { myTeams, otherTeams } = useMemo(() => {
        if (!race || !race.teams_list) return { myTeams: [], otherTeams: [] };

        const filtered = race.teams_list.filter(team =>
            team.name.toLowerCase().includes(searchTerm.toLowerCase())
        );

        const my = [];
        const others = [];

        if (isAuthenticated && user) {
            for (const team of filtered) {
                const isResponsible = team.responsible?.id === user.USE_ID;
                const isMember = team.members.some(m => m.id === user.USE_ID);
                if (isResponsible || isMember) {
                    my.push({ ...team, isResponsible, isMember });
                } else {
                    others.push(team);
                }
            }
        } else {
            others.push(...filtered);
        }

        return { myTeams: my, otherTeams: others };
    }, [race, searchTerm, user, isAuthenticated]);

    // Check if registration deadline has passed
    const disableEditing = race?.raid ? dayjs().isAfter(dayjs(race.raid.RAI_REGISTRATION_END)) : false;
    console.log("journee passe:", dayjs(race?.raid.RAI_REGISTRATION_END), "journnee now:", dayjs(), "disableEditing:", disableEditing);

    const handleOpenTeamModal = (team: TeamDetail) => {
        if (!isAuthenticated) return;
        setSelectedTeam(team);
        setModalOpen(true);
    };

    const handleCloseModal = () => {
        setModalOpen(false);
        setSelectedTeam(null);
    };

    const handleCloseResultsModal = () => {
        setResultsModalOpen(false);
        setResultFile(null);
        setImportError(null);
        setImportSuccess(null);
    };

    const getButton = (race: RaceDetail) => {
        const now = new Date();
        const start = new Date(race.RAC_TIME_START);
        const end = new Date(race.RAC_TIME_END);

        if (now < start) {
            return <Typography variant="body2" color="text.secondary">En attente du départ</Typography>;
        }

        if (Number(race.user.USE_ID) === Number(user?.USE_ID)) {
            if (now >= start && now <= end) {
                return (
                    <Button variant="contained" color="info" sx={{ borderRadius: 2 }} onClick={() => navigate(`/races/${race.RAC_ID}/participants`)}>
                        Gérer le direct
                    </Button>
                );
            }

            if (race.has_results) {
                return (
                    <Button variant="contained" color="error" sx={{ borderRadius: 2 }} onClick={() => setDeleteModalOpen(true)}>
                        Supprimer les résultats
                    </Button>
                );
            } else {
                return (
                    <Button variant="contained" color="warning" sx={{ borderRadius: 2 }} onClick={() => setResultsModalOpen(true)}>
                        Ajouter les résultats
                    </Button>
                );
            }
        }

        if (now > end && !race.has_results) {
            return <Typography variant="body2" color="text.secondary">Résultats en attente de publication</Typography>;
        }

        return null;
    };

    const handleImportResults = async () => {
        if (!race || !resultFile) return;
        setImporting(true);
        setImportError(null);
        setImportSuccess(null);

        try {
            const result = await importRaceResults(race.RAC_ID, resultFile);
            setImportSuccess(result.message || 'Résultats importés avec succès');
            getRaceDetails(race.RAC_ID).then(setRace).catch(console.error);
        } catch (error: any) {
            console.error(error);
            setImportError(error.response?.data?.message || 'Erreur lors de l\'import');
        } finally {
            setImporting(false);
        }
    };

    if (loading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '60vh' }}>
                <CircularProgress color="warning" />
            </Box>
        );
    }

    const handleDeleteClick = () => {
        setDeleteDialogOpen(true);
    };

    const handleDeleteConfirm = async () => {
        try {
            await deleteRace(parseInt(id || '0'));
            showAlert("Course supprimée avec succès !", "success");
            navigate(`/raids/${race?.raid.RAI_ID}`);
        } catch (error: any) {
            console.error('Error deleting race:', error);
            showAlert("Erreur lors de la suppression de la course", "error");
        }
        setDeleteDialogOpen(false);
    };

    const handleValidateTeam = async (e: React.MouseEvent, teamId: number) => {
        e.stopPropagation();
        if (!race) return;
        try {
            await validateTeamForRace(teamId, race.RAC_ID);
            const updatedRace = await getRaceDetails(race.RAC_ID);
            setRace(updatedRace);
        } catch (err) {
            console.error(err);
            alert("Erreur lors de la validation");
        }
    };

    const handleUnvalidateTeam = async (e: React.MouseEvent, teamId: number) => {
        e.stopPropagation();
        if (!race) return;
        if (!confirm("Voulez-vous vraiment dévalider cette équipe ?")) return;
        try {
            await unvalidateTeamForRace(teamId, race.RAC_ID);
            const updatedRace = await getRaceDetails(race.RAC_ID);
            setRace(updatedRace);
        } catch (err) {
            console.error(err);
            alert("Erreur lors de la dévalidation");
        }
    };

    if (!race) {
        return <Typography>Course introuvable</Typography>;
    }

    const { stats, formatted_categories } = race;
    const isBelowMinParticipants = stats.participants_count < race.RAC_MIN_PARTICIPANTS;

    const isRaceManager = isAuthenticated && user && race && user.USE_ID === race.user.USE_ID;

    const renderTeamCard = (team: TeamDetail & { isResponsible?: boolean, isMember?: boolean }) => (
        <Card key={team.id} sx={{ p: 2, mb: 1, display: 'flex', alignItems: 'center', justifyContent: 'space-between', border: team.isResponsible ? '2px solid #ed6c02' : (team.isMember ? '2px solid #1976d2' : 'none') }}>
            <Box>
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                    <Typography fontWeight="bold">{team.name}</Typography>
                    {/* Validation Status */}
                    {team.is_valid ? (
                        <Tooltip title="Équipe validée par le responsable">
                            <CheckCircleIcon color="success" />
                        </Tooltip>
                    ) : (
                        <Tooltip title="Équipe en attente de validation">
                            <CancelIcon color="error" />
                        </Tooltip>
                    )}

                    {team.isResponsible && <Chip label="Responsable" size="small" color="warning" icon={<StarIcon />} />}
                    {team.isMember && !team.isResponsible && <Chip label="Membre" size="small" color="primary" />}
                </Box>
                <Typography variant="caption" color="text.secondary">
                    Resp: {team.responsible?.name || 'N/A'} • {team.members_count} / {race.RAC_MAX_TEAM_MEMBERS} membres
                </Typography>
            </Box>
            <Box sx={{ display: 'flex', gap: 1 }}>
                {isRaceManager && (
                    <>
                        {!team.is_valid ? (
                            <Tooltip title="Valider l'équipe">
                                <IconButton onClick={(e) => handleValidateTeam(e, team.id)} color="success">
                                    <RuleIcon />
                                </IconButton>
                            </Tooltip>
                        ) : (
                            <Tooltip title="Invalider l'équipe">
                                <IconButton onClick={(e) => handleUnvalidateTeam(e, team.id)} color="warning">
                                    <CancelIcon />
                                </IconButton>
                            </Tooltip>
                        )}
                    </>
                )}

                <Tooltip title={isAuthenticated ? "Voir les membres" : "Connectez-vous pour voir les détails"}>
                    <span>
                        <IconButton onClick={() => handleOpenTeamModal(team)} color="primary" disabled={!isAuthenticated}>
                            {isAuthenticated ? <GroupsIcon /> : <LockIcon />}
                        </IconButton>
                    </span>
                </Tooltip>
            </Box>
        </Card>
    );

    return (
        <Container maxWidth="md" sx={{ pb: 10 }}>
            {/* Header / Back */}
            <Box sx={{ py: 2, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <Button startIcon={<ArrowBackIcon />} onClick={() => navigate(`/raids/${race.raid?.RAI_ID}`)} sx={{ borderRadius: '8px' }}>
                    Retour au raid
                </Button>
                {user && (isAdmin || race.raid?.user.USE_ID === user.USE_ID) && !disableEditing && (
                    <Stack direction="row" spacing={1}>
                        <Button
                            variant="contained"
                            color="primary"
                            startIcon={<EditIcon />}
                            onClick={() => navigate(`/races/${id}/edit`)}
                            disabled={disableEditing}
                            sx={{ borderRadius: '8px' }}
                        >
                            Modifier la Course
                        </Button>
                        <Button
                            variant="contained"
                            color="error"
                            startIcon={<DeleteIcon />}
                            onClick={handleDeleteClick}
                            disabled={disableEditing}
                            sx={{ borderRadius: '8px' }}
                        >
                            Supprimer la Course
                        </Button>
                    </Stack>
                )}
            </Box>
            <Box sx={{ py: 2, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                <Stack direction="column" spacing={2}>
                    {race.has_results && <Button variant="contained" color="success" sx={{ borderRadius: 2 }} onClick={() => navigate(`/races/${race.RAC_ID}/results`)}>
                        voir les résultats
                    </Button>}
                    {getButton(race)}
                </Stack>
            </Box>
            {/* Title & Tags */}
            <Box sx={{ mb: 3 }}>
                <Box sx={{ display: 'flex', gap: 1, mb: 2, flexWrap: 'wrap' }}>
                    <Chip label={race.RAC_TYPE} color="success" size="small" />
                    <Chip label={race.RAC_DIFFICULTY} color="success" size="small" variant="outlined" />
                    <Chip label={race.user.USE_ID === user?.USE_ID ? "vous êtes l'organisateur" : race.user.USE_NAME + " " + race.user.USE_LAST_NAME + " organise cette course"} color="warning" size="small" variant="outlined" />
                    <Chip label={race.RAC_GENDER || 'Mixte'} color="info" size="small" />
                    <Chip
                        label={new Date() < new Date(race.RAC_TIME_START) ? 'En attente' : new Date() < new Date(race.RAC_TIME_END) ? 'En cours' : 'Terminée'}
                        color={new Date() < new Date(race.RAC_TIME_START) ? 'warning' : new Date() < new Date(race.RAC_TIME_END) ? 'success' : 'error'}
                        size="small"
                        sx={{ fontWeight: 600, fontSize: '0.7rem' }}
                    />
                </Box>
            </Box>

            {/* Stats Card */}
            <Card sx={{ bgcolor: '#198754', color: 'white', p: 3, borderRadius: 3, mb: 3 }}>
                <Box sx={{ display: 'flex', justifyContent: 'space-between', textAlign: 'center', mb: 2 }}>
                    <Box>
                        <GroupsIcon sx={{ fontSize: 30 }} />
                        <Typography variant="h5" fontWeight="bold">{stats.teams_count}</Typography>
                        <Typography variant="caption">Équipes inscrites</Typography>
                    </Box>
                    <Box>
                        <EventIcon sx={{ fontSize: 30 }} />
                        <Typography variant="h5" fontWeight="bold">{stats.places_remaining}</Typography>
                        <Typography variant="caption">Places rest (Pers)</Typography>
                    </Box>
                    <Box>
                        <Typography variant="h5" fontWeight="bold" sx={{ mt: 0.5 }}>{stats.filling_rate}%</Typography>
                        <Typography variant="caption">Remplissage</Typography>
                    </Box>
                </Box>
                <LinearProgress
                    variant="determinate"
                    value={stats.filling_rate}
                    sx={{ bgcolor: 'rgba(255,255,255,0.3)', '& .MuiLinearProgress-bar': { bgcolor: 'white' }, height: 8, borderRadius: 4 }}
                />
            </Card>

            {/* Dates */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <Typography variant="h6" color="warning.main" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                    <EventIcon /> Dates
                </Typography>
                <Box sx={{ display: 'flex', justifyContent: 'space-between', py: 1, borderBottom: '1px solid #eee' }}>
                    <Typography>Début</Typography>
                    <Typography fontWeight="bold">{formatDateWithHour(race.RAC_TIME_START)}</Typography>
                </Box>
                <Box sx={{ display: 'flex', justifyContent: 'space-between', py: 1 }}>
                    <Typography>Fin</Typography>
                    <Typography fontWeight="bold">{formatDateWithHour(race.RAC_TIME_END)}</Typography>
                </Box>
            </Paper>

            {/* Participants */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <Typography variant="h6" color="success.main" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                    <GroupsIcon /> Participants
                </Typography>

                {/* Expected Participants */}
                <Box sx={{ bgcolor: '#f8f9fa', p: 2, borderRadius: 2, mb: 2, display: 'flex', alignItems: 'center', gap: 2 }}>
                    <PersonIcon />
                    <Box>
                        <Typography variant="subtitle2">Participants attendus</Typography>
                        <Typography variant="h6">{stats.participants_expected_min} - {stats.participants_expected_max} personnes</Typography>
                    </Box>
                </Box>

                {/* Teams Registered */}
                <Box sx={{ bgcolor: isBelowMinParticipants ? '#ffebee' : '#f8f9fa', p: 2, borderRadius: 2, mb: 2 }}>
                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 2, mb: 1 }}>
                        {isBelowMinParticipants ? (
                            <Tooltip title="Attention: Le nombre de participants est inférieur au minimum requis. La course risque d'être annulée.">
                                <ReportProblemIcon color="error" />
                            </Tooltip>
                        ) : (
                            <GroupsIcon />
                        )}
                        <Box sx={{ flexGrow: 1 }}>
                            <Typography variant="subtitle2" color={isBelowMinParticipants ? 'error' : 'textPrimary'}>
                                Participants inscrits
                            </Typography>
                            <Typography variant="h6" color={isBelowMinParticipants ? 'error' : 'textPrimary'}>
                                {stats.participants_count} / {race.RAC_MAX_PARTICIPANTS} personnes
                            </Typography>
                            {isBelowMinParticipants && (
                                <Typography variant="caption" color="error">
                                    Minimum requis: {race.RAC_MIN_PARTICIPANTS} pers.
                                </Typography>
                            )}
                        </Box>
                    </Box>
                    <LinearProgress
                        variant="determinate"
                        value={stats.filling_rate}
                        color={isBelowMinParticipants ? "error" : "success"}
                        sx={{ height: 6, borderRadius: 3 }}
                    />
                </Box>

                {/* Members per team */}
                <Box sx={{ bgcolor: '#f8f9fa', p: 2, borderRadius: 2, display: 'flex', alignItems: 'center', gap: 2 }}>
                    <GroupsIcon />
                    <Box>
                        <Typography variant="subtitle2">Membres min et max par équipe</Typography>
                        <Typography variant="h6">{race.RAC_MIN_TEAM_MEMBERS+" - "+race.RAC_MAX_TEAM_MEMBERS} personnes</Typography>
                    </Box>
                </Box>
            </Paper>

            {/* Age Categories */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <Typography variant="h6" gutterBottom>Catégories d'âge</Typography>
                <Box sx={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 2 }}>
                    <Box sx={{ bgcolor: '#e3f2fd', p: 2, borderRadius: 2, textAlign: 'center', color: '#1976d2' }}>
                        <Typography variant="caption" display="block">Min</Typography>
                        <Typography variant="h6">{race.RAC_AGE_MIN} ans</Typography>
                    </Box>
                    <Box sx={{ bgcolor: '#fff3e0', p: 2, borderRadius: 2, textAlign: 'center', color: '#ed6c02' }}>
                        <Typography variant="caption" display="block">Moyen</Typography>
                        <Typography variant="h6">{race.RAC_AGE_MIDDLE} ans</Typography>
                    </Box>
                    <Box sx={{ bgcolor: '#ffebee', p: 2, borderRadius: 2, textAlign: 'center', color: '#d32f2f' }}>
                        <Typography variant="caption" display="block">Max</Typography>
                        <Typography variant="h6">{race.RAC_AGE_MAX} ans</Typography>
                    </Box>
                </Box>
            </Paper>

            {/* Tariffs */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <Typography variant="h6" color="info.main" gutterBottom>€ Tarifs</Typography>
                {formatted_categories.map((cat, index) => {
                    const colors = ['#e8f5e9', '#fff3e0', '#e3f2fd'];
                    const textColors = ['#2e7d32', '#ed6c02', '#1976d2'];
                    const bg = colors[index % colors.length];
                    const color = textColors[index % textColors.length];

                    return (
                        <Box key={cat.id} sx={{ display: 'flex', justifyContent: 'space-between', p: 2, bgcolor: bg, color: color, borderRadius: 2, mb: 1 }}>
                            <Typography fontWeight="bold">{cat.label}</Typography>
                            <Typography fontWeight="bold">{cat.price} €</Typography>
                        </Box>
                    );
                })}
            </Paper>

            {/* Teams List Toggle */}
            <Button
                variant="outlined"
                fullWidth
                sx={{ mb: 2, color: '#00c853', borderColor: '#00c853' }}
                onClick={() => setTeamsListOpen(!teamsListOpen)}
                endIcon={teamsListOpen ? <KeyboardArrowUpIcon /> : <KeyboardArrowDownIcon />}
            >
                VOIR LES ÉQUIPES ({stats.teams_count})
            </Button>

            <Collapse in={teamsListOpen}>
                <Paper sx={{ p: 2, mb: 3, borderRadius: 2, bgcolor: '#f8f9fa' }}>
                    <TextField
                        fullWidth
                        placeholder="Rechercher une équipe..."
                        variant="outlined"
                        size="small"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        InputProps={{
                            startAdornment: (
                                <InputAdornment position="start">
                                    <SearchIcon color="action" />
                                </InputAdornment>
                            ),
                        }}
                        sx={{ mb: 2, bgcolor: 'white' }}
                    />

                    <Box sx={{ maxHeight: 300, overflowY: 'auto' }}>
                        {myTeams.length > 0 && (
                            <Box sx={{ mb: 2 }}>
                                <Typography variant="subtitle2" color="primary" sx={{ mb: 1, display: 'flex', alignItems: 'center', gap: 1 }}>
                                    <StarIcon fontSize="small" /> MON ÉQUIPE
                                </Typography>
                                {myTeams.map(renderTeamCard)}
                                <Box sx={{ my: 1, borderBottom: '1px dashed #ccc' }} />
                            </Box>
                        )}

                        {otherTeams.length > 0 ? (
                            otherTeams.map(renderTeamCard)
                        ) : (
                            myTeams.length === 0 && (
                                <Typography variant="body2" color="text.secondary" textAlign="center">
                                    Aucune équipe trouvée
                                </Typography>
                            )
                        )}
                    </Box>
                </Paper>
            </Collapse>

            {isAuthenticated ? (
                myTeams.length > 0 ? (
                    <Tooltip title="Vous êtes déjà membre ou responsable d'une équipe pour cette course.">
                        <span>
                            <Button
                                variant="contained"
                                fullWidth
                                size="large"
                                disabled
                                startIcon={<GroupsIcon />}
                                sx={{ bgcolor: '#9e9e9e', '&:hover': { bgcolor: '#9e9e9e' } }}
                            >
                                DÉJÀ INSCRIT EN ÉQUIPE
                            </Button>
                        </span>
                    </Tooltip>
                ) : (
                    <Button
                        variant="contained"
                        fullWidth
                        size="large"
                        startIcon={<CheckCircleIcon />}
                        onClick={() => navigate(`/races/${race.RAC_ID}/register`)}
                        sx={{ bgcolor: '#00c853', '&:hover': { bgcolor: '#00a844' } }}
                    >
                        S'INSCRIRE EN ÉQUIPE
                    </Button>
                )
            ) : (
                <Tooltip title="Vous devez être connecté pour vous inscrire à une course.">
                    <span>
                        <Button
                            variant="contained"
                            fullWidth
                            size="large"
                            disabled
                            startIcon={<LockIcon />}
                            sx={{ bgcolor: '#9e9e9e', '&:hover': { bgcolor: '#9e9e9e' } }}
                        >
                            S'INSCRIRE EN ÉQUIPE (Connexion requise)
                        </Button>
                    </span>
                </Tooltip>
            )}

            {/* Team Members Modal */}
            <Dialog open={modalOpen} onClose={handleCloseModal} fullWidth maxWidth="sm">
                <DialogTitle sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    {selectedTeam?.name}
                    <IconButton onClick={handleCloseModal}>
                        <CloseIcon />
                    </IconButton>
                </DialogTitle>
                <DialogContent dividers>
                    <List>
                        {selectedTeam?.members.map((member) => (
                            <ListItem key={member.id}>
                                <ListItemAvatar>
                                    <Avatar sx={{ bgcolor: '#198754' }}>
                                        {member.name.charAt(0)}
                                    </Avatar>
                                </ListItemAvatar>
                                <ListItemText
                                    primary={member.name}
                                    secondary={member.email}
                                />
                            </ListItem>
                        ))}
                    </List>
                </DialogContent>
                {/* Allow Team Owner OR Race Manager to manage team */}
                {selectedTeam && user && (selectedTeam.responsible?.id === user.USE_ID || isRaceManager) && (
                    <DialogActions>
                        <Button
                            variant="contained"
                            color="primary"
                            fullWidth
                            onClick={() => navigate(`/teams/${selectedTeam.id}/races/${race?.RAC_ID}/manage`)}
                        >
                            {isRaceManager ? "Gérer l'équipe (Admin)" : "Gérer l'équipe"}
                        </Button>
                    </DialogActions>
                )}
            </Dialog>

            {/* Results Import Modal */}
            <Dialog open={resultsModalOpen} onClose={handleCloseResultsModal} fullWidth maxWidth="sm">
                <DialogTitle sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                    Importer les résultats
                    <IconButton onClick={handleCloseResultsModal}>
                        <CloseIcon />
                    </IconButton>
                </DialogTitle>
                <DialogContent dividers>
                    <Box sx={{ display: 'flex', flexDirection: 'column', gap: 2, alignItems: 'center', py: 2 }}>
                        <Typography variant="body2" color="text.secondary" textAlign="center">
                            Sélectionnez un fichier CSV contenant les colonnes suivantes :<br />
                            <strong>CLT</strong>, <strong>équipe</strong> (ou equipe), <strong>pts bonus</strong>, <strong>temps</strong>
                        </Typography>

                        <Button
                            component="label"
                            variant="outlined"
                            startIcon={<CloudUploadIcon />}
                            sx={{ mt: 1 }}
                        >
                            {resultFile ? resultFile.name : "Choisir un fichier"}
                            <input
                                type="file"
                                hidden
                                accept=".csv,.txt"
                                onChange={(e) => setResultFile(e.target.files ? e.target.files[0] : null)}
                            />
                        </Button>

                        {importError && (
                            <Typography color="error" variant="body2" sx={{ mt: 1 }}>
                                {importError}
                            </Typography>
                        )}
                        {importSuccess && (
                            <Typography color="success.main" variant="body2" sx={{ mt: 1 }}>
                                {importSuccess}
                            </Typography>
                        )}

                        <Box sx={{ display: 'flex', gap: 2, mt: 2, width: '100%' }}>
                            <Button onClick={handleCloseResultsModal} fullWidth color="inherit">
                                Annuler
                            </Button>
                            <Button
                                onClick={handleImportResults}
                                fullWidth
                                variant="contained"
                                color="primary"
                                disabled={!resultFile || importing}
                            >
                                {importing ? "Importation..." : "Importer"}
                            </Button>
                        </Box>
                    </Box>
                </DialogContent>
            </Dialog>

            {/* Delete Results Confirmation Modal */}
            <Dialog open={deleteModalOpen} onClose={() => setDeleteModalOpen(false)}>
                <DialogTitle>Confirmer la suppression</DialogTitle>
                <DialogContent>
                    <Typography>
                        Êtes-vous sûr de vouloir supprimer tous les résultats de cette course ? Cette action est irréversible.
                    </Typography>
                    <Box sx={{ display: 'flex', gap: 2, mt: 2, justifyContent: 'flex-end' }}>
                        <Button onClick={() => setDeleteModalOpen(false)} color="inherit">
                            Annuler
                        </Button>
                        <Button onClick={handleDeleteResults} variant="contained" color="error" startIcon={<DeleteIcon />}>
                            Supprimer
                        </Button>
                    </Box>
                </DialogContent>
            </Dialog>

            {/* Delete Confirmation Dialog */}
            <Dialog open={deleteDialogOpen} onClose={() => setDeleteDialogOpen(false)}>
                <DialogTitle sx={{ fontWeight: 'bold' }}>Confirmer la suppression</DialogTitle>
                <DialogContent>
                    <Typography>
                        Êtes-vous sûr de vouloir supprimer cette course ? Cette action est irréversible.
                    </Typography>
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setDeleteDialogOpen(false)} color="primary">
                        Annuler
                    </Button>
                    <Button onClick={handleDeleteConfirm} color="error" variant="contained">
                        Supprimer
                    </Button>
                </DialogActions>
            </Dialog>
        </Container>
    );
}