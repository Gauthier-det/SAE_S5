import { useEffect, useState, useMemo } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaceDetails } from '../../api/race';
import { createTeam, addMemberToTeam, getAvailableUsersForRace, registerTeamToRace } from '../../api/team';
import type { RaceDetail } from '../../models/race.model';
import type { AvailableUser } from '../../models/team.model';
import {
    Container, Box, Typography, Button, Paper, TextField,
    List, ListItem, ListItemText, ListItemAvatar, Avatar, IconButton,
    InputAdornment, Alert, Chip, CircularProgress, Autocomplete
} from '@mui/material';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import DirectionsRunIcon from '@mui/icons-material/DirectionsRun';
import InfoOutlinedIcon from '@mui/icons-material/InfoOutlined';
import GroupsIcon from '@mui/icons-material/Groups';
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import DeleteIcon from '@mui/icons-material/Delete';

export default function TeamRegistration() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();

    const [race, setRace] = useState<RaceDetail | null>(null);
    const [loading, setLoading] = useState(true);
    const [submitting, setSubmitting] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState(false);

    // Form state
    const [teamName, setTeamName] = useState('');
    const [teamImage, setTeamImage] = useState('');
    const [selectedMembers, setSelectedMembers] = useState<AvailableUser[]>([]);
    const [availableUsers, setAvailableUsers] = useState<AvailableUser[]>([]);
    const [searchValue, setSearchValue] = useState('');

    useEffect(() => {
        if (id) {
            Promise.all([
                getRaceDetails(parseInt(id)),
                getAvailableUsersForRace(parseInt(id))
            ])
                .then(([raceData, users]) => {
                    setRace(raceData);
                    setAvailableUsers(users);
                })
                .catch(console.error)
                .finally(() => setLoading(false));
        }
    }, [id]);

    const filteredUsers = useMemo(() => {
        const selectedIds = selectedMembers.map(m => m.USE_ID);
        return availableUsers.filter(u =>
            !selectedIds.includes(u.USE_ID) &&
            (u.USE_NAME.toLowerCase().includes(searchValue.toLowerCase()) ||
                u.USE_LAST_NAME.toLowerCase().includes(searchValue.toLowerCase()) ||
                u.USE_MAIL.toLowerCase().includes(searchValue.toLowerCase()))
        );
    }, [availableUsers, selectedMembers, searchValue]);

    const handleAddMember = (user: AvailableUser | null) => {
        if (user && user.is_available && race && selectedMembers.length < race.RAC_MAX_TEAM_MEMBERS) {
            setSelectedMembers(prev => [...prev, user]);
            setSearchValue('');
        }
    };

    const handleRemoveMember = (userId: number) => {
        setSelectedMembers(prev => prev.filter(m => m.USE_ID !== userId));
    };

    const handleSubmit = async () => {
        if (!race || !id || !teamName.trim()) {
            setError('Veuillez remplir tous les champs obligatoires');
            return;
        }

        if (selectedMembers.length === 0) {
            setError('Veuillez ajouter au moins un membre à l\'équipe');
            return;
        }

        setSubmitting(true);
        setError(null);

        try {
            // 1. Create the team
            const teamId = await createTeam({
                name: teamName.trim(),
                image: teamImage.trim() || undefined
            });

            // 2. Add each member to the team (this also adds them to SAN_USERS_RACES)
            for (const member of selectedMembers) {
                await addMemberToTeam({
                    user_id: member.USE_ID,
                    team_id: teamId,
                    race_id: parseInt(id)
                });
            }

            // 3. Register the team to the race
            await registerTeamToRace(teamId, parseInt(id));

            setSuccess(true);
            setTimeout(() => {
                navigate(`/races/${id}`);
            }, 2000);
        } catch (err: any) {
            setError(err.message || 'Une erreur est survenue lors de l\'inscription');
        } finally {
            setSubmitting(false);
        }
    };

    if (loading) {
        return (
            <Container maxWidth="sm" sx={{ py: 4, display: 'flex', justifyContent: 'center' }}>
                <CircularProgress color="success" />
            </Container>
        );
    }

    if (!race) {
        return (
            <Container maxWidth="sm" sx={{ py: 4 }}>
                <Typography>Course non trouvée</Typography>
            </Container>
        );
    }

    return (
        <Container maxWidth="sm" sx={{ pb: 10 }}>
            {/* Header */}
            <Box sx={{ py: 2, display: 'flex', alignItems: 'center' }}>
                <IconButton onClick={() => navigate(`/races/${id}`)} sx={{ mr: 1 }}>
                    <ArrowBackIcon />
                </IconButton>
                <Typography variant="h6" fontWeight="bold">
                    Inscription en équipe
                </Typography>
            </Box>

            {/* Race Info Card */}
            <Paper
                sx={{
                    p: 2,
                    mb: 2,
                    borderRadius: 3,
                    border: '2px solid #198754',
                    bgcolor: 'rgba(25, 135, 84, 0.05)'
                }}
            >
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
                    <DirectionsRunIcon sx={{ color: '#198754', fontSize: 40 }} />
                    <Box>
                        <Typography variant="caption" color="text.secondary">
                            Inscription à la course
                        </Typography>
                        <Typography variant="h6" fontWeight="bold">
                            Course {race.RAC_TYPE} - {race.RAC_DIFFICULTY}
                        </Typography>
                    </Box>
                </Box>
            </Paper>

            {/* Info Box */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2, bgcolor: '#f8f9fa' }}>
                <Box sx={{ display: 'flex', alignItems: 'flex-start', gap: 1.5 }}>
                    <InfoOutlinedIcon sx={{ color: '#198754', mt: 0.5 }} />
                    <Box>
                        <Typography fontWeight="bold" gutterBottom>
                            Créez votre équipe pour vous inscrire
                        </Typography>
                        <Typography variant="body2" color="text.secondary" component="div">
                            <ul style={{ margin: 0, paddingLeft: 20 }}>
                                <li>Maximum {race.RAC_MAX_TEAM_MEMBERS} membres par équipe</li>
                                <li>Tous les membres doivent avoir au moins {race.RAC_AGE_MIN} ans</li>
                                <li>L'équipe sera soumise à validation</li>
                            </ul>
                        </Typography>
                    </Box>
                </Box>
            </Paper>

            {/* Success/Error Messages */}
            {error && (
                <Alert severity="error" sx={{ mb: 2 }} onClose={() => setError(null)}>
                    {error}
                </Alert>
            )}
            {success && (
                <Alert severity="success" sx={{ mb: 2 }}>
                    Équipe créée avec succès ! Redirection...
                </Alert>
            )}

            {/* Team Name Input */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
                    <GroupsIcon sx={{ color: 'text.secondary' }} />
                    <TextField
                        fullWidth
                        label="Nom de l'équipe *"
                        variant="standard"
                        value={teamName}
                        onChange={(e) => setTeamName(e.target.value)}
                        placeholder="Nom de l'équipe"
                        disabled={submitting || success}
                    />
                </Box>
            </Paper>

            {/* Team Image Input (optional) */}
            <Paper sx={{ p: 2, mb: 3, borderRadius: 2 }}>
                <TextField
                    fullWidth
                    label="URL de l'image de l'équipe (optionnel)"
                    variant="standard"
                    value={teamImage}
                    onChange={(e) => setTeamImage(e.target.value)}
                    placeholder="https://..."
                    disabled={submitting || success}
                />
            </Paper>

            {/* Members Section */}
            <Typography variant="subtitle1" fontWeight="bold" sx={{ mb: 1 }}>
                Membres de l'équipe *
            </Typography>

            {/* Member Search */}
            <Paper sx={{ p: 2, mb: 2, borderRadius: 2 }}>
                <Autocomplete
                    options={filteredUsers}
                    getOptionLabel={(option) => `${option.USE_NAME} ${option.USE_LAST_NAME}`}
                    getOptionDisabled={(option) => !option.is_available}
                    renderOption={(props, option) => (
                        <li {...props} key={option.USE_ID}>
                            <Box sx={{
                                display: 'flex',
                                flexDirection: 'column',
                                width: '100%',
                                opacity: option.is_available ? 1 : 0.5
                            }}>
                                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                    <Typography color={option.is_available ? 'text.primary' : 'text.disabled'}>
                                        {option.USE_NAME} {option.USE_LAST_NAME}
                                    </Typography>
                                    {option.is_self && (
                                        <Chip label="Moi-même" size="small" color="primary" />
                                    )}
                                    {option.already_in_team && (
                                        <Chip label="Déjà dans une équipe" size="small" color="error" variant="outlined" />
                                    )}
                                    {option.has_overlapping_race && !option.already_in_team && (
                                        <Chip label="Course en conflit" size="small" color="warning" variant="outlined" />
                                    )}
                                </Box>
                                <Typography variant="caption" color="text.secondary">
                                    {option.USE_MAIL}
                                </Typography>
                            </Box>
                        </li>
                    )}
                    onChange={(_, value) => handleAddMember(value)}
                    inputValue={searchValue}
                    onInputChange={(_, value) => setSearchValue(value)}
                    value={null}
                    disabled={submitting || success || selectedMembers.length >= race.RAC_MAX_TEAM_MEMBERS}
                    renderInput={(params) => (
                        <TextField
                            {...params}
                            variant="standard"
                            placeholder="Rechercher et ajouter un membre..."
                            InputProps={{
                                ...params.InputProps,
                                startAdornment: (
                                    <InputAdornment position="start">
                                        <PersonAddIcon color="action" />
                                    </InputAdornment>
                                ),
                            }}
                        />
                    )}
                />
                <Typography variant="caption" color="text.secondary" sx={{ mt: 1, display: 'block' }}>
                    Cliquez dans le champ et tapez pour rechercher
                </Typography>
            </Paper>

            {/* Selected Members List */}
            {selectedMembers.length > 0 && (
                <Paper sx={{ mb: 3, borderRadius: 2 }}>
                    <List>
                        {selectedMembers.map((member) => (
                            <ListItem
                                key={member.USE_ID}
                                secondaryAction={
                                    <IconButton
                                        edge="end"
                                        onClick={() => handleRemoveMember(member.USE_ID)}
                                        disabled={submitting || success}
                                    >
                                        <DeleteIcon color="error" />
                                    </IconButton>
                                }
                            >
                                <ListItemAvatar>
                                    <Avatar sx={{ bgcolor: '#198754' }}>
                                        {member.USE_NAME.charAt(0)}
                                    </Avatar>
                                </ListItemAvatar>
                                <ListItemText
                                    primary={
                                        <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                                            {member.USE_NAME} {member.USE_LAST_NAME}
                                            {member.is_self && (
                                                <Chip label="Moi-même" size="small" color="primary" />
                                            )}
                                        </Box>
                                    }
                                    secondary={member.USE_MAIL}
                                />
                            </ListItem>
                        ))}
                    </List>
                </Paper>
            )}

            {/* Member Count */}
            <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
                <Typography variant="body2" color="text.secondary">
                    Membres sélectionnés:
                </Typography>
                <Chip
                    label={`${selectedMembers.length} / ${race.RAC_MAX_TEAM_MEMBERS}`}
                    color={selectedMembers.length >= race.RAC_MAX_TEAM_MEMBERS ? "warning" : "default"}
                    size="small"
                />
            </Box>

            {/* Submit Button */}
            <Button
                variant="contained"
                fullWidth
                size="large"
                onClick={handleSubmit}
                disabled={submitting || success || !teamName.trim() || selectedMembers.length === 0}
                sx={{
                    bgcolor: '#198754',
                    '&:hover': { bgcolor: '#157347' },
                    py: 1.5,
                    borderRadius: 2,
                    fontWeight: 'bold'
                }}
            >
                {submitting ? (
                    <CircularProgress size={24} color="inherit" />
                ) : (
                    "CRÉER L'ÉQUIPE ET S'INSCRIRE"
                )}
            </Button>
        </Container>
    );
}
