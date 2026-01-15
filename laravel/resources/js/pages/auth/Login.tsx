
import React, { useState } from 'react';
import {
    Box,
    Button,
    Container,
    TextField,
    Typography,
    Paper,
    Stack
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import LogoColor from '../../assets/logo-color.png';

const Login = () => {
    const [mail, setMail] = useState('');
    const [password, setPassword] = useState('');
    const { login } = useUser();
    const { showAlert } = useAlert();
    const navigate = useNavigate();

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            await login({ mail, password });
            showAlert('Connexion réussie', 'success');
            navigate('/');
        } catch (err) {
            console.error(err);
            showAlert('Erreur de connexion. Vérifiez vos identifiants.', 'error');
        }
    };

    return (
        <Box
            sx={{
                flexGrow: 1,
                backgroundColor: 'primary.main',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            }}
        >
            <Container maxWidth="sm">
                <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', mb: 4 }}>
                    <Box
                        component="img"
                        src={LogoColor}
                        alt="Orient'Action"
                        sx={{ backgroundColor: 'white', width: 250, height: 'auto', borderRadius: 4 }}
                    />
                </Box>
                <Paper
                    elevation={3}
                    sx={{
                        p: 6,
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                        borderRadius: 4,
                        backgroundColor: 'background.paper'
                    }}
                >
                    <Typography component="h1" variant="h6" sx={{ mb: 4, fontWeight: 'bold', textTransform: 'uppercase', fontFamily: '"Archivo Black", sans-serif' }}>
                        Connexion
                    </Typography>

                    <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
                        <TextField
                            margin="normal"
                            required
                            fullWidth
                            id="email"
                            label="e-mail"
                            name="email"
                            autoComplete="email"
                            autoFocus
                            variant="standard"
                            value={mail}
                            onChange={(e) => setMail(e.target.value)}
                            placeholder="adresse.email@mail.com"
                        />
                        <TextField
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="mot de passe"
                            type="password"
                            id="password"
                            autoComplete="current-password"
                            variant="standard"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            placeholder="mot de passe"
                            sx={{ mt: 3 }}
                        />

                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            color="primary"
                            sx={{ mt: 5, mb: 4, py: 1.5, color: 'white', borderRadius: '10px' }}
                        >
                            SE CONNECTER
                        </Button>

                        <Stack spacing={2} alignItems="center">
                            <>
                                <Button
                                    variant="contained"
                                    color="warning"
                                    sx={{ color: 'white', borderRadius: '10px', fontSize: '12px' }}
                                    onClick={() => navigate('/login')}
                                >
                                    Mot de passe oublié ?
                                </Button>
                                <Button
                                    variant="contained"
                                    color="warning"
                                    sx={{ color: 'white', borderRadius: '10px', fontSize: '12px' }}
                                    onClick={() => navigate('/register')}
                                >
                                    S'inscrire
                                </Button>
                            </>
                        </Stack>
                    </Box>
                </Paper>
            </Container>
        </Box>
    );
};

export default Login;
