import React, { useState, useEffect } from 'react';
import {
    Box,
    Button,
    TextField,
    Typography,
    Paper,
    Stack,
    FormControl,
    InputLabel,
    Select,
    MenuItem,
    Alert,
    FormHelperText,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions
} from '@mui/material';
import Grid from '@mui/material/Grid';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import 'dayjs/locale/fr';
import { useNavigate, useParams } from 'react-router-dom';
import { updateRaid, getRaidById, deleteRaid } from '../../api/raid';
import type { RaidCreation, Raid } from '../../models/raid.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs, { Dayjs } from 'dayjs';
import { useUser } from '../../contexts/userContext';
import { useAlert } from '../../contexts/AlertContext';
import { getClubUsers } from '../../api/club';
import type { User } from '../../models/user.model';
import { updateAddress } from '../../api/address';
import type { AddressCreation } from '../../models/address.model';

const EditRaid = () => {
    const { id } = useParams<{ id: string }>();
    const { user, refreshUser } = useUser();
    const navigate = useNavigate();
    const { showAlert } = useAlert();

    // Form data for Raid
    const [formData, setFormData] = useState<RaidCreation>({
        CLU_ID: 0,
        ADD_ID: 0,
        RAI_NAME: '',
        RAI_MAIL: '',
        RAI_PHONE_NUMBER: null,
        RAI_WEB_SITE: null,
        RAI_IMAGE: null,
        RAI_TIME_START: null,
        RAI_TIME_END: null,
        RAI_REGISTRATION_START: null,
        RAI_REGISTRATION_END: null,
        RAI_NB_RACES: 0
    });

    // Address Form Data
    const [addressData, setAddressData] = useState<AddressCreation>({
        ADD_STREET_NUMBER: '',
        ADD_STREET_NAME: '',
        ADD_CITY: '',
        ADD_POSTAL_CODE: ''
    });

    // Extra state
    const [clubName, setClubName] = useState<string>('');
    const [clubUsers, setClubUsers] = useState<User[]>([]);
    const [selectedResponsible, setSelectedResponsible] = useState<number | ''>('');
    const [errors, setErrors] = useState<string[]>([]);
    const [fieldErrors, setFieldErrors] = useState<Record<string, string[]>>({});
    const [loading, setLoading] = useState(true);
    const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);

    // USE_ID in Raid editing is the responsible person selected from club users.

    useEffect(() => {
        const init = async () => {
            if (!id) return;
            try {
                const raidId = parseInt(id);
                const raidData = await getRaidById(raidId);

                // Populate form with raid data
                setFormData({
                    CLU_ID: raidData.club.CLU_ID,
                    ADD_ID: raidData.address.ADD_ID,
                    RAI_NAME: raidData.RAI_NAME,
                    RAI_MAIL: raidData.RAI_MAIL || '',
                    RAI_PHONE_NUMBER: raidData.RAI_PHONE_NUMBER,
                    RAI_WEB_SITE: raidData.RAI_WEB_SITE,
                    RAI_IMAGE: raidData.RAI_IMAGE,
                    RAI_TIME_START: raidData.RAI_TIME_START,
                    RAI_TIME_END: raidData.RAI_TIME_END,
                    RAI_REGISTRATION_START: raidData.RAI_REGISTRATION_START,
                    RAI_REGISTRATION_END: raidData.RAI_REGISTRATION_END,
                    RAI_NB_RACES: raidData.RAI_NB_RACES
                });

                // Populate address data
                setAddressData({
                    ADD_STREET_NUMBER: raidData.address.ADD_STREET_NUMBER || '',
                    ADD_STREET_NAME: raidData.address.ADD_STREET_NAME || '',
                    ADD_POSTAL_CODE: raidData.address.ADD_POSTAL_CODE,
                    ADD_CITY: raidData.address.ADD_CITY
                });

                // Set club name and responsible
                setClubName(raidData.club.CLU_NAME);
                setSelectedResponsible(raidData.user.USE_ID);

                // Fetch Club Users for Responsible selection
                if (user && user.club) {
                    const users = await getClubUsers(user.club.CLU_ID);
                    setClubUsers(users || []);
                }
            } catch (e) {
                console.error("Failed to load raid info", e);
                showAlert("Impossible de charger les informations du raid", "error");
            } finally {
                setLoading(false);
            }
        };
        init();
    }, [id, user, showAlert]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
        const { name, value } = e.target;
        // Handle numeric fields
        const numericValue = name === 'RAI_NB_RACES' ? parseInt(value as string) || 0 : value;
        setFormData((prev) => ({
            ...prev,
            [name as string]: numericValue
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
            if (!id) return;
            const raidId = parseInt(id);

            // 1. Update Address
            if (formData.ADD_ID) {
                await updateAddress(formData.ADD_ID, addressData);
            }

            console.log('Address updated');
            // Format dates to YYYY-MM-DD HH:mm:ss for Laravel
            const formatDate = (d: string | null | undefined) => d ? dayjs(d).format('YYYY-MM-DD HH:mm:ss') : null;

            // Handle URL prefix
            let webSite = formData.RAI_WEB_SITE;
            if (webSite && !webSite.startsWith('http://') && !webSite.startsWith('https://')) {
                webSite = 'https://' + webSite;
            }

            // 2. Prepare Raid Data (with USE_ID to maintain responsibility info)
            const raidData = {
                CLU_ID: formData.CLU_ID,
                ADD_ID: formData.ADD_ID,
                USE_ID: selectedResponsible as number,
                RAI_NAME: formData.RAI_NAME,
                RAI_MAIL: formData.RAI_MAIL || null,
                RAI_PHONE_NUMBER: formData.RAI_PHONE_NUMBER || null,
                RAI_WEB_SITE: webSite || null,
                RAI_IMAGE: formData.RAI_IMAGE || null,
                RAI_TIME_START: formatDate(formData.RAI_TIME_START),
                RAI_TIME_END: formatDate(formData.RAI_TIME_END),
                RAI_REGISTRATION_START: formatDate(formData.RAI_REGISTRATION_START),
                RAI_REGISTRATION_END: formatDate(formData.RAI_REGISTRATION_END),
                RAI_NB_RACES: formData.RAI_NB_RACES
            };

            console.log('Raid Data:', raidData);

            // 3. Update Raid
            await updateRaid(raidId, raidData);
            await refreshUser();
            setErrors([]);
            showAlert('Raid modifié avec succès', 'success');
            navigate(`/raids/${raidId}`);
        } catch (error: any) {
            console.error('Error updating raid:', error);
            showAlert('Erreur lors de la modification du raid', 'error');
            const errorData = error.data || error.body;
            if (errorData?.errors) {
                setFieldErrors(errorData.errors);
                const errorMessages = Object.values(errorData.errors).flat() as string[];
                setErrors(errorMessages);
            } else {
                setErrors([error.message || 'Une erreur est survenue']);
            }
        }
    };

    const handleDeleteConfirm = async () => {
        try {
            await deleteRaid(parseInt(id || '0'));
            showAlert('Raid supprimé avec succès', 'success');
            navigate('/raids');
        } catch (error: any) {
            console.error('Error deleting raid:', error);
            showAlert('Erreur lors de la suppression du raid', 'error');
        }
        setDeleteDialogOpen(false);
    };

    if (loading) {
        return (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh' }}>
                <Typography>Chargement...</Typography>
            </Box>
        );
    }

    return (
        <Box
            sx={{
                flexGrow: 1,
                bgcolor: '#1a2e22',
                overflow: 'auto',
                minHeight: 0,
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'flex-start',
                p: 4,
                pb: 12
            }}
        >
            <Paper
                elevation={0}
                sx={{
                    p: 6,
                    width: '100%',
                    maxWidth: 1000,
                    height: 'fit-content'
                }}
            >
                <Typography component="h2" variant="h5" sx={{ mb: 6, fontWeight: 'bold', textTransform: 'uppercase', textAlign: 'center', fontFamily: '"Archivo Black", sans-serif' }}>
                    MODIFIER RAID
                </Typography>

                {errors.length > 0 && (
                    <Box sx={{ mb: 3 }}>
                        {errors.map((err, idx) => (
                            <Alert key={idx} severity="error" sx={{ mb: 1 }}>{err}</Alert>
                        ))}
                    </Box>
                )}

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
                                        placeholder="Raid"
                                        error={!!fieldErrors.RAI_NAME}
                                        helperText={fieldErrors.RAI_NAME?.[0]}
                                    />

                                    <FormControl fullWidth variant="standard">
                                        <TextField
                                            label="Club organisateur"
                                            variant="standard"
                                            value={clubName || ''}
                                            disabled
                                            InputLabelProps={{ shrink: true }}
                                        />
                                    </FormControl>

                                    <FormControl fullWidth variant="standard" error={!!fieldErrors.USE_ID}>
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
                                        {fieldErrors.USE_ID && <FormHelperText>{fieldErrors.USE_ID[0]}</FormHelperText>}
                                    </FormControl>

                                    <TextField
                                        fullWidth
                                        label="Email du contact"
                                        name="RAI_MAIL"
                                        variant="standard"
                                        value={formData.RAI_MAIL}
                                        onChange={handleChange}
                                        required
                                        error={!!fieldErrors.RAI_MAIL}
                                        helperText={fieldErrors.RAI_MAIL?.[0]}
                                    />

                                    <TextField
                                        fullWidth
                                        label="Téléphone"
                                        name="RAI_PHONE_NUMBER"
                                        variant="standard"
                                        value={formData.RAI_PHONE_NUMBER || ''}
                                        onChange={handleChange}
                                        error={!!fieldErrors.RAI_PHONE_NUMBER}
                                        helperText={fieldErrors.RAI_PHONE_NUMBER?.[0]}
                                    />

                                    <TextField
                                        fullWidth
                                        label="Site Web"
                                        name="RAI_WEB_SITE"
                                        variant="standard"
                                        value={formData.RAI_WEB_SITE || ''}
                                        onChange={handleChange}
                                        error={!!fieldErrors.RAI_WEB_SITE}
                                        helperText={fieldErrors.RAI_WEB_SITE?.[0]}
                                    />

                                    <TextField
                                        fullWidth
                                        label="lien image"
                                        name="RAI_IMAGE"
                                        variant="standard"
                                        value={formData.RAI_IMAGE || ''}
                                        onChange={handleChange}
                                        error={!!fieldErrors.RAI_IMAGE}
                                        helperText={fieldErrors.RAI_IMAGE?.[0]}
                                    />

                                    <TextField
                                        fullWidth
                                        label="Nombre de courses"
                                        name="RAI_NB_RACES"
                                        type="number"
                                        variant="standard"
                                        value={formData.RAI_NB_RACES}
                                        onChange={handleChange}
                                        required
                                        slotProps={{
                                            htmlInput: { min: 1 }
                                        }}
                                        error={!!fieldErrors.RAI_NB_RACES}
                                        helperText={fieldErrors.RAI_NB_RACES?.[0]}
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
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_START: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : null })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: fieldErrors.RAI_REGISTRATION_START?.[0] || "À partir d'aujourd'hui",
                                                    error: !!fieldErrors.RAI_REGISTRATION_START
                                                }
                                            }}
                                            minDate={dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                        <DatePicker
                                            label="Fin inscriptions"
                                            value={formData.RAI_REGISTRATION_END ? dayjs(formData.RAI_REGISTRATION_END) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_REGISTRATION_END: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : null })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: fieldErrors.RAI_REGISTRATION_END?.[0] || "Après le début des inscriptions",
                                                    error: !!fieldErrors.RAI_REGISTRATION_END
                                                }
                                            }}
                                            minDate={formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START).add(1, 'day') : dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                    </Stack>

                                    <Typography variant="h6">Période du Raid</Typography>
                                    <Stack direction="row" spacing={4}>
                                        <DatePicker
                                            label="Date de début du raid"
                                            value={formData.RAI_TIME_START ? dayjs(formData.RAI_TIME_START) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_START: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : null })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: fieldErrors.RAI_TIME_START?.[0] || "5 jours après la fin des inscriptions",
                                                    error: !!fieldErrors.RAI_TIME_START
                                                }
                                            }}
                                            minDate={formData.RAI_REGISTRATION_END ? dayjs(formData.RAI_REGISTRATION_END).add(6, 'day') : (formData.RAI_REGISTRATION_START ? dayjs(formData.RAI_REGISTRATION_START).add(1, 'day') : dayjs())}
                                            format="DD/MM/YYYY"
                                        />
                                        <DatePicker
                                            label="Date de fin du raid"
                                            value={formData.RAI_TIME_END ? dayjs(formData.RAI_TIME_END) : null}
                                            onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAI_TIME_END: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : null })}
                                            slotProps={{
                                                textField: {
                                                    variant: 'standard',
                                                    fullWidth: true,
                                                    helperText: fieldErrors.RAI_TIME_END?.[0] || "Après le début du raid",
                                                    error: !!fieldErrors.RAI_TIME_END
                                                }
                                            }}
                                            minDate={formData.RAI_TIME_START ? dayjs(formData.RAI_TIME_START).add(1, 'day') : dayjs()}
                                            format="DD/MM/YYYY"
                                        />
                                    </Stack>
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
                                                error={!!fieldErrors.ADD_CITY}
                                                helperText={fieldErrors.ADD_CITY?.[0]}
                                            />
                                            <TextField
                                                label="Code Postal"
                                                name="ADD_POSTAL_CODE"
                                                variant="standard"
                                                value={addressData.ADD_POSTAL_CODE}
                                                onChange={handleAddressChange}
                                                fullWidth
                                                required
                                                error={!!fieldErrors.ADD_POSTAL_CODE}
                                                helperText={fieldErrors.ADD_POSTAL_CODE?.[0]}
                                            />
                                        </Stack>
                                        <Stack direction="row" spacing={2} sx={{ mt: 1 }}>
                                            <TextField
                                                label="N°"
                                                name="ADD_STREET_NUMBER"
                                                variant="standard"
                                                value={addressData.ADD_STREET_NUMBER || ''}
                                                onChange={handleAddressChange}
                                                sx={{ width: '100px' }}
                                                error={!!fieldErrors.ADD_STREET_NUMBER}
                                                helperText={fieldErrors.ADD_STREET_NUMBER?.[0]}
                                            />
                                            <TextField
                                                label="Rue"
                                                name="ADD_STREET_NAME"
                                                variant="standard"
                                                value={addressData.ADD_STREET_NAME || ''}
                                                onChange={handleAddressChange}
                                                fullWidth
                                                error={!!fieldErrors.ADD_STREET_NAME}
                                                helperText={fieldErrors.ADD_STREET_NAME?.[0]}
                                            />
                                        </Stack>
                                    </Box>
                                </Stack>

                                <Box sx={{ display: 'flex', justifyContent: 'flex-end', gap: 2, mt: 8 }}>
                                    <Button
                                        variant="outlined"
                                        onClick={() => navigate(`/raids/${id}`)}
                                        sx={{
                                            px: 4,
                                            py: 1.5,
                                            borderRadius: 1,
                                            fontWeight: 'bold'
                                        }}
                                    >
                                        ANNULER
                                    </Button>
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
                                        ENREGISTRER
                                    </Button>
                                </Box>
                            </Grid>

                        </Grid>
                    </LocalizationProvider>
                </Box>
            </Paper >

            {/* Delete Confirmation Dialog */}
            <Dialog open={deleteDialogOpen} onClose={() => setDeleteDialogOpen(false)}>
                <DialogTitle sx={{ fontWeight: 'bold' }}>Confirmer la suppression</DialogTitle>
                <DialogContent>
                    <Typography>
                        Êtes-vous sûr de vouloir supprimer ce raid ? Cette action est irréversible.
                    </Typography>
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setDeleteDialogOpen(false)} color="primary">
                        Annuler
                    </Button>
                    <Button onClick={handleDeleteConfirm} color="error" variant="contained">
                        Supprimer
                    </Button>
                </DialogActions>
            </Dialog>
        </Box >
    );
};

export default EditRaid;
