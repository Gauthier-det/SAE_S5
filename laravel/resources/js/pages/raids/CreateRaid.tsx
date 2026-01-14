import React, { useState } from 'react';
import {
    Box,
    Button,
    TextField,
    Typography,
    Paper,
    Stack
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { createRaid } from '../../api/raid';
import type { RaidCreation } from '../../models/raid.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs, { Dayjs } from 'dayjs';
import { useUser } from '../../contexts/userContext';

const CreateRaid = () => {
    const { user } = useUser();
    const navigate = useNavigate();
    const [formData, setFormData] = useState<RaidCreation>({
        CLU_ID: user?.CLU_ID!,
        ADD_ID: 0,
        RAI_NAME: '',
        RAI_MAIL: '',
        RAI_PHONE_NUMBER: '',
        RAI_WEB_SITE: '',
        RAI_IMAGE: '',
        RAI_TIME_START: '',
        RAI_TIME_END: '',
        RAI_REGISTRATION_START: '',
        RAI_REGISTRATION_END: ''
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name as string]: value
        }));
    };


    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            await createRaid(formData);
            navigate('/raids');
        } catch (error) {
            console.error('Error creating raid:', error);
        }
    };

    return (
        <Box
            sx={{
                flexGrow: 1,
                bgcolor: '#1a2e22',
                minHeight: '100vh',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                py: 4
            }}
        >
            <Typography
                variant="h4"
                component="h4"
                sx={{
                    color: 'white',
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                    textAlign: 'center',
                    mb: 4,
                    fontFamily: '"Archivo Black", sans-serif'
                }}
            >
                CREATION D'UN RAID
            </Typography>

            <Paper
                elevation={3}
                sx={{
                    p: 6,
                    width: '100%',
                    maxWidth: 800,
                    borderRadius: 4,
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center'
                }}
            >
                <Typography component="h2" variant="h6" sx={{ mb: 4, fontWeight: 'bold', textTransform: 'uppercase' }}>
                    NOUVEAU RAID
                </Typography>

                <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
                    <TextField
                        fullWidth
                        label="Nom du Raid"
                        name="RAI_NAME"
                        variant="standard"
                        value={formData.RAI_NAME}
                        onChange={handleChange}
                        margin="normal"
                        required
                        placeholder="Raid Miam"
                    />

                    <TextField
                        fullWidth
                        label="Contact Email"
                        name="RAI_MAIL"
                        variant="standard"
                        value={formData.RAI_MAIL}
                        onChange={handleChange}
                        margin="normal"
                        required
                        placeholder="contact@raid.com"
                    />

                    <TextField
                        fullWidth
                        label="Téléphone"
                        name="RAI_PHONE_NUMBER"
                        variant="standard"
                        value={formData.RAI_PHONE_NUMBER}
                        onChange={handleChange}
                        margin="normal"
                        placeholder="0123456789"
                    />

                    <TextField
                        fullWidth
                        label="Site Web"
                        name="RAI_WEB_SITE"
                        variant="standard"
                        value={formData.RAI_WEB_SITE}
                        onChange={handleChange}
                        margin="normal"
                        placeholder="https://raid.com"
                    />

                    <TextField
                        fullWidth
                        label="Illustration"
                        name="RAI_IMAGE"
                        variant="standard"
                        value={formData.RAI_IMAGE}
                        onChange={handleChange}
                        margin="normal"
                        placeholder="raid.jpg"
                    />

                    <Stack direction="row" spacing={4} sx={{ mt: 2, width: '100%' }}>
                        <DatePicker
                            label="Début du raid"
                            value={formData.RAI_TIME_START ? dayjs(formData.RAI_TIME_START) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_START: newValue ? newValue.toISOString() : '' })}
                            slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
                        />
                        <DatePicker
                            label="Fin du raid"
                            value={formData.RAI_TIME_END ? dayjs(formData.RAI_TIME_END) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_END: newValue ? newValue.toISOString() : '' })}
                            slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
                        />
                    </Stack>

                    <Stack direction="row" spacing={4} sx={{ mt: 2, width: '100%' }}>
                        <DatePicker
                            label="Début inscriptions"
                            value={formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_START: newValue ? newValue.toISOString() : '' })}
                            slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
                        />
                        <DatePicker
                            label="Fin inscriptions"
                            value={formData.RAI_REGISTRATION_END ? dayjs(formData.RAI_REGISTRATION_END) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_END: newValue ? newValue.toISOString() : '' })}
                            slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
                        />
                    </Stack>

                    <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 6 }}>
                        <Button
                            type="submit"
                            variant="contained"
                            color="success"
                            sx={{
                                px: 6,
                                py: 1.5,
                                bgcolor: '#1b5e20',
                                '&:hover': {
                                    bgcolor: '#144a19'
                                }
                            }}
                        >
                            VALIDER
                        </Button>
                    </Box>
                </Box>
            </Paper>
        </Box>
    );
};

export default CreateRaid;
