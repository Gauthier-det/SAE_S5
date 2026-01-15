import { Container, Typography, Box, Grid, Card, CardActionArea, CardContent, Paper, Avatar } from '@mui/material';
import { useUser } from '../contexts/userContext';
import { useNavigate } from 'react-router-dom';
import DirectionsRunIcon from '@mui/icons-material/DirectionsRun';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import AdminPanelSettingsIcon from '@mui/icons-material/AdminPanelSettings';
import GroupsIcon from '@mui/icons-material/Groups';
import AddIcon from '@mui/icons-material/Add';
import React from 'react';

export default function Dashboard() {
    const { user, isAuthenticated, isClubManager, isAdmin } = useUser();
    const navigate = useNavigate();

    const actions = [
        {
            title: 'Trouver un Raid',
            description: 'Parcourez les raids disponibles et inscrivez-vous.',
            icon: <DirectionsRunIcon sx={{ fontSize: 40, color: '#198754' }} />,
            path: '/raids',
            show: true
        },
        {
            title: 'Mon Profil',
            description: 'Gérez vos informations personnelles et certificats.',
            icon: <AccountCircleIcon sx={{ fontSize: 40, color: '#0d6efd' }} />,
            path: '/profile',
            show: isAuthenticated
        },
        {
            title: 'Mon Club',
            description: 'Gérez votre club et ses membres.',
            icon: <GroupsIcon sx={{ fontSize: 40, color: '#ffc107' }} />,
            path: user?.club ? `/club/${user.club.CLU_ID}` : '#',
            show: isAuthenticated && isClubManager && user?.club
        },
        {
            title: 'Administration',
            description: 'Panneau d\'administration global.',
            icon: <AdminPanelSettingsIcon sx={{ fontSize: 40, color: '#dc3545' }} />,
            path: '/admin',
            show: isAuthenticated && isAdmin
        }
    ];

    return (
        <Container maxWidth="xl" sx={{ mb: 8 }}>
            {/* Hero Section */}
            <Paper
                sx={{
                    p: 4,
                    my: 4,
                    background: 'linear-gradient(135deg, #198754 0%, #20c997 100%)',
                    color: 'white',
                    borderRadius: 3,
                    display: 'flex',
                    alignItems: 'center',
                    gap: 3,
                    boxShadow: '0 4px 20px rgba(0,0,0,0.1)'
                }}
            >
                {isAuthenticated && user ? (
                    <Avatar
                        sx={{
                            width: 80,
                            height: 80,
                            bgcolor: 'white',
                            color: '#198754',
                            fontWeight: 'bold',
                            fontSize: 32,
                            boxShadow: '0 4px 10px rgba(0,0,0,0.2)'
                        }}
                    >
                        {user.USE_NAME.charAt(0)}
                    </Avatar>
                ) : (
                    <Avatar
                        sx={{
                            width: 80,
                            height: 80,
                            bgcolor: 'white',
                            color: '#198754'
                        }}
                    >
                        <DirectionsRunIcon sx={{ fontSize: 40 }} />
                    </Avatar>
                )}
                <Box>
                    <Typography variant="h3" component="h1" fontWeight="bold" gutterBottom>
                        {isAuthenticated && user ? `Bonjour, ${user.USE_NAME} !` : 'Bienvenue sur Orient\'Action'}
                    </Typography>
                    <Typography variant="h6" sx={{ opacity: 0.9 }}>
                        {isAuthenticated
                            ? 'Prêt pour votre prochaine course ? Consultez votre tableau de bord ci-dessous.'
                            : 'La plateforme de référence pour gérer et participer à vos raids.'}
                    </Typography>
                </Box>
            </Paper>

            {/* Quick Actions Grid */}
            <Typography variant="h5" fontWeight="bold" gutterBottom sx={{ mt: 4, mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                <DirectionsRunIcon color="primary" /> Accès Rapide
            </Typography>

            <Grid container spacing={3}>
                {actions.filter(a => a.show).map((action, index) => (
                    <Grid item xs={12} sm={6} md={4} lg={3} key={index}>
                        <Card
                            sx={{
                                height: '100%',
                                borderRadius: 2,
                                transition: '0.3s',
                                '&:hover': {
                                    transform: 'translateY(-5px)',
                                    boxShadow: '0 8px 25px rgba(0,0,0,0.1)'
                                }
                            }}
                        >
                            <CardActionArea
                                onClick={() => navigate(action.path)}
                                sx={{ height: '100%', p: 2 }}
                            >
                                <CardContent sx={{ textAlign: 'center' }}>
                                    <Box sx={{ mb: 2, display: 'flex', justifyContent: 'center' }}>
                                        {action.icon}
                                    </Box>
                                    <Typography variant="h6" component="div" fontWeight="bold" gutterBottom>
                                        {action.title}
                                    </Typography>
                                    <Typography variant="body2" color="text.secondary">
                                        {action.description}
                                    </Typography>
                                </CardContent>
                            </CardActionArea>
                        </Card>
                    </Grid>
                ))}
            </Grid>

            {/* Additional Info Section (Optional) */}
            {!isAuthenticated && (
                <Box sx={{ mt: 6, textAlign: 'center' }}>
                    <Typography variant="body1" color="text.secondary">
                        Connectez-vous pour accéder à toutes les fonctionnalités.
                    </Typography>
                </Box>
            )}
        </Container>
    );
}
