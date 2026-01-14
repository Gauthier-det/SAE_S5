import React, { useEffect, useState } from 'react';
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
import { useNavigate, useSearchParams } from 'react-router-dom';
import { createRace } from '../../api/race';
import { getRaidById } from '../../api/raid';
import type { Raid } from '../../models/raid.model';
import type { RaceCreation } from '../../models/race.model';
import type { RaceCategory } from '../../models/category.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { TimePicker } from '@mui/x-date-pickers/TimePicker';
import dayjs, { Dayjs } from 'dayjs';

const CreateRace = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [raid, setRaid] = useState<Raid | null>(null);
  // Prix par catégories pour SAN_CATEGORIES_RACES (labels statiques en DB)
  const [priceData, setPriceData] = useState<{ minor: number; major: number; licensed: number }>({
    minor: 0,
    major: 0,
    licensed: 0,
  });


  const [formData, setFormData] = useState<RaceCreation>({
    RAI_ID: 0,
    RAC_TIME_START: '',
    RAC_TIME_END: '',
    RAC_TYPE: 'Compétitif',
    RAC_DIFFICULTY: 'Moyen',
    RAC_MIN_PARTICIPANTS: 0,
    RAC_MAX_PARTICIPANTS: 0,
    RAC_MIN_TEAMS: 0,
    RAC_MAX_TEAMS: 0,
    RAC_TEAM_MEMBERS: 0,
    RAC_AGE_MIN: 0,
    RAC_AGE_MIDDLE: 0,
    RAC_AGE_MAX: 0
  });

  

  // états locaux pour les sélecteurs date/heure
  const [startDate, setStartDate] = useState<string>('');
  const [startTime, setStartTime] = useState<string>('');
  const [endDate, setEndDate] = useState<string>('');
  const [endTime, setEndTime] = useState<string>('');

  // Pré-remplit le raid depuis l'URL (?raidId=123)
  useEffect(() => {
    const ridParam = searchParams.get('raidId');
    const rid = ridParam ? Number(ridParam) : 0;
    if (rid && !Number.isNaN(rid)) {
      setFormData(prev => ({ ...prev, RAI_ID: rid }));
    }
  }, [searchParams]);

  // Charge les infos du raid pour affichage
  useEffect(() => {
    if (formData.RAI_ID && !Number.isNaN(formData.RAI_ID)) {
      getRaidById(formData.RAI_ID)
        .then(setRaid)
        .catch(() => setRaid(null));
    }
  }, [formData.RAI_ID]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    const numericFields = new Set([
      'RAI_ID', 'RAC_MIN_PARTICIPANTS', 'RAC_MAX_PARTICIPANTS', 'RAC_MIN_TEAMS', 'RAC_MAX_TEAMS',
      'RAC_TEAM_MEMBERS', 'RAC_AGE_MIN', 'RAC_AGE_MIDDLE', 'RAC_AGE_MAX'
    ]);
    setFormData((prev) => ({
      ...prev,
      [name]: numericFields.has(name) ? Number(value) : value
    }));
  };

  const handleSelectChange = (e: any) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value
    }));
  };

  const handlePriceChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setPriceData(prev => ({
      ...prev,
      [name]: Number(value)
    }));
  };

  // plus de isCompetitive : on utilise directement RAC_TYPE ('Compétitif' ou 'Loisir')

  const combineDT = (d?: string, t?: string) => {
    if (!d || !t) return '';
    return `${d} ${t}:00`;
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const payload: RaceCreation = {
        ...formData,
        RAC_TIME_START: combineDT(startDate, startTime),
        RAC_TIME_END: combineDT(endDate, endTime),
        prices: priceData
      };
      await createRace(payload);
      alert('Course créée avec succès !');
      navigate(`/raids/${formData.RAI_ID}`);
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
        <Typography component="h2" variant="h6" sx={{ mb: 1, fontWeight: 'bold', textTransform: 'uppercase' }}>
          {raid ? `RAID - ${raid.RAI_NAME}` : 'RAID - (sélectionné via la page raid)'}
        </Typography>

        <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
          {/* Type de course */}
          <FormControl fullWidth variant="standard" margin="normal">
            <InputLabel shrink>Type</InputLabel>
            <Select
              value={formData.RAC_TYPE}
              onChange={handleSelectChange}
              name="RAC_TYPE"
              label="Type"
              displayEmpty
            >
              <MenuItem value={''} disabled>Sélectionner</MenuItem>
              <MenuItem value={'Compétitif'}>Compétitif</MenuItem>
              <MenuItem value={'Loisir'}>Loisir</MenuItem>
            </Select>
          </FormControl>

          {/* Difficulté */}
          <FormControl fullWidth variant="standard" margin="normal">
            <InputLabel shrink>Difficulté</InputLabel>
            <Select
              value={formData.RAC_DIFFICULTY}
              onChange={handleSelectChange}
              name="RAC_DIFFICULTY"
              label="Difficulté"
              displayEmpty
            >
              <MenuItem value="" disabled>Sélectionner</MenuItem>
              <MenuItem value="Facile">Facile</MenuItem>
              <MenuItem value="Moyen">Moyen</MenuItem>
              <MenuItem value="Difficile">Difficile</MenuItem>
            </Select>
          </FormControl>

          {/* Participants & Équipes */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Participants min"
              name="RAC_MIN_PARTICIPANTS"
              type="number"
              variant="standard"
              value={formData.RAC_MIN_PARTICIPANTS}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Participants max"
              name="RAC_MAX_PARTICIPANTS"
              type="number"
              variant="standard"
              value={formData.RAC_MAX_PARTICIPANTS}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>

          {/* Prix (catégories) */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Prix mineur"
              name="minor"
              type="number"
              variant="standard"
              value={priceData.minor}
              onChange={handlePriceChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Prix majeur non licencié"
              name="major"
              type="number"
              variant="standard"
              value={priceData.major}
              onChange={handlePriceChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Prix licencié"
              name="licensed"
              type="number"
              variant="standard"
              value={priceData.licensed}
              onChange={handlePriceChange}
              margin="normal"
            />
          </Stack>

          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Équipes min"
              name="RAC_MIN_TEAMS"
              type="number"
              variant="standard"
              value={formData.RAC_MIN_TEAMS}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Équipes max"
              name="RAC_MAX_TEAMS"
              type="number"
              variant="standard"
              value={formData.RAC_MAX_TEAMS}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Membres par équipe"
              name="RAC_TEAM_MEMBERS"
              type="number"
              variant="standard"
              value={formData.RAC_TEAM_MEMBERS}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>

          {/* Âges */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Âge min"
              name="RAC_AGE_MIN"
              type="number"
              variant="standard"
              value={formData.RAC_AGE_MIN}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Âge intermédiaire"
              name="RAC_AGE_MIDDLE"
              type="number"
              variant="standard"
              value={formData.RAC_AGE_MIDDLE}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Âge max"
              name="RAC_AGE_MAX"
              type="number"
              variant="standard"
              value={formData.RAC_AGE_MAX}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>

          {/* Début (date + heure) */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <DatePicker
              label="Date de début"
              value={startDate ? dayjs(startDate) : null}
              onChange={(newValue: Dayjs | null) => setStartDate(newValue ? newValue.format('YYYY-MM-DD') : '')}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de départ"
              value={startTime ? dayjs(startTime, 'HH:mm') : null}
              onChange={(newValue: Dayjs | null) => setStartTime(newValue ? newValue.format('HH:mm') : '')}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
          </Stack>

          {/* Fin (date + heure) */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 4 }}>
            <DatePicker
              label="Date de fin"
              value={endDate ? dayjs(endDate) : null}
              onChange={(newValue: Dayjs | null) => setEndDate(newValue ? newValue.format('YYYY-MM-DD') : '')}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de fin"
              value={endTime ? dayjs(endTime, 'HH:mm') : null}
              onChange={(newValue: Dayjs | null) => setEndTime(newValue ? newValue.format('HH:mm') : '')}
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
