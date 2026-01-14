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
import LogoColor from '../../assets/logo-color.png';
import { useUser } from '../../contexts/userContext';

const Register = () => {
    const [formData, setFormData] = useState({
        name: '',
        last_name: '',
        email: '',
        password: ''
    });

    const [error, setError] = useState('');
    const { register } = useUser();
    const navigate = useNavigate();

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');

        if (formData.password.length < 8) {
            setError('Le mot de passe doit contenir au moins 8 caractères.');
            return;
        }

        try {
            // Register and automatically login the user
            await register({
                name: formData.name,
                last_name: formData.last_name,
                email: formData.email,
                password: formData.password
            });
            // Redirect to dashboard after successful registration
            navigate('/dashboard');
        } catch (err: any) { // Type as any or import ApiError to check instance
            console.error(err);
            if (err.name === 'ApiError' && err.data && err.data.errors) {
                // Laravel validation errors format: { field: ["error1", "error2"] }
                const messages = Object.values(err.data.errors).flat().join(' ');
                setError(messages);
            } else {
                setError(err.message || "Échec de l'inscription. Vérifiez vos informations.");
            }
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
                minHeight: '100vh',
                py: 4
            }}
        >
            <Container maxWidth="md">
                <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', mb: 2 }}>
                    <Box
                        component="img"
                        src={LogoColor}
                        alt="Orient'Action"
                        sx={{ backgroundColor: 'white', width: 150, height: 'auto', mb: 2, borderRadius: 4, p: 1 }}
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
                        backgroundColor: 'background.paper',
                        width: '100%'
                    }}
                >
                    <Typography component="h1" variant="h5" sx={{ mb: 4, fontWeight: 'bold', textTransform: 'uppercase', fontFamily: '"Archivo Black", sans-serif' }}>
                        Inscription
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
                            variant="standard"
                            value={formData.email}
                            onChange={handleChange}
                            placeholder="jean.dupont@gmail.com"
                        />
                        <TextField
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="mot de passe"
                            type="password"
                            id="password"
                            autoComplete="new-password"
                            variant="standard"
                            value={formData.password}
                            onChange={handleChange}
                            sx={{ mt: 3, mb: 3 }}
                        />

                        <Stack direction={{ xs: 'column', sm: 'row' }} spacing={2} sx={{ mb: 2 }}>
                            <TextField
                                required
                                fullWidth
                                name="name"
                                label="Nom"
                                id="name"
                                variant="standard"
                                value={formData.name}
                                onChange={handleChange}
                                placeholder="Dupont"
                            />
                            <TextField
                                required
                                fullWidth
                                name="last_name"
                                label="Prénom"
                                id="last_name"
                                variant="standard"
                                value={formData.last_name}
                                onChange={handleChange}
                                placeholder="Jean"
                            />
                        </Stack>

                        {error && (
                            <Typography color="error" variant="body2" sx={{ mt: 2 }}>
                                {error}
                            </Typography>
                        )}

                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            color="success" // Matching the image green button
                            sx={{ mt: 2, mb: 2, py: 1.5, color: 'white', backgroundColor: '#1b5e20' }} // Custom green to match image darker green
                        >
                            S'INSCRIRE
                        </Button>

                        <Stack alignItems="center">
                            <Link href="/login" variant="body2" color="text.primary" sx={{ textDecoration: 'none', fontSize: '12px' }}>
                                se connecter
                            </Link>
                        </Stack>
                    </Box>
                </Paper>
            </Container>
        </Box>
    );
};

export default Register;
