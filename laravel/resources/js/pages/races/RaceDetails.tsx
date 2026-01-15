import { useEffect, useState, useMemo } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaceDetails } from '../../api/race';
import type { RaceDetail, TeamDetail } from '../../models/race.model';
import {
    Container, Box, Typography, Button, LinearProgress, Card, Chip, Paper,
    TextField, Dialog, DialogTitle, DialogContent, List, ListItem, ListItemText, ListItemAvatar, Avatar, IconButton, InputAdornment, Collapse,
    Tooltip
} from '@mui/material';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import GroupsIcon from '@mui/icons-material/Groups';
import EventIcon from '@mui/icons-material/Event';
import PersonIcon from '@mui/icons-material/Person';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import SearchIcon from '@mui/icons-material/Search';
import CloseIcon from '@mui/icons-material/Close';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import KeyboardArrowUpIcon from '@mui/icons-material/KeyboardArrowUp';
import ReportProblemIcon from '@mui/icons-material/ReportProblem';
import { useUser } from '../../contexts/userContext';
import LockIcon from '@mui/icons-material/Lock';
import StarIcon from '@mui/icons-material/Star';

export default function RaceDetails() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const { user, isAuthenticated } = useUser();
    const [race, setRace] = useState<RaceDetail | null>(null);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedTeam, setSelectedTeam] = useState<TeamDetail | null>(null);
    const [modalOpen, setModalOpen] = useState(false);
    const [teamsListOpen, setTeamsListOpen] = useState(false);

    useEffect(() => {
        if (id) {
            getRaceDetails(parseInt(id)).then(setRace).catch(console.error);
        }
    }, [id]);

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

    const handleOpenTeamModal = (team: TeamDetail) => {
        if (!isAuthenticated) return;
        setSelectedTeam(team);
        setModalOpen(true);
    };

    const handleCloseModal = () => {
        setModalOpen(false);
        setSelectedTeam(null);
    };

    if (!race) {
        return <Typography>Chargement...</Typography>;
    }

    const { stats, formatted_categories } = race;
    const isBelowMinParticipants = stats.participants_count < race.RAC_MIN_PARTICIPANTS;

    const renderTeamCard = (team: TeamDetail & { isResponsible?: boolean, isMember?: boolean }) => (
        <Card key={team.id} sx={{ p: 2, mb: 1, display: 'flex', alignItems: 'center', justifyContent: 'space-between', border: team.isResponsible ? '2px solid #ed6c02' : (team.isMember ? '2px solid #1976d2' : 'none') }}>
            <Box>
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                    <Typography fontWeight="bold">{team.name}</Typography>
                    {team.isResponsible && <Chip label="Responsable" size="small" color="warning" icon={<StarIcon />} />}
                    {team.isMember && !team.isResponsible && <Chip label="Membre" size="small" color="primary" />}
                </Box>
                <Typography variant="caption" color="text.secondary">
                    Resp: {team.responsible?.name || 'N/A'} • {team.members_count} / {race.RAC_MAX_TEAM_MEMBERS} membres
                </Typography>
            </Box>
            <Tooltip title={isAuthenticated ? "Voir les membres" : "Connectez-vous pour voir les détails"}>
                <span>
                    <IconButton onClick={() => handleOpenTeamModal(team)} color="primary" disabled={!isAuthenticated}>
                        {isAuthenticated ? <GroupsIcon /> : <LockIcon />}
                    </IconButton>
                </span>
            </Tooltip>
        </Card>
    );

    return (
        <Container maxWidth="md" sx={{ pb: 10 }}>
            {/* Header / Back */}
            <Box sx={{ py: 2, display: 'flex', alignItems: 'center' }}>
                <Button startIcon={<ArrowBackIcon />} onClick={() => navigate(`/raids/${race.RAI_ID}`)}>
                    Retour au raid
                </Button>
            </Box>

            {/* Title & Tags */}
            <Box sx={{ mb: 3 }}>
                <Box sx={{ display: 'flex', gap: 1, mb: 2 }}>
                    <Chip label={race.RAC_TYPE} color="success" size="small" />
                    <Chip label={race.RAC_DIFFICULTY} color="success" size="small" variant="outlined" />
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
                    <Typography fontWeight="bold">{new Date(race.RAC_TIME_START).toLocaleString('fr-FR')}</Typography>
                </Box>
                <Box sx={{ display: 'flex', justifyContent: 'space-between', py: 1 }}>
                    <Typography>Fin</Typography>
                    <Typography fontWeight="bold">{new Date(race.RAC_TIME_END).toLocaleString('fr-FR')}</Typography>
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
                        <Typography variant="subtitle2">Membres max par équipe</Typography>
                        <Typography variant="h6">{race.RAC_MAX_TEAM_MEMBERS} personnes</Typography>
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

            <Button
                variant="contained"
                fullWidth
                size="large"
                startIcon={<CheckCircleIcon />}
                sx={{ bgcolor: '#00c853', '&:hover': { bgcolor: '#00a844' } }}
            >
                S'INSCRIRE EN ÉQUIPE
            </Button>

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
            </Dialog>
        </Container>
    );
}
