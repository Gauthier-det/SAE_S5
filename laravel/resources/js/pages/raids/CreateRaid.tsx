import React, { useState } from 'react';
import {
    Box,
    Button,
    TextField,
    Typography,
    Paper,
    FormControl,
    InputLabel,
    Select,
    MenuItem,
    Stack
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { createRaid } from '../../api/raid';
import type { RaidCreation } from '../../model/domain/raidModel';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs, { Dayjs } from 'dayjs';

const CreateRaid = () => {
    const navigate = useNavigate();
    const [formData, setFormData] = useState<RaidCreation>({
        name: '',
        organizer: '',
        contact: '',
        website: '',
        location: '',
        illustration: '',
        startDate: '',
        endDate: ''
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name as string]: value
        }));
    };

    const handleSelectChange = (e: any) => {
        setFormData((prev) => ({
            ...prev,
            organizer: e.target.value as string
        }));
    }


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
                        name="name"
                        variant="standard"
                        value={formData.name}
                        onChange={handleChange}
                        margin="normal"
                        required
                        placeholder="Raid Miam"
                    />

                    <FormControl fullWidth variant="standard" margin="normal">
                        <InputLabel shrink>Club Organisateur</InputLabel>
                        <Select
                            value={formData.organizer}
                            onChange={handleSelectChange}
                            name="organizer"
                            label="Club Organisateur"
                            displayEmpty
                        >
                            <MenuItem value="" disabled>Choisir un organisateur</MenuItem>
                            <MenuItem value="Club A">Club A</MenuItem>
                            <MenuItem value="Club B">Club B</MenuItem>
                        </Select>
                    </FormControl>

                    <TextField
                        fullWidth
                        label="Contact"
                        name="contact"
                        variant="standard"
                        value={formData.contact}
                        onChange={handleChange}
                        margin="normal"
                        required
                        placeholder="test@gmail.com"
                    />

                    <TextField
                        fullWidth
                        label="Site Web"
                        name="website"
                        variant="standard"
                        value={formData.website}
                        onChange={handleChange}
                        margin="normal"
                        placeholder="test.course.com"
                    />

                    <TextField
                        fullWidth
                        label="Lieu"
                        name="location"
                        variant="standard"
                        value={formData.location}
                        onChange={handleChange}
                        margin="normal"
                        required
                        placeholder="Caen"
                    />

                    <TextField
                        fullWidth
                        label="Illustration"
                        name="illustration"
                        variant="standard"
                        value={formData.illustration}
                        onChange={handleChange}
                        margin="normal"
                        placeholder="course.png"
                    />

                    <Stack direction="row" spacing={4} sx={{ mt: 2, width: '100%' }}>
                        <DatePicker
                            label="Date de début"
                            value={formData.startDate ? dayjs(formData.startDate) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, startDate: newValue ? newValue.format('YYYY-MM-DD') : '' })}
                            slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
                        />
                        <DatePicker
                            label="Date de fin"
                            value={formData.endDate ? dayjs(formData.endDate) : null}
                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, endDate: newValue ? newValue.format('YYYY-MM-DD') : '' })}
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
