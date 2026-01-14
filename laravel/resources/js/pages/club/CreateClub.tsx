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
import { useNavigate } from 'react-router-dom';
import type { ClubCreation } from '../../models/club.model';
import type { User } from '../../models';
import { useUser } from '../../contexts/userContext';
import { getListOfUsers } from '../../api/user';

const CreateClub = () => {
  const navigate = useNavigate();

  const { user } = useUser();

  const [formData, setFormData] = useState<ClubCreation>({
    CLU_NAME: '',
    USE_ID: 0,
    ADD_STREET_NUMBER: '',
    ADD_STREET_NAME: '',
    ADD_POSTAL_CODE: '',
    ADD_CITY: ''
  });

    const [users, setUsers] = useState<User[]>([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const fetchUsers = async () => {
      try {
        const fetchedUsers = await getListOfUsers();
        setUsers(fetchedUsers);
      } catch (error) {
        console.error('Erreur lors du chargement des utilisateurs:', error);
      }
    };
    fetchUsers();
  }, []);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
    const { name, value } = e.target;
    setFormData((prev: any) => ({
      ...prev,
      [name as string]: value
    }));
  };

  const handleSelectChange = (e: any) => {
    const { name, value } = e.target;
    setFormData((prev: any) => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!formData.CLU_NAME || !formData.USE_ID || !formData.ADR_STREET_NAME || !formData.ADR_CITY) {
      alert('Veuillez remplir tous les champs obligatoires');
      return;
    }

    try {
      const response = await fetch('/api/clubs', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      if (response.ok) {
        alert('Club créé avec succès !');
        navigate('/clubs');
      } else {
        alert('Erreur lors de la création du club');
      }
    } catch (error) {
      console.error('Error creating club:', error);
      alert('Erreur lors de la création du club');
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
        component="h1"
        sx={{
          color: 'white',
          fontWeight: 'bold',
          textTransform: 'uppercase',
          textAlign: 'center',
          mb: 4,
          fontFamily: '"Archivo Black", sans-serif'
        }}
      >
        CRÉATION D'UN CLUB
      </Typography>

      <Paper
        elevation={3}
        sx={{
          p: 6,
          width: '100%',
          maxWidth: 600,
          borderRadius: 4,
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center'
        }}
      >
        <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
          {/* Nom du club */}
          <TextField
            fullWidth
            label="Nom du club"
            name="CLU_NAME"
            variant="standard"
            value={formData.CLU_NAME}
            onChange={handleChange}
            margin="normal"
            required
            placeholder="Ex: Club des Explorateurs"
          />

          {/* Responsable du club */}
          <FormControl fullWidth variant="standard" margin="normal" required>
            <InputLabel shrink>Responsable du club</InputLabel>
            <Select
              value={formData.USE_ID || ''}
              onChange={handleSelectChange}
              name="USE_ID"
              label="Responsable du club"
              displayEmpty
            >
              <MenuItem value="" disabled>
                Sélectionner un responsable
              </MenuItem>
              {users.map((user) => (
                <MenuItem key={user.USE_ID} value={user.USE_ID}>
                  {user.USE_NAME}
                </MenuItem>
              ))}
            </Select>
          </FormControl>

          {/* Adresse - Section */}
          <Typography
            variant="h6"
            sx={{
              mt: 4,
              mb: 2,
              fontWeight: 'bold',
              textTransform: 'uppercase'
            }}
          >
            Adresse du club
          </Typography>

          {/* Code rue */}
          <TextField
            fullWidth
            label="Code de la rue"
            name="ADR_STREET_CODE"
            variant="standard"
            value={formData.ADR_STREET_CODE}
            onChange={handleChange}
            margin="normal"
            placeholder="Ex: 123"
          />

          {/* Nom de la rue */}
          <TextField
            fullWidth
            label="Nom de la rue"
            name="ADR_STREET_NAME"
            variant="standard"
            value={formData.ADR_STREET_NAME}
            onChange={handleChange}
            margin="normal"
            required
            placeholder="Ex: Rue de la Paix"
          />

          {/* Ville */}
          <TextField
            fullWidth
            label="Ville"
            name="ADR_CITY"
            variant="standard"
            value={formData.ADR_CITY}
            onChange={handleChange}
            margin="normal"
            required
            placeholder="Ex: Lyon"
          />

          {/* Boutons */}
          <Stack direction="row" spacing={2} sx={{ mt: 6, justifyContent: 'flex-end' }}>
            <Button
              variant="outlined"
              color="inherit"
              onClick={() => navigate(-1)}
              sx={{ px: 4 }}
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
                '&:hover': {
                  bgcolor: '#144a19'
                }
              }}
            >
              CRÉER
            </Button>
          </Stack>
        </Box>
      </Paper>
    </Box>
  );
};

export default CreateClub;
