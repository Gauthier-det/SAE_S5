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
import LogoColor from '../assets/logo-color.png';
import { apiRegister } from '../api/auth'; // Direct API call for now since context might not have it yet
// Or best to add it to context, but user didn't ask for context update explicitly, but logic suggests it.
// I'll stick to local state/API for "mocking" as requested.

const Register = () => {
    const [formData, setFormData] = useState({
        name: '',
        last_name: '',
        email: '',
        password: '',
        phone: '',
        address: '',
        age: '', // Date picker in image but string for now
        gender: 'Homme', // Default
        isLicensed: false
    });

    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, checked, type } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');
        try {
            // Mapping to the strictly requested model (name, last_name, email, password)
            await apiRegister({
                name: formData.name,
                last_name: formData.last_name,
                email: formData.email,
                password: formData.password
            });
            // Redirect to dashboard or login
            navigate('/login');
        } catch (err) {
            setError("Échec de l'inscription.");
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
            }}
        >
            <Container maxWidth="md">
                <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', mb: 2 }}>
                    <Box
                        component="img"
                        src={LogoColor}
                        alt="Orient'Action"
                        sx={{ backgroundColor: 'white', width: 250, height: 'auto', mb: 2, borderRadius: 4 }}
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
                            color="success"
                            sx={{ mt: 2, mb: 2, py: 1.5, color: 'white', borderRadius: '10px' }}
                        >
                            S'INSCRIRE
                        </Button>

                        <Stack alignItems="center">
                            <Button
                                variant="contained"
                                color="warning"
                                sx={{color: 'white', borderRadius: '10px', fontSize: '12px'}}
                                onClick={() => navigate('/login')}
                            >
                                Se connecter
                            </Button>
                        </Stack>
                    </Box>
                </Paper>
            </Container>
        </Box>
    );
};

export default Register;
