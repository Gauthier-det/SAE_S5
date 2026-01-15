import React, { useState } from 'react';
import {
    Box,
    Button,
    Container,
    TextField,
    Typography,
    Paper,
    Stack,
    Select,
    MenuItem,
    FormControl,
    InputLabel,
    type SelectChangeEvent
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import LogoColor from '../../assets/logo-color.png';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import type { Gender } from '../../models/user.model';

const Register = () => {
    const [formData, setFormData] = useState<{
        name: string;
        last_name: string;
        mail: string;
        password: string;
        gender: Gender | '';
    }>({
        name: '',
        last_name: '',
        mail: '',
        password: '',
        gender: ''
    });

    const [error, setError] = useState('');
    const { register } = useUser();
    const { showAlert } = useAlert();
    const navigate = useNavigate();

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleGenderChange = (event: SelectChangeEvent) => {
        setFormData(prev => ({
            ...prev,
            gender: event.target.value as Gender
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');

        if (formData.password.length < 8) {
            const errorMessage = 'Le mot de passe doit contenir au moins 8 caractères.';
            setError(errorMessage);
            showAlert(errorMessage, 'error');
            return;
        }

        if (formData.gender === '') {
            setError('Veuillez sélectionner un genre.');
            return;
        }

        try {
            await register(formData as any); 
            showAlert('Inscription réussie !', 'success');
            navigate('/dashboard');
        } catch (err: any) {
            console.error(err);
            let errorMessage = "Échec de l'inscription. Vérifiez vos informations.";
            if (err.name === 'ApiError' && err.data && err.data.errors) {
                const messages = Object.values(err.data.errors).flat().join(' ');
                errorMessage = messages;
            } else {
                errorMessage = err.message || errorMessage;
            }
            setError(errorMessage);
            showAlert(errorMessage, 'error');
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
                            name="mail"
                            autoComplete="email"
                            variant="standard"
                            value={formData.mail}
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
                            <FormControl fullWidth variant="standard" required>
                                <InputLabel id="gender-select-label">Genre</InputLabel>
                                <Select
                                    labelId="gender-select-label"
                                    id="gender-select"
                                    value={formData.gender}
                                    onChange={handleGenderChange}
                                    label="Genre"
                                >
                                    <MenuItem value="Homme">Homme</MenuItem>
                                    <MenuItem value="Femme">Femme</MenuItem>
                                    <MenuItem value="Autre">Autre</MenuItem>
                                </Select>
                            </FormControl>
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
                                sx={{ color: 'white', borderRadius: '10px', fontSize: '12px' }}
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
