import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import {
    Container, Box, Typography, Button,
    IconButton, Chip, TextField, Alert, CircularProgress,
    Dialog, DialogTitle, DialogContent, DialogActions,
    Card, CardContent, Divider, Avatar, Autocomplete
} from '@mui/material';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import PersonRemoveIcon from '@mui/icons-material/PersonRemove';
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import SaveIcon from '@mui/icons-material/Save';
import EditIcon from '@mui/icons-material/Edit';
import CreditCardIcon from '@mui/icons-material/CreditCard'; // For License
import SensorsIcon from '@mui/icons-material/Sensors'; // For Chip
import CancelIcon from '@mui/icons-material/Cancel';
import UndoIcon from '@mui/icons-material/Undo';
import {
    getTeamRaceDetailsApi,
    removeMemberFromTeamRace,
    updateMemberRaceInfo,
    validateTeamForRace,
    unvalidateTeamForRace,
    getAvailableUsersForRace,
    addMemberToTeam
} from '../../api/team';
import type { TeamRaceDetails, TeamRaceMember } from '../../models/team-management.model';
import type { AvailableUser } from '../../models/team.model';

export default function TeamRaceManagement() {
    const { teamId, raceId } = useParams<{ teamId: string, raceId: string }>();
    const navigate = useNavigate();

    const [details, setDetails] = useState<TeamRaceDetails | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);
    const [successMessage, setSuccessMessage] = useState<string | null>(null);

    // Edit state
    const [editingMember, setEditingMember] = useState<TeamRaceMember | null>(null);
    const [editChip, setEditChip] = useState('');
    const [editPPS, setEditPPS] = useState('');
    const [saving, setSaving] = useState(false);

    // Add Member state
    const [addMemberOpen, setAddMemberOpen] = useState(false);
    const [availableUsers, setAvailableUsers] = useState<AvailableUser[]>([]);
    const [selectedUserToAdd, setSelectedUserToAdd] = useState<AvailableUser | null>(null);
    const [loadingUsers, setLoadingUsers] = useState(false);

    const fetchData = () => {
        if (teamId && raceId) {
            setLoading(true);
            getTeamRaceDetailsApi(parseInt(teamId), parseInt(raceId))
                .then(data => {
                    setDetails(data);
                    setError(null);
                })
                .catch(err => setError(err.message || 'Erreur lors du chargement'))
                .finally(() => setLoading(false));
        }
    };

    const fetchAvailableUsers = () => {
        if (raceId) {
            setLoadingUsers(true);
            getAvailableUsersForRace(parseInt(raceId))
                .then(data => {
                    setAvailableUsers(data);
                })
                .catch(console.error)
                .finally(() => setLoadingUsers(false));
        }
    };

    useEffect(() => {
        fetchData();
    }, [teamId, raceId]);

    useEffect(() => {
        if (addMemberOpen) {
            fetchAvailableUsers();
        }
    }, [addMemberOpen]);

    const handleRemoveMember = async (memberUserId: number) => {
        if (!window.confirm('Êtes-vous sûr de vouloir retirer ce membre ?')) return;

        try {
            await removeMemberFromTeamRace(parseInt(teamId!), parseInt(raceId!), memberUserId);
            fetchData();
            setSuccessMessage('Membre retiré avec succès');
        } catch (err: any) {
            setError(err.message || 'Erreur lors de la suppression');
        }
    };

    const handleOpenEdit = (member: TeamRaceMember) => {
        setEditingMember(member);
        setEditChip(member.USR_CHIP_NUMBER || '');
        setEditPPS(member.USR_PPS_FORM || '');
    };

    const handleSaveMemberInfo = async () => {
        if (!editingMember) return;

        setSaving(true);
        try {
            await updateMemberRaceInfo(
                parseInt(teamId!),
                parseInt(raceId!),
                editingMember.USE_ID,
                editChip,
                editPPS
            );
            setEditingMember(null);
            fetchData();
            setSuccessMessage('Informations mises à jour');
        } catch (err: any) {
            setError(err.message || 'Erreur lors de la mise à jour');
        } finally {
            setSaving(false);
        }
    };

    const handleValidateTeam = async () => {
        if (!window.confirm('Voulez-vous valider définitivement l\'équipe pour cette course ?')) return;

        try {
            await validateTeamForRace(parseInt(teamId!), parseInt(raceId!));
            fetchData();
            setSuccessMessage('Équipe validée avec succès !');
        } catch (err: any) {
            setError(err.message || 'Erreur lors de la validation');
        }
    };

    const handleUnvalidateTeam = async () => {
        if (!window.confirm('Voulez-vous dévalider l\'équipe (remettre en édition) ?')) return;

        try {
            await unvalidateTeamForRace(parseInt(teamId!), parseInt(raceId!));
            fetchData();
            setSuccessMessage('Équipe dévalidée.');
        } catch (err: any) {
            setError(err.message || 'Erreur lors de la dévalidation');
        }
    };

    const handleAddMember = async () => {
        if (!selectedUserToAdd) return;

        try {
            await addMemberToTeam({
                user_id: selectedUserToAdd.USE_ID,
                team_id: parseInt(teamId!),
                race_id: parseInt(raceId!)
            });
            setAddMemberOpen(false);
            setSelectedUserToAdd(null);
            fetchData();
            setSuccessMessage('Membre ajouté avec succès');
        } catch (err: any) {
            setError(err.message || 'Erreur lors de l\'ajout du membre');
        }
    };

    const isCompetitive = details?.race.type.toLowerCase().includes('compétition') || details?.race.type.toLowerCase().includes('competitif');

    const canValidate = details?.members.every(m => {
        const hasLicense = !!m.USE_LICENCE_NUMBER;
        const hasPPS = !!m.USR_PPS_FORM;
        const validDoc = hasLicense || hasPPS;

        const validChip = !isCompetitive || !!m.USR_CHIP_NUMBER;

        return validDoc && validChip;
    });

    if (loading) return <Container sx={{ py: 4, display: 'flex', justifyContent: 'center' }}><CircularProgress /></Container>;
    if (!details) return <Container sx={{ py: 4 }}><Alert severity="error">{error || 'Introuvable'}</Alert></Container>;

    const isValid = details.team.is_valid;

    return (
        <Box sx={{ minHeight: '100vh', bgcolor: '#f5f5f5', pb: 4 }}>
            {/* Header Section - Dark Green Background */}
            <Box sx={{ bgcolor: '#1b4b36', color: 'white', pt: 2, pb: 4, px: 2 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 2 }}>
                    <IconButton onClick={() => navigate(`/races/${raceId}`)} sx={{ color: 'white' }}>
                        <ArrowBackIcon />
                    </IconButton>
                    <Typography variant="h6" fontWeight="bold">
                        {details.team.name}
                    </Typography>
                    {/* Placeholder for Delete Team or other actions */}
                    <Box sx={{ width: 40 }} />
                </Box>

                <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 2 }}>
                    <Avatar
                        sx={{
                            width: 80, height: 80,
                            bgcolor: '#8fce00',
                            fontSize: '2rem',
                            color: '#1b4b36',
                            fontWeight: 'bold'
                        }}
                    >
                        {details.team.name.charAt(0).toUpperCase()}
                    </Avatar>

                    <Typography variant="h5" fontWeight="bold">
                        {details.team.name}
                    </Typography>

                    <Chip
                        icon={<CheckCircleIcon sx={{ color: '#1b4b36 !important' }} />}
                        label={`Dossard n°${details.team.race_number || '...'}`}
                        sx={{
                            bgcolor: 'white',
                            color: '#1b4b36',
                            fontWeight: 'bold',
                            fontSize: '1rem',
                            py: 2
                        }}
                    />

                    <Chip
                        label={isValid ? "C'est tout bon !" : "En attente de validation"}
                        sx={{
                            bgcolor: isValid ? '#8fce00' : '#ff9800',
                            color: isValid ? '#1b4b36' : 'white',
                            fontWeight: 'bold',
                        }}
                    />
                </Box>
            </Box>

            <Container maxWidth="sm" sx={{ mt: -2 }}>
                {/* Validation / Action Buttons */}
                {!isValid ? (
                    <Button
                        variant="contained"
                        fullWidth
                        onClick={handleValidateTeam}
                        disabled={!canValidate}
                        sx={{
                            bgcolor: '#00c896', // Bright green from mockup
                            '&:hover': { bgcolor: '#00a87e' },
                            py: 1.5,
                            fontWeight: 'bold',
                            mb: 3,
                            boxShadow: '0 4px 10px rgba(0,0,0,0.1)'
                        }}
                        startIcon={<CheckCircleIcon />}
                    >
                        VALIDER L'ÉQUIPE
                    </Button>
                ) : (
                    <Button
                        variant="outlined"
                        fullWidth
                        onClick={handleUnvalidateTeam}
                        color="warning"
                        sx={{
                            py: 1.5,
                            fontWeight: 'bold',
                            mb: 3,
                            bgcolor: 'white'
                        }}
                        startIcon={<UndoIcon />}
                    >
                        DÉVALIDER (MODIFIER)
                    </Button>
                )}

                {successMessage && <Alert severity="success" sx={{ mb: 2 }} onClose={() => setSuccessMessage(null)}>{successMessage}</Alert>}
                {error && <Alert severity="error" sx={{ mb: 2 }} onClose={() => setError(null)}>{error}</Alert>}

                {!canValidate && !isValid && (
                    <Alert severity="warning" sx={{ mb: 2 }}>
                        Complétez les infos manquantes pour valider.
                    </Alert>
                )}

                <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 2 }}>
                    <Typography variant="h6" sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                        <Box component="span" sx={{ fontSize: '1.2rem' }}>👥</Box> Membres ({details.members.length})
                    </Typography>
                    {!isValid && (
                        <Button
                            startIcon={<PersonAddIcon />}
                            size="small"
                            variant="outlined"
                            onClick={() => setAddMemberOpen(true)}
                        >
                            Ajouter
                        </Button>
                    )}
                </Box>

                {/* Member Cards */}
                <Box sx={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                    {details.members.map(member => {
                        const hasLicense = !!member.USE_LICENCE_NUMBER;
                        const hasPPS = !!member.USR_PPS_FORM;
                        const hasChip = !!member.USR_CHIP_NUMBER;

                        return (
                            <Card key={member.USE_ID} sx={{ borderRadius: 3, boxShadow: '0 2px 8px rgba(0,0,0,0.05)' }}>
                                <CardContent>
                                    {/* Header Row: Avatar + Name + Delete */}
                                    <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 2 }}>
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
                                            <Avatar sx={{ bgcolor: '#00c896', fontWeight: 'bold' }}>{member.USE_NAME.charAt(0)}</Avatar>
                                            <Box>
                                                <Typography fontWeight="bold">{member.USE_NAME} {member.USE_LAST_NAME}</Typography>
                                                <Typography variant="body2" color="text.secondary">{member.USE_MAIL}</Typography>
                                            </Box>
                                        </Box>
                                        {!isValid && (
                                            <IconButton onClick={() => handleRemoveMember(member.USE_ID)}>
                                                <PersonRemoveIcon color="error" />
                                            </IconButton>
                                        )}
                                    </Box>

                                    <Divider sx={{ mb: 2 }} />

                                    {/* Info Rows */}
                                    {/* Licence / PPS */}
                                    <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', mb: 1.5 }}>
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                                            <CreditCardIcon fontSize="small" />
                                            <Typography variant="body2">
                                                {hasLicense ? "N° Licence" : "PPS"}
                                            </Typography>
                                        </Box>
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                            <Typography variant="body2" fontWeight="medium">
                                                {hasLicense ? member.USE_LICENCE_NUMBER : (hasPPS ? "Document chargé" : "Non renseigné")}
                                            </Typography>
                                            {/* Status Icon */}
                                            {hasLicense || hasPPS ? <CheckCircleIcon color="success" fontSize="small" /> : <CancelIcon color="error" fontSize="small" />}
                                        </Box>
                                    </Box>

                                    {/* Chip */}
                                    <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1, color: 'text.secondary' }}>
                                            <SensorsIcon fontSize="small" />
                                            <Typography variant="body2">N° de puce</Typography>
                                        </Box>

                                        <Box
                                            sx={{ display: 'flex', alignItems: 'center', gap: 1, cursor: !isValid ? 'pointer' : 'default' }}
                                            onClick={() => !isValid && handleOpenEdit(member)}
                                        >
                                            <Typography variant="body2" fontWeight="medium" color={!hasChip && isCompetitive ? 'error.main' : 'text.primary'}>
                                                {member.USR_CHIP_NUMBER || 'Non attribué'}
                                            </Typography>
                                        </Box>
                                    </Box>

                                    {!isValid && (
                                        <Button
                                            variant="outlined"
                                            fullWidth
                                            size="small"
                                            sx={{ mt: 2 }}
                                            startIcon={<EditIcon />}
                                            onClick={() => handleOpenEdit(member)}
                                        >
                                            Modifier Info
                                        </Button>
                                    )}

                                </CardContent>
                            </Card>
                        );
                    })}
                </Box>

            </Container>

            {/* Edit Modal */}
            <Dialog open={!!editingMember} onClose={() => setEditingMember(null)} fullWidth maxWidth="xs">
                <DialogTitle>Modifier les informations</DialogTitle>
                <DialogContent sx={{ pt: 2 }}>
                    {editingMember && (
                        <Box sx={{ display: 'flex', flexDirection: 'column', gap: 2, mt: 1 }}>
                            <Typography variant="subtitle2">
                                {editingMember.USE_NAME} {editingMember.USE_LAST_NAME}
                            </Typography>

                            <TextField
                                label="Numéro de puce"
                                fullWidth
                                value={editChip}
                                onChange={(e) => setEditChip(e.target.value)}
                                helperText={isCompetitive ? "Obligatoire (Course Compétitive)" : "Optionnel"}
                            />

                            {!editingMember.USE_LICENCE_NUMBER && (
                                <TextField
                                    label="Lien/Statut PPS"
                                    fullWidth
                                    value={editPPS}
                                    onChange={(e) => setEditPPS(e.target.value)}
                                    helperText="Renseignez le lien ou statut du PPS"
                                />
                            )}

                            {editingMember.USE_LICENCE_NUMBER && (
                                <Alert severity="info">
                                    Licence renseignée : {editingMember.USE_LICENCE_NUMBER} <br />
                                    (Le PPS n'est pas requis)
                                </Alert>
                            )}
                        </Box>
                    )}
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setEditingMember(null)}>Annuler</Button>
                    <Button
                        onClick={handleSaveMemberInfo}
                        variant="contained"
                        disabled={saving}
                        startIcon={saving ? <CircularProgress size={20} /> : <SaveIcon />}
                    >
                        Enregistrer
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Add Member Modal */}
            <Dialog open={addMemberOpen} onClose={() => setAddMemberOpen(false)} fullWidth maxWidth="sm">
                <DialogTitle>Ajouter un membre</DialogTitle>
                <DialogContent sx={{ pt: 2, minHeight: 300 }}>
                    <Typography gutterBottom>
                        Recherchez un utilisateur à ajouter à votre équipe. Seuls les utilisateurs disponibles (pas de course en même temps) apparaissent.
                    </Typography>

                    <Autocomplete
                        options={availableUsers}
                        getOptionLabel={(option) => `${option.USE_NAME} ${option.USE_LAST_NAME} (${option.USE_MAIL})`}
                        loading={loadingUsers}
                        value={selectedUserToAdd}
                        onChange={(_, newValue) => setSelectedUserToAdd(newValue)}
                        renderInput={(params) => (
                            <TextField
                                {...params}
                                label="Rechercher un membre"
                                variant="outlined"
                                InputProps={{
                                    ...params.InputProps,
                                    endAdornment: (
                                        <>
                                            {loadingUsers ? <CircularProgress color="inherit" size={20} /> : null}
                                            {params.InputProps.endAdornment}
                                        </>
                                    ),
                                }}
                            />
                        )}
                        renderOption={(props, option) => {
                            // Use 'div' or 'li' directly to avoid type issues if 'props' contains detailed HTML attributes
                            const { key, ...otherProps } = props as any;
                            return (
                                <Box component="li" key={key} {...otherProps}>
                                    <Box>
                                        <Typography variant="body1">
                                            {option.USE_NAME} {option.USE_LAST_NAME}
                                        </Typography>
                                        <Typography variant="caption" color="text.secondary">
                                            {option.USE_MAIL}
                                        </Typography>
                                    </Box>
                                </Box>
                            );
                        }}
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setAddMemberOpen(false)}>Annuler</Button>
                    <Button
                        onClick={handleAddMember}
                        variant="contained"
                        disabled={!selectedUserToAdd}
                    >
                        Ajouter
                    </Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
}
