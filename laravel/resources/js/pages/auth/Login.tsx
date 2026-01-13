
import React, { useState } from 'react';
import {
    Box,
    Button,
    Container,
    TextField,
    Typography,
    Paper,
    Link,
    Stack
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { useUser } from '../../contexts/userContext';
import LogoColor from '../../assets/logo-color.png';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const { login } = useUser();
    const navigate = useNavigate();

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');
        try {
            await login({ email, password });
            navigate('/dashboard');
        } catch (err) {
            setError('Échec de la connexion. Vérifiez vos identifiants.');
            console.error(err);
        }
    };

    return (
        <Box
            sx={{
                flexGrow: 1,
                backgroundColor: 'primary.main',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                overflow: 'hidden',
            }}
        >
            <Container maxWidth="sm">
                <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', mb: 4 }}>
                    <Box
                        component="img"
                        src={LogoColor}
                        alt="Orient'Action"
                        sx={{backgroundColor: 'white', width: 250, height: 'auto', mb: 2, borderRadius: 4 }}
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
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
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

                        {error && (
                            <Typography color="error" variant="body2" sx={{ mt: 2 }}>
                                {error}
                            </Typography>
                        )}

                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            color="primary"
                            sx={{ mt: 5, mb: 4, py: 1.5, color: 'white' }}
                        >
                            SE CONNECTER
                        </Button>

                        <Stack spacing={2} alignItems="center">
                            <Link href="#" variant="body2" color="text.primary" sx={{ textDecoration: 'none', fontSize: '12px' }}>
                                mot de passe oublié
                            </Link>
                            <Link href="#" variant="body2" color="text.primary" sx={{ textDecoration: 'none', fontSize: '12px' }}>
                                s'inscrire
                            </Link>
                        </Stack>
                    </Box>
                </Paper>
            </Container>
        </Box>
    );
};

export default Login;
