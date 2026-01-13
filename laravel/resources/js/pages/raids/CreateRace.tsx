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
  Stack,
  Checkbox,
  FormControlLabel
} from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { createRace } from '../../api/race';
import type { RaceCreation } from '../../model/domain/raceModel';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { TimePicker } from '@mui/x-date-pickers/TimePicker';
import dayjs, { Dayjs } from 'dayjs';

const CreateRace = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState<RaceCreation>({
    name: '',
    manager: '',
    isCompetitive: true,
    duration: '',
    difficulty: '',
    minorPrice: 0,
    majorPrice: 0,
    minParticipants: 0,
    illustration: '',
    startDate: '',
    startTime: '',
    endDate: '',
    endTime: ''
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name as string]: value
    }));
  };

  const handleSelectChange = (e: any) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value
    }));
  };

  const handleCompetionChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const isComp = event.target.name === 'competition';
    setFormData(prev => ({ ...prev, isCompetitive: isComp }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await createRace(formData);
      // navigate('/races'); // Route doesn't exist yet, navigating to raids or dashboard generic
      alert("Course créée avec succès !");
      navigate('/');
    } catch (error) {
      console.error('Error creating race:', error);
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
        CREATION D'UNE COURSE
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
          RAID - Le sanglier fou
        </Typography>

        <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
          {/* Nom de la course */}
          <TextField
            fullWidth
            label="Nom de la course"
            name="name"
            variant="standard"
            value={formData.name}
            onChange={handleChange}
            margin="normal"
            required
            placeholder="Course de Grimbosq"
          />

          {/* Responsable + Compétition/Loisir */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2, alignItems: 'flex-end' }}>
            <FormControl fullWidth variant="standard" margin="normal">
              <InputLabel shrink>Responsable de la course</InputLabel>
              <Select
                value={formData.manager}
                onChange={handleSelectChange}
                name="manager"
                label="Responsable de la course"
                displayEmpty
              >
                <MenuItem value="" disabled>Sélectionner</MenuItem>
                <MenuItem value="Christelle M.">Christelle M.</MenuItem>
                <MenuItem value="Other">Autre</MenuItem>
              </Select>
            </FormControl>

            <Stack direction="row" spacing={2} sx={{ mb: 1, minWidth: '300px' }}>
              <FormControlLabel
                control={
                  <Checkbox
                    checked={formData.isCompetitive}
                    onChange={handleCompetionChange}
                    name="competition"
                    color="success"
                  />
                }
                label="Compétition"
              />
              <FormControlLabel
                control={
                  <Checkbox
                    checked={!formData.isCompetitive}
                    onChange={handleCompetionChange}
                    name="loisir"
                    color="success"
                  />
                }
                label="Loisir"
              />
            </Stack>
          </Stack>

          {/* Durée + Difficulté */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Durée"
              name="duration"
              variant="standard"
              value={formData.duration}
              onChange={handleChange}
              margin="normal"
              placeholder="2h"
            />
            <FormControl fullWidth variant="standard" margin="normal">
              <InputLabel shrink>Difficulté</InputLabel>
              <Select
                value={formData.difficulty}
                onChange={handleSelectChange}
                name="difficulty"
                label="Difficulté"
                displayEmpty
              >
                <MenuItem value="" disabled>Sélectionner</MenuItem>
                <MenuItem value="Facile">Facile</MenuItem>
                <MenuItem value="Moyen">Moyen</MenuItem>
                <MenuItem value="Difficile">Difficile</MenuItem>
              </Select>
            </FormControl>
          </Stack>

          {/* Prix Mineur + Prix Majeur */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Prix mineur"
              name="minorPrice"
              type="number"
              variant="standard"
              value={formData.minorPrice}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Prix majeur"
              name="majorPrice"
              type="number"
              variant="standard"
              value={formData.majorPrice}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>

          {/* Nb Participants + Illustration */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Nombre de participant minimum"
              name="minParticipants"
              type="number"
              variant="standard"
              value={formData.minParticipants}
              onChange={handleChange}
              margin="normal"
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
          </Stack>

          {/* Start Date + Time */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <DatePicker
              label="Date de début"
              value={formData.startDate ? dayjs(formData.startDate) : null}
              onChange={(newValue: Dayjs | null) => setFormData({ ...formData, startDate: newValue ? newValue.format('YYYY-MM-DD') : '' })}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de départ"
              value={formData.startTime ? dayjs(formData.startTime, 'HH:mm') : null}
              onChange={(newValue: Dayjs | null) => setFormData({ ...formData, startTime: newValue ? newValue.format('HH:mm') : '' })}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
          </Stack>

          {/* End Date + Time */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 4 }}>
            <DatePicker
              label="Date de fin"
              value={formData.endDate ? dayjs(formData.endDate) : null}
              onChange={(newValue: Dayjs | null) => setFormData({ ...formData, endDate: newValue ? newValue.format('YYYY-MM-DD') : '' })}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de fin"
              value={formData.endTime ? dayjs(formData.endTime, 'HH:mm') : null}
              onChange={(newValue: Dayjs | null) => setFormData({ ...formData, endTime: newValue ? newValue.format('HH:mm') : '' })}
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

export default CreateRace;
