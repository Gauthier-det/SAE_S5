import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getRaceDetails } from '../../api/race';
import type { RaceResultPage } from '../../models/race.model';
import {
    Container, Box, Typography, Button, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Chip, CircularProgress
} from '@mui/material';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import EmojiEventsIcon from '@mui/icons-material/EmojiEvents';

export default function RaceResults() {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const [raceResult, setRaceResult] = useState<RaceResultPage | null>(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (id) {
            setLoading(true);
            getRaceDetails(parseInt(id))
                .then(setRaceResult)
                .catch(console.error)
                .finally(() => setLoading(false));
        }
    }, [id]);

    if (loading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '60vh' }}>
                <CircularProgress color="warning" />
            </Box>
        );
    }

    if (!raceResult) {
        return <Typography>Course introuvable</Typography>;
    }

    // Sort teams by rank if available, otherwise by name
    const sortedTeams = [...raceResult.teams_list].sort((a, b) => {
        const rankA = a.result?.rank;
        const rankB = b.result?.rank;

        if (rankA && rankB) {
            return rankA - rankB;
        }
        if (rankA) return -1;
        if (rankB) return 1;
        return 0;
    });

    return (
        <Container maxWidth="lg" sx={{ pb: 10 }}>
            <Box sx={{ py: 2, display: 'flex', alignItems: 'center' }}>
                <Button startIcon={<ArrowBackIcon />} onClick={() => navigate(`/races/${raceResult.RAC_ID}`)}>
                    Retour à la course
                </Button>
            </Box>

            <Box sx={{ mb: 4, textAlign: 'center' }}>
                <Typography variant="h4" fontWeight="bold" gutterBottom>
                    Résultats: {raceResult.RAC_NAME}
                </Typography>
                <Chip icon={<EmojiEventsIcon />} label={raceResult.has_results ? "Classement officiel" : "En attente de résultats"} color={raceResult.has_results ? "success" : "default"} />
            </Box>

            {raceResult.has_results ? (
                <TableContainer component={Paper} sx={{ borderRadius: 2, boxShadow: 3 }}>
                    <Table>
                        <TableHead sx={{ bgcolor: '#f5f5f5' }}>
                            <TableRow>
                                <TableCell><strong>Rang</strong></TableCell>
                                <TableCell><strong>Équipe</strong></TableCell>
                                <TableCell><strong>Temps</strong></TableCell>
                                <TableCell><strong>Points Bonus</strong></TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {sortedTeams.filter(t => t.result?.rank).map((team) => (
                                <TableRow key={team.id} hover>
                                    <TableCell>
                                        <Box sx={{
                                            fontWeight: 'bold',
                                            color: team.result?.rank === 1 ? '#daa520' : (team.result?.rank === 2 ? '#c0c0c0' : (team.result?.rank === 3 ? '#cd7f32' : 'inherit')),
                                            display: 'flex', alignItems: 'center', gap: 1
                                        }}>
                                            {(team.result?.rank ?? 999) <= 3 && <EmojiEventsIcon fontSize="small" />}
                                            {team.result?.rank}
                                        </Box>
                                    </TableCell>
                                    <TableCell>{team.name}</TableCell>
                                    <TableCell>{team.result?.time || '-'}</TableCell>
                                    <TableCell>{team.result?.bonus || '-'}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
            ) : (
                <Paper sx={{ p: 4, textAlign: 'center', bgcolor: '#f8f9fa' }}>
                    <Typography variant="h6" color="text.secondary">
                        Les résultats n'ont pas encore été publiés pour cette course.
                    </Typography>
                </Paper>
            )}
        </Container>
    );
}
