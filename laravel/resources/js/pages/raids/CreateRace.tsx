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
import { useAlert } from '../../contexts/AlertContext';
import { createRace } from '../../api/race';
import { RaceType, type RaceCreation } from '../../models/race.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { TimePicker } from '@mui/x-date-pickers/TimePicker';
import dayjs, { Dayjs } from 'dayjs';

const CreateRace = () => {
  const navigate = useNavigate();
  const { showAlert } = useAlert();

  // Temporary state for Date/Time pickers before merging into string
  const [startDate, setStartDate] = useState<Dayjs | null>(null);
  const [startTime, setStartTime] = useState<Dayjs | null>(null);
  const [endDate, setEndDate] = useState<Dayjs | null>(null);
  const [endTime, setEndTime] = useState<Dayjs | null>(null);

  const [formData, setFormData] = useState<RaceCreation>({
    RAI_ID: 1, // TODO: Should be selected or passed via props/URL
    RAC_TIME_START: '',
    RAC_TIME_END: '',
    RAC_TYPE: RaceType.Competitive,
    RAC_DIFFICULTY: 'Moyen',
    RAC_MIN_PARTICIPANTS: 0,
    RAC_MAX_PARTICIPANTS: 0,
    RAC_MIN_TEAMS: 0,
    RAC_MAX_TEAMS: 0,
    RAC_TEAM_MEMBERS: 0,
    RAC_AGE_MIN: 18,
    RAC_AGE_MIDDLE: 30, // Default ?
    RAC_AGE_MAX: 99
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

  const handleCompetitionChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const isComp = event.target.name === 'competition';
    setFormData(prev => ({ ...prev, RAC_TYPE: isComp ? RaceType.Competitive : RaceType.Hobby }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    // Merge dates and times
    let startStr = '';
    if (startDate && startTime) {
      startStr = startDate.format('YYYY-MM-DD') + ' ' + startTime.format('HH:mm:ss');
    }
    let endStr = '';
    if (endDate && endTime) {
      endStr = endDate.format('YYYY-MM-DD') + ' ' + endTime.format('HH:mm:ss');
    }

    const payload = {
      ...formData,
      RAC_TIME_START: startStr,
      RAC_TIME_END: endStr
    };

    try {
      await createRace(payload);
      showAlert("Course créée avec succès !", "success");
      navigate('/raids'); // Redirect to raids list for now
    } catch (e: any) {
      console.error(e);
      showAlert("Erreur lors de la création de la course", "error");
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
          Nouvelle épreuve
        </Typography>

        <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>

          {/* Type */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2, alignItems: 'center' }}>
            <Typography variant="subtitle1">Type d'épreuve :</Typography>
            <Stack direction="row" spacing={2} sx={{ mb: 1 }}>
              <FormControlLabel
                control={
                  <Checkbox
                    checked={formData.RAC_TYPE === RaceType.Competitive}
                    onChange={handleCompetitionChange}
                    name="competition"
                    color="success"
                  />
                }
                label="Compétition"
              />
              <FormControlLabel
                control={
                  <Checkbox
                    checked={formData.RAC_TYPE === RaceType.Hobby}
                    onChange={handleCompetitionChange}
                    name="loisir"
                    color="success"
                  />
                }
                label="Loisir"
              />
            </Stack>
          </Stack>

          {/* Difficulty + Raid ID (placeholder) */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <FormControl fullWidth variant="standard" margin="normal">
              <InputLabel shrink>Difficulté</InputLabel>
              <Select
                value={formData.RAC_DIFFICULTY}
                onChange={handleSelectChange}
                name="RAC_DIFFICULTY"
                label="Difficulté"
                displayEmpty
              >
                <MenuItem value="Facile">Facile</MenuItem>
                <MenuItem value="Moyen">Moyen</MenuItem>
                <MenuItem value="Difficile">Difficile</MenuItem>
              </Select>
            </FormControl>
            <TextField
              fullWidth
              label="ID du Raid associé"
              name="RAI_ID"
              type="number"
              variant="standard"
              value={formData.RAI_ID}
              onChange={handleChange}
              margin="normal"
              helperText="ID du raid (temporaire)"
            />
          </Stack>


          {/* Participants */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Nb. Min Participants"
              name="RAC_MIN_PARTICIPANTS"
              type="number"
              variant="standard"
              value={formData.RAC_MIN_PARTICIPANTS}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Nb. Max Participants"
              name="RAC_MAX_PARTICIPANTS"
              type="number"
              variant="standard"
              value={formData.RAC_MAX_PARTICIPANTS}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>

          {/* Teams */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Nb. Min Équipes"
              name="RAC_MIN_TEAMS"
              type="number"
              variant="standard"
              value={formData.RAC_MIN_TEAMS}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Nb. Max Équipes"
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

          {/* Age */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Age Min"
              name="RAC_AGE_MIN"
              type="number"
              variant="standard"
              value={formData.RAC_AGE_MIN}
              onChange={handleChange}
              margin="normal"
            />
            <TextField
              fullWidth
              label="Age Max"
              name="RAC_AGE_MAX"
              type="number"
              variant="standard"
              value={formData.RAC_AGE_MAX}
              onChange={handleChange}
              margin="normal"
            />
          </Stack>


          {/* Start Date + Time */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 2 }}>
            <DatePicker
              label="Date de début"
              value={startDate}
              onChange={(newValue) => setStartDate(newValue)}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de départ"
              value={startTime}
              onChange={(newValue) => setStartTime(newValue)}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
          </Stack>

          {/* End Date + Time */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={4} sx={{ mt: 4 }}>
            <DatePicker
              label="Date de fin"
              value={endDate}
              onChange={(newValue) => setEndDate(newValue)}
              slotProps={{ textField: { variant: 'standard', fullWidth: true } }}
            />
            <TimePicker
              label="Heure de fin"
              value={endTime}
              onChange={(newValue) => setEndTime(newValue)}
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
