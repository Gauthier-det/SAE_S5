import React, { useState, useEffect } from 'react';
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
import Grid from '@mui/material/Grid';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import 'dayjs/locale/fr';
import { useNavigate } from 'react-router-dom';
import { createRaid } from '../../api/raid';
import type { RaidCreation } from '../../models/raid.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs, { Dayjs } from 'dayjs';
import { useUser } from '../../contexts/userContext';
import { getClub, getClubUsers, type Club } from '../../api/club';
import type { User } from '../../models/user.model';
import { createAddress, type Address } from '../../api/address';

const CreateRaid = () => {
    const navigate = useNavigate();
    const { user } = useUser();

    // Form data for Raid
    const [formData, setFormData] = useState<RaidCreation>({
        CLU_ID: 0,
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

    // Address Form Data
    const [addressData, setAddressData] = useState<Address>({
        ADD_STREET_NUMBER: '',
        ADD_STREET_NAME: '',
        ADD_CITY: '',
        ADD_POSTAL_CODE: ''
    });

    // Extra state
    const [clubName, setClubName] = useState<string>('');
    const [clubUsers, setClubUsers] = useState<User[]>([]);
    const [selectedResponsible, setSelectedResponsible] = useState<number | ''>(''); // This maps to USE_ID to be sent? Raid model might need update if we want to store responsible. 
    // Wait, RaidController expects USE_ID? Let's check. Yes 'USE_ID' => 'required|integer|exists:SAN_USERS,USE_ID'
    // This USE_ID in Raid Creation is likely the creator or the responsible. Let's assume it's the responsible selected.

    useEffect(() => {
        const init = async () => {
            if (user && user.CLU_ID) {
                setFormData(prev => ({ ...prev, CLU_ID: user.CLU_ID! }));
                try {
                    // Fetch Club info
                    const club = await getClub(user.CLU_ID);
                    if (club) setClubName(club.CLU_NAME);

                    // Fetch Club Users for Responsible selection
                    const users = await getClubUsers(user.CLU_ID);
                    setClubUsers(users || []);
                } catch (e) {
                    console.error("Failed to load club info", e);
                }
            }
        };
        init();
    }, [user]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name as string]: value
        }));
    };

    const handleAddressChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setAddressData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        try {
            // 1. Create Address
            const addId = await createAddress(addressData);

            // 2. Prepare Raid Data
            const raidData = {
                ...formData,
                ADD_ID: addId,
                USE_ID: selectedResponsible ? (selectedResponsible as number) : (user?.USE_ID || 1) // Default to current user if not selected (or force selection?)
            };

            // 3. Create Raid
            await createRaid(raidData);
            navigate('/raids');
        } catch (error) {
            console.error('Error creating raid:', error);
        }
    };

    return (
        <Box
            sx={{
                flexGrow: 1,
                bgcolor: '#fcfcfc', // Off-white background as per image
                minHeight: '100vh',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                py: 4
            }}
        >
            <Paper
                elevation={0}
                sx={{
                    p: 6,
                    width: '100%',
                    maxWidth: 1000,
                    bgcolor: 'transparent'
                }}
            >
                <Typography component="h2" variant="h5" sx={{ mb: 6, fontWeight: 'bold', textTransform: 'uppercase', textAlign: 'center', fontFamily: '"Archivo Black", sans-serif' }}>
                    NOUVEAU RAID
                </Typography>

                <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
                    <LocalizationProvider dateAdapter={AdapterDayjs} adapterLocale="fr">
                        <Grid container spacing={6}>
                            {/* Left Column */}
                            <Grid size={{ xs: 12, md: 6 }}>
                                <Stack spacing={3}>
                                    <TextField
                                        fullWidth
                                        label="Nom du Raid"
                                        name="RAI_NAME"
                                        variant="standard"
                                        value={formData.RAI_NAME}
                                        onChange={handleChange}
                                        required
                                        InputLabelProps={{ shrink: true }}
                                        placeholder="Raid Miam"
                                    />

                                    <FormControl fullWidth variant="standard">
                                        <InputLabel shrink>Club Organisateur</InputLabel>
                                        <Select
                                            value={user?.CLU_ID || ''}
                                            disabled
                                            displayEmpty
                                            renderValue={() => clubName || "Chargement..."}
                                        >
                                            <MenuItem value={user?.CLU_ID}>{clubName}</MenuItem>
                                        </Select>
                                    </FormControl>

                                    <FormControl fullWidth variant="standard">
                                        <InputLabel shrink>Responsable</InputLabel>
                                        <Select
                                            value={selectedResponsible}
                                            onChange={(e) => setSelectedResponsible(e.target.value as number)}
                                            displayEmpty
                                        >
                                            <MenuItem value="" disabled>Sélectionner un responsable</MenuItem>
                                            {clubUsers.map(u => (
                                                <MenuItem key={u.USE_ID} value={u.USE_ID}>{u.USE_NAME} {u.USE_LAST_NAME}</MenuItem>
                                            ))}
                                        </Select>
                                    </FormControl>

                                    <TextField
                                        fullWidth
                                        label="Contact (Email)"
                                        name="RAI_MAIL"
                                        variant="standard"
                                        value={formData.RAI_MAIL}
                                        onChange={handleChange}
                                        InputLabelProps={{ shrink: true }}
                                        required
                                        placeholder="test@gmail.com"
                                    />

                                    <TextField
                                        fullWidth
                                        label="Téléphone (Si besoin)"
                                        name="RAI_PHONE_NUMBER"
                                        variant="standard"
                                        value={formData.RAI_PHONE_NUMBER}
                                        onChange={handleChange}
                                        InputLabelProps={{ shrink: true }}
                                        placeholder="06..."
                                    />

                                    <TextField
                                        fullWidth
                                        label="Site Web"
                                        name="RAI_WEB_SITE"
                                        variant="standard"
                                        value={formData.RAI_WEB_SITE}
                                        onChange={handleChange}
                                        InputLabelProps={{ shrink: true }}
                                        placeholder="test.course.com"
                                    />

                                    <Box>
                                        <Typography variant="caption" sx={{ color: 'text.secondary', mb: 1, display: 'block' }}>Lieu</Typography>
                                        <Stack direction="row" spacing={2}>
                                            <TextField
                                                label="Ville"
                                                name="ADD_CITY"
                                                variant="standard"
                                                value={addressData.ADD_CITY}
                                                onChange={handleAddressChange}
                                                fullWidth
                                                required
                                                placeholder="Caen"
                                            />
                                            <TextField
                                                label="Code Postal"
                                                name="ADD_POSTAL_CODE"
                                                variant="standard"
                                                value={addressData.ADD_POSTAL_CODE}
                                                onChange={handleAddressChange}
                                                fullWidth
                                                required
                                                placeholder="14000"
                                            />
                                        </Stack>
                                        <Stack direction="row" spacing={2} sx={{ mt: 1 }}>
                                            <TextField
                                                label="N°"
                                                name="ADD_STREET_NUMBER"
                                                variant="standard"
                                                value={addressData.ADD_STREET_NUMBER}
                                                onChange={handleAddressChange}
                                                sx={{ width: '100px' }}
                                                required
                                                placeholder="12"
                                            />
                                            <TextField
                                                label="Rue"
                                                name="ADD_STREET_NAME"
                                                variant="standard"
                                                value={addressData.ADD_STREET_NAME}
                                                onChange={handleAddressChange}
                                                fullWidth
                                                required
                                                placeholder="rue de la Paix"
                                            />
                                        </Stack>
                                    </Box>

                                    <TextField
                                        fullWidth
                                        label="Illustration"
                                        name="RAI_IMAGE"
                                        variant="standard"
                                        value={formData.RAI_IMAGE}
                                        onChange={handleChange}
                                        InputLabelProps={{ shrink: true }}
                                        placeholder="course.png"
                                    />
                                </Stack>
                            </Grid>

                            {/* Right Column (Dates) */}
                            <Grid size={{ xs: 12, md: 6 }}>
                                <Stack spacing={4} sx={{ mt: { md: 10 } }}>

                                    <Typography variant="h6" sx={{ mt: 4 }}>Inscriptions</Typography>
                                    <Stack direction="row" spacing={4}>
                                        <DatePicker
                                            label="Début inscriptions"
                                            value={formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_START: newValue ? newValue.toISOString() : '' })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: "À partir d'aujourd'hui"
                                                }
                                            }}
                                            minDate={dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                        <DatePicker
                                            label="Fin inscriptions"
                                            value={formData.RAI_REGISTRATION_END ? dayjs(formData.RAI_REGISTRATION_END) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_END: newValue ? newValue.toISOString() : '' })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: "Après le début des inscriptions"
                                                }
                                            }}
                                            minDate={formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START) : dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                    </Stack>

                                    <Typography variant="h6">Période du Raid</Typography>
                                    <Stack direction="row" spacing={4}>
                                        <DatePicker
                                            label="Date de début du raid"
                                            value={formData.RAI_TIME_START ? dayjs(formData.RAI_TIME_START) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_START: newValue ? newValue.toISOString() : '' })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: "Après la fin des inscriptions"
                                                }
                                            }}
                                            minDate={formData.RAI_REGISTRATION_END ? dayjs(formData.RAI_REGISTRATION_END) : (formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START) : dayjs())}
                                            format="DD/MM/YYYY"
                                        />
                                        <DatePicker
                                            label="Date de fin du raid"
                                            value={formData.RAI_TIME_END ? dayjs(formData.RAI_TIME_END) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_END: newValue ? newValue.toISOString() : '' })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: "Après le début du raid"
                                                }
                                            }}
                                            minDate={formData.RAI_TIME_START ? dayjs(formData.RAI_TIME_START) : dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                    </Stack>
                                </Stack>

                                <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 8 }}>
                                    <Button
                                        type="submit"
                                        variant="contained"
                                        color="success"
                                        sx={{
                                            px: 6,
                                            py: 1.5,
                                            bgcolor: '#1b5e20',
                                            borderRadius: 1,
                                            fontWeight: 'bold',
                                            '&:hover': {
                                                bgcolor: '#144a19'
                                            }
                                        }}
                                    >
                                        VALIDER
                                    </Button>
                                </Box>
                            </Grid>

                        </Grid>
                    </LocalizationProvider>
                </Box>
            </Paper >
        </Box >
    );
};

export default CreateRaid;
