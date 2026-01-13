import { Box, Typography, Card } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import {
    AssignmentOutlined,
    CheckCircleOutlined,
    PublishOutlined,
    DescriptionOutlined,
    EmojiEventsOutlined,
    PersonOutlined,
    SearchOutlined,
    FlashOnOutlined,
} from '@mui/icons-material';
import frontHomeImage from '../assets/front-home-image.png';

function Home() {
    useNavigate();

    return (
        <Box>
            <Box
                sx={{
                    backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(${frontHomeImage})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    height: { xs: '24rem', md: '100vh' },
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    textAlign: 'center',
                    color: 'white',
                }}
                id="home"
            >
                <Box className="hero-content">
                    <Typography variant="h2" component="h1" sx={{ fontSize: { xs: '2rem', md: '3.5rem' }, fontWeight: 'bold', mb: 2 }}>
                        VOTRE AVENTURE
                    </Typography>
                    <Typography variant="h2" component="h1" sx={{ fontSize: { xs: '2rem', md: '3.5rem' }, fontWeight: 'bold', mb: 4 }}>
                        COMMENCE MAINTENANT
                    </Typography>
                    <Typography variant="body1" sx={{ fontSize: { xs: '0.875rem', md: '1.125rem' }, opacity: 0.9 }}>
                        Une platforme unique pour toutes vos courses d'orientation. Inscrivez-vous, courez, explorez!
                    </Typography>
                </Box>
            </Box>

            {/* Responsables Section */}
            <Box sx={{ backgroundColor: '#1B3022', color: 'white', py: { xs: 6, md: 10 }, px: 4, textAlign: 'center' }} id="responsables">
                <Typography variant="caption" sx={{ fontSize: { xs: '0.75rem', md: '0.875rem' }, fontWeight: 600, letterSpacing: 2, display: 'block', mb: 1 }}>
                    POUR LES RESPONSABLES DE COURSES
                </Typography>
                <Typography variant="h4" sx={{ fontSize: { xs: '1.875rem', md: '2.25rem' }, fontWeight: 'bold', mb: 6 }}>
                    Organisez sans Stress
                </Typography>

                <Box sx={{ display: 'grid', gridTemplateColumns: { xs: '1fr', md: 'repeat(3, 1fr)' }, gap: 3, maxWidth: '1280px', mx: 'auto' }}>
                    <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.05)', p: 4, borderRadius: 2, border: 'none' }}>
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                            <AssignmentOutlined sx={{ fontSize: 64 }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1 }}>
                            Validation le Jour J
                        </Typography>
                        <Typography variant="body2" sx={{ opacity: 0.9 }}>
                            Gérer les dossards et les paiements sur le terrain avec l'app mobile
                        </Typography>
                    </Card>

                    <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.05)', p: 4, borderRadius: 2, border: 'none' }}>
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                            <CheckCircleOutlined sx={{ fontSize: 64 }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1 }}>
                            Validation de la course
                        </Typography>
                        <Typography variant="body2" sx={{ opacity: 0.9 }}>
                            Vérifier la validité de la course
                        </Typography>
                    </Card>

                    <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.05)', p: 4, borderRadius: 2, border: 'none' }}>
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                            <PublishOutlined sx={{ fontSize: 64 }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1 }}>
                            Import et publication rapide
                        </Typography>
                        <Typography variant="body2" sx={{ opacity: 0.9 }}>
                            Importez vos données et publiez vos événements en quelques clics
                        </Typography>
                    </Card>
                </Box>
            </Box>

            {/* Coureurs Section */}
            <Box sx={{ backgroundColor: '#1B5E20', color: 'white', py: { xs: 6, md: 10 }, px: 4 }} id="coureurs">
                <Box sx={{ textAlign: 'center', mb: 6 }}>
                    <Typography variant="caption" sx={{ fontSize: { xs: '0.75rem', md: '0.875rem' }, fontWeight: 600, letterSpacing: 2, display: 'block', mb: 1 }}>
                        POUR LES COUREURS
                    </Typography>
                    <Typography variant="h4" sx={{ fontSize: { xs: '1.875rem', md: '2.25rem' }, fontWeight: 'bold' }}>
                        Simplicité & Performance
                    </Typography>
                </Box>

                <Box sx={{ display: 'grid', gridTemplateColumns: { xs: '1fr', lg: '1fr 1fr' }, gap: 6, maxWidth: '1400px', mx: 'auto', alignItems: 'center' }}>
                    <Box sx={{ display: 'grid', gridTemplateColumns: { xs: '1fr', sm: 'repeat(2, 1fr)', md: 'repeat(3, 1fr)' }, gap: 3 }}>
                        <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.1)', p: 3, borderRadius: 2, textAlign: 'center', border: 'none' }}>
                            <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                                <PersonOutlined sx={{ fontSize: 56 }} />
                            </Box>
                            <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, fontSize: '1.125rem' }}>
                                Inscription Simplifiée
                            </Typography>
                            <Typography variant="body2" sx={{ opacity: 0.9, fontSize: '0.875rem' }}>
                                S'inscrire n'a jamais été aussi facile. En quelques clics, vous êtes prêt!
                            </Typography>
                        </Card>

                        <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.1)', p: 3, borderRadius: 2, textAlign: 'center', border: 'none' }}>
                            <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                                <DescriptionOutlined sx={{ fontSize: 56 }} />
                            </Box>
                            <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, fontSize: '1.125rem' }}>
                                Gestion des Documents
                            </Typography>
                            <Typography variant="body2" sx={{ opacity: 0.9, fontSize: '0.875rem' }}>
                                Organisez et consultez tous vos documents en un seul endroit
                            </Typography>
                        </Card>

                        <Card sx={{ backgroundColor: 'rgba(255, 255, 255, 0.1)', p: 3, borderRadius: 2, textAlign: 'center', border: 'none' }}>
                            <Box sx={{ display: 'flex', justifyContent: 'center', mb: 2 }}>
                                <EmojiEventsOutlined sx={{ fontSize: 56 }} />
                            </Box>
                            <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, fontSize: '1.125rem' }}>
                                Historique & Résultats
                            </Typography>
                            <Typography variant="body2" sx={{ opacity: 0.9, fontSize: '0.875rem' }}>
                                Suivez vos performances et vos résultats au fil du temps
                            </Typography>
                        </Card>
                    </Box>

                    <Box sx={{ display: 'flex', justifyContent: 'center' }}>
                        <Box
                            sx={{
                                width: { xs: '200px', md: '280px' },
                                height: { xs: '400px', md: '570px' },
                                backgroundColor: '#2d3e32',
                                borderRadius: '50px',
                                boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                                p: 1.5,
                                position: 'relative',
                            }}
                        >
                            <Box
                                sx={{
                                    position: 'absolute',
                                    top: 0,
                                    left: '50%',
                                    transform: 'translateX(-50%)',
                                    width: '140px',
                                    height: '28px',
                                    backgroundColor: '#2d3e32',
                                    borderBottomLeftRadius: '24px',
                                    borderBottomRightRadius: '24px',
                                    zIndex: 10,
                                }}
                            />
                            <Box
                                sx={{
                                    position: 'relative',
                                    height: '100%',
                                    backgroundColor: '#1B5E20',
                                    borderRadius: '42px',
                                    overflow: 'hidden',
                                    display: 'flex',
                                    flexDirection: 'column',
                                }}
                            >
                                <Box sx={{ backgroundColor: '#1B5E20', px: 2, pt: 2, pb: 1 }}>
                                    <Typography variant="h6" sx={{ fontWeight: 'bold', textAlign: 'center', fontSize: '1.25rem' }}>
                                        Liste des Courses
                                    </Typography>
                                </Box>
                                <Box sx={{ backgroundColor: 'white', height: '100%', px: 1.5, pt: 2, overflow: 'hidden' }}>
                                    <Card sx={{ p: 1.5, mb: 2, border: '1px solid #e5e7eb', boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)' }}>
                                        <Box sx={{ width: '100%', height: '80px', backgroundColor: '#d1d5db', borderRadius: 1, mb: 1 }} />
                                        <Typography variant="body2" sx={{ fontWeight: 'bold', mb: 0.5, fontSize: '0.875rem' }}>
                                            Course du sanglier
                                        </Typography>
                                        <Typography variant="caption" sx={{ color: '#4b5563', mb: 1, display: 'block', fontSize: '0.75rem' }}>
                                            10 juin 2025 • Localisation
                                        </Typography>
                                        <Box sx={{ width: '100%', backgroundColor: '#f97316', color: 'white', py: 1, borderRadius: 0.5, fontWeight: 600, textAlign: 'center', fontSize: '0.75rem' }}>
                                            DÉTAILS
                                        </Box>
                                    </Card>

                                    <Card sx={{ p: 1.5, border: '1px solid #e5e7eb', boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)' }}>
                                        <Box sx={{ width: '100%', height: '80px', backgroundColor: '#d1d5db', borderRadius: 1, mb: 1 }} />
                                        <Typography variant="body2" sx={{ fontWeight: 'bold', mb: 0.5, fontSize: '0.875rem' }}>
                                            Course du lapin
                                        </Typography>
                                        <Typography variant="caption" sx={{ color: '#4b5563', mb: 1, display: 'block', fontSize: '0.75rem' }}>
                                            10 juin 2025 • Localisation
                                        </Typography>
                                        <Box sx={{ width: '100%', backgroundColor: '#f97316', color: 'white', py: 1, borderRadius: 0.5, fontWeight: 600, textAlign: 'center', fontSize: '0.75rem' }}>
                                            DÉTAILS
                                        </Box>
                                    </Card>
                                </Box>
                            </Box>
                        </Box>
                    </Box>
                </Box>
            </Box>

            {/* Contact Section */}
            <Box sx={{ backgroundColor: '#f3f4f6', py: { xs: 6, md: 10 }, px: 4, textAlign: 'center' }} id="contact">
                <Typography variant="h4" sx={{ fontSize: { xs: '1.875rem', md: '2.25rem' }, fontWeight: 'bold', mb: 6, color: '#1f2937' }}>
                    Comment ça fonctionne ?
                </Typography>

                <Box sx={{ display: 'grid', gridTemplateColumns: { xs: '1fr', md: 'repeat(3, 1fr)' }, gap: 3, maxWidth: '1280px', mx: 'auto' }}>
                    <Box
                        component="a"
                        href="#inscription"
                        sx={{
                            p: 3,
                            borderRadius: '12px',
                            transition: 'all 300ms',
                            cursor: 'pointer',
                            textDecoration: 'none',
                            '&:hover': {
                                backgroundColor: 'white',
                                boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                            },
                        }}
                    >
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 1.5 }}>
                            <PersonOutlined sx={{ fontSize: 64, color: '#059669', transition: 'transform 300ms', '&:hover': { transform: 'scale(1.1)' } }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, color: '#047857' }}>
                            Créer un compte
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#4b5563' }}>
                            Inscrivez-vous en quelques minutes et complétez votre profil
                        </Typography>
                    </Box>

                    <Box
                        component="a"
                        href="#courses"
                        sx={{
                            p: 3,
                            borderRadius: '12px',
                            transition: 'all 300ms',
                            cursor: 'pointer',
                            textDecoration: 'none',
                            '&:hover': {
                                backgroundColor: 'white',
                                boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                            },
                        }}
                    >
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 1.5 }}>
                            <SearchOutlined sx={{ fontSize: 64, color: '#059669', transition: 'transform 300ms', '&:hover': { transform: 'scale(1.1)' } }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, color: '#047857' }}>
                            Trouver une course
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#4b5563' }}>
                            Découvrez des centaines d'aventures près de chez vous
                        </Typography>
                    </Box>

                    <Box
                        component="a"
                        href="#depart"
                        sx={{
                            p: 3,
                            borderRadius: '12px',
                            transition: 'all 300ms',
                            cursor: 'pointer',
                            textDecoration: 'none',
                            '&:hover': {
                                backgroundColor: 'white',
                                boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                            },
                        }}
                    >
                        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 1.5 }}>
                            <FlashOnOutlined sx={{ fontSize: 64, color: '#059669', transition: 'transform 300ms', '&:hover': { transform: 'scale(1.1)' } }} />
                        </Box>
                        <Typography variant="h6" sx={{ fontWeight: 600, mb: 1, color: '#047857' }}>
                            Envoyer au départ
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#4b5563' }}>
                            Confirmez votre participation et préparez-vous pour l'aventure
                        </Typography>
                    </Box>
                </Box>
            </Box>
        </Box>
    );
}

export default Home;
