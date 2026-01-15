import React, { useState, useEffect } from 'react';
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    TextField,
    MenuItem,
    Stack
} from '@mui/material';
import type { Club } from '../../models/club.model';
import type { User } from '../../models/user.model';
import { createClubWithAddress, updateClub } from '../../api/club';
import { useAlert } from '../../contexts/AlertContext';

interface ClubFormModalProps {
    open: boolean;
    onClose: () => void;
    onSuccess: () => void;
    club: Club | null;
    users: User[];
}

const ClubFormModal = ({ open, onClose, onSuccess, club, users }: ClubFormModalProps) => {
    const { showAlert } = useAlert();
    const [name, setName] = useState('');
    const [managerId, setManagerId] = useState<number | ''>('');
    const [city, setCity] = useState('');
    const [postalCode, setPostalCode] = useState('');
    const [streetName, setStreetName] = useState('');
    const [streetNumber, setStreetNumber] = useState('');
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (club) {
            setName(club.CLU_NAME);
            setManagerId(club.USE_ID);
            setCity(club.address?.ADD_CITY || '');
            setPostalCode(club.address?.ADD_POSTAL_CODE || '');
            setStreetName(club.address?.ADD_STREET_NAME || '');
            setStreetNumber(club.address?.ADD_STREET_NUMBER || '');
        } else {
            setName('');
            setManagerId('');
            setCity('');
            setPostalCode('');
            setStreetName('');
            setStreetNumber('');
        }
    }, [club, open]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);

        const clubData = {
            CLU_NAME: name,
            USE_ID: managerId,
            ADD_CITY: city,
            ADD_POSTAL_CODE: postalCode,
            ADD_STREET_NAME: streetName,
            ADD_STREET_NUMBER: streetNumber
        };

        try {
            if (club) {
                const updateData = {
                    CLU_NAME: name,
                    USE_ID: managerId,
                    ADD_CITY: city,
                    ADD_POSTAL_CODE: postalCode,
                    ADD_STREET_NAME: streetName,
                    ADD_STREET_NUMBER: streetNumber
                };
                await updateClub(club.CLU_ID, updateData);
                showAlert('Club modifié avec succès', 'success');
            } else {
                await createClubWithAddress(clubData);
                showAlert('Club créé avec succès', 'success');
            }
            onSuccess();
            onClose();
        } catch (error) {
            console.error("Error saving club", error);
            showAlert('Erreur lors de l\'enregistrement du club', 'error');
        } finally {
            setLoading(false);
        }
    };

    return (
        <Dialog open={open} onClose={onClose} maxWidth="sm" fullWidth>
            <DialogTitle>{club ? 'Modifier le Club' : 'Créer un Club'}</DialogTitle>
            <form onSubmit={handleSubmit}>
                <DialogContent>
                    <Stack spacing={2}>
                        <TextField
                            label="Nom du Club"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            fullWidth
                            required
                        />
                        <TextField
                            select
                            label="Responsable"
                            value={managerId}
                            onChange={(e) => setManagerId(Number(e.target.value))}
                            fullWidth
                            required
                        >
                            {users.filter(user =>
                                !user.club || (club && user.club.CLU_ID === club.CLU_ID)
                            ).map((user) => (
                                <MenuItem key={user.USE_ID} value={user.USE_ID}>
                                    {user.USE_NAME} {user.USE_LAST_NAME}
                                </MenuItem>
                            ))}
                        </TextField>

                        <Stack direction="row" spacing={2}>
                            <TextField
                                label="Ville"
                                value={city}
                                onChange={(e) => setCity(e.target.value)}
                                fullWidth
                                required={!club}
                            />
                            <TextField
                                label="Code Postal"
                                value={postalCode}
                                onChange={(e) => setPostalCode(e.target.value)}
                                fullWidth
                                required={!club}
                            />
                        </Stack>
                        <Stack direction="row" spacing={2}>
                            <TextField
                                label="Rue"
                                value={streetName}
                                onChange={(e) => setStreetName(e.target.value)}
                                fullWidth
                            />
                            <TextField
                                label="Numéro"
                                value={streetNumber}
                                onChange={(e) => setStreetNumber(e.target.value)}
                                fullWidth
                            />
                        </Stack>
                    </Stack>
                </DialogContent>
                <DialogActions>
                    <Button onClick={onClose}>Annuler</Button>
                    <Button type="submit" variant="contained" disabled={loading}>
                        {club ? 'Enregistrer' : 'Créer'}
                    </Button>
                </DialogActions>
            </form>
        </Dialog>
    );
};

export default ClubFormModal;
