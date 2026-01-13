import React, { useState } from 'react';
import {
  Box,
  Container,
  Paper,
  TextField,
  Button,
  FormControlLabel,
  Radio,
  RadioGroup,
  Select,
  MenuItem,
  FormControl,
  Typography,
} from '@mui/material';
import { styled } from '@mui/material/styles';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import dayjs from 'dayjs';

const PageContainer = styled(Box)(({ theme }) => ({
  minHeight: '100vh',
  backgroundColor: theme.palette.mode === 'dark' ? '#1B3022' : '#1B3022',
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
  padding: theme.spacing(2),
}));

const FormPaper = styled(Paper)(({ theme }) => ({
  padding: theme.spacing(4),
  borderRadius: theme.spacing(2),
  boxShadow: '0 4px 20px rgba(0, 0, 0, 0.1)',
  maxWidth: 650,
  width: '100%',
  backgroundColor: '#ffffff',
}));

const PageTitle = styled(Typography)(({ theme }) => ({
  fontSize: '2.5rem',
  fontWeight: 'bold',
  textAlign: 'center',
  marginBottom: theme.spacing(4),
  color: '#ffffff',
}));

const SectionTitle = styled(Typography)({
  fontSize: '0.875rem',
  color: '#666666',
  marginBottom: '4px',
  fontWeight: 500,
});

const StyledTextField = styled(TextField)({
  '& .MuiInput-underline:before': {
    borderBottomColor: '#e0e0e0',
  },
  '& .MuiInput-underline:hover:before': {
    borderBottomColor: '#000000',
  },
  '& .MuiInput-input': {
    fontSize: '1rem',
    padding: '8px 0',
  },
});

const RadioContainer = styled(RadioGroup)({
  display: 'flex',
  flexDirection: 'row',
  gap: '2rem',
});


const ValidateButton = styled(Button)({
  backgroundColor: '#2d6a3f',
  color: '#ffffff',
  fontSize: '1rem',
  fontWeight: 'bold',
  padding: '12px',
  marginTop: '2rem',
  width: '100%',
  '&:hover': {
    backgroundColor: '#1f4a2a',
  },
});

export default function CreateCourse() {
  const [formData, setFormData] = useState({
    responsible: '',
    minPrice: '',
    maxPrice: '',
    minParticipants: '',
    difficulty: '',
    startDate: '',
    startTime: dayjs(),
    endDate: '',
    endTime: dayjs(),
    courseType: 'competition',
  });

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSelectChange = (e: any) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleCourseTypeChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData(prev => ({
      ...prev,
      courseType: e.target.value,
    }));
  };

  const isFormValid = () => {
    return (
      formData.responsible &&
      formData.minPrice &&
      formData.maxPrice &&
      formData.minParticipants &&
      formData.difficulty &&
      formData.startDate &&
      formData.endDate
    );
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!isFormValid()) {
      alert('Tous les champs sont obligatoires');
      return;
    }

    const courseData = {
      responsible: formData.responsible,
      minPrice: parseFloat(formData.minPrice),
      maxPrice: parseFloat(formData.maxPrice),
      minParticipants: parseInt(formData.minParticipants),
      difficulty: formData.difficulty,
      startDate: formData.startDate,
      startTime: formData.startTime.format('HH:mm'),
      endDate: formData.endDate,
      endTime: formData.endTime.format('HH:mm'),
      courseType: formData.courseType,
    };

    try {
      // Créer le fichier JSON dans src/model/db/race.ts
      const raceContent = `export const races = ${JSON.stringify([courseData], null, 2)};`;
      
      // Pour le développement, on simule la sauvegarde
      console.log('Course créée:', courseData);
      alert('Course créée avec succès!');
      
      // Réinitialiser le formulaire
      setFormData({
        responsible: '',
        minPrice: '',
        maxPrice: '',
        minParticipants: '',
        difficulty: '',
        startDate: '',
        startTime: dayjs(),
        endDate: '',
        endTime: dayjs(),
        courseType: 'competition',
      });
    } catch (error) {
      console.error('Erreur lors de la création de la course:', error);
      alert('Erreur lors de la création de la course');
    }
  };

  return (
    <PageContainer>
      <Box sx={{ width: '100%' }}>
        <PageTitle>CREATION D'UNE COURSE</PageTitle>
        
        <Container maxWidth="sm">
          <FormPaper component="form" onSubmit={handleSubmit}>
            {/* Header */}
            <Typography sx={{ textAlign: 'center', fontWeight: 'bold', marginBottom: 3 }}>
              RAID - Le sanglier fou
            </Typography>

            {/* Responsable + Radio Buttons */}
            <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 2.5, gap: 2 }}>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>Responsable de la course</SectionTitle>
                <FormControl fullWidth size="small" required>
                  <Select
                    name="responsible"
                    value={formData.responsible}
                    onChange={handleSelectChange}
                    variant="standard"
                  >
                    <MenuItem value="">
                      <em>Sélectionner</em>
                    </MenuItem>
                    <MenuItem value="person1">Personne 1</MenuItem>
                    <MenuItem value="person2">Personne 2</MenuItem>
                  </Select>
                </FormControl>
              </Box>
              <Box sx={{ flex: 1 }}>
                <RadioContainer
                  name="courseType"
                  value={formData.courseType}
                  onChange={handleCourseTypeChange}
                >
                  <FormControlLabel
                    value="competition"
                    control={<Radio size="small" />}
                    label={<Typography sx={{ fontSize: '0.875rem' }}>Compétition</Typography>}
                  />
                  <FormControlLabel
                    value="loisir"
                    control={<Radio size="small" />}
                    label={<Typography sx={{ fontSize: '0.875rem' }}>Loisir</Typography>}
                  />
                </RadioContainer>
              </Box>
            </Box>

            {/* Difficulté */}
            <Box sx={{ marginBottom: 2.5 }}>
              <SectionTitle>difficulté</SectionTitle>
              <FormControl fullWidth size="small" required>
                <Select
                  name="difficulty"
                  value={formData.difficulty}
                  onChange={handleSelectChange}
                  variant="standard"
                >
                  <MenuItem value="">
                    <em>Sélectionner</em>
                  </MenuItem>
                  <MenuItem value="facile">Facile</MenuItem>
                  <MenuItem value="moyen">Moyen</MenuItem>
                  <MenuItem value="difficile">Difficile</MenuItem>
                </Select>
              </FormControl>
            </Box>

            {/* Prix mineur + Prix majeur */}
            <Box sx={{ display: 'flex', gap: 3, marginBottom: 2.5 }}>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>prix mineur</SectionTitle>
                <StyledTextField
                  fullWidth
                  name="minPrice"
                  value={formData.minPrice}
                  onChange={handleInputChange}
                  variant="standard"
                  type="number"
                  required
                />
              </Box>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>prix majeur</SectionTitle>
                <StyledTextField
                  fullWidth
                  name="maxPrice"
                  value={formData.maxPrice}
                  onChange={handleInputChange}
                  variant="standard"
                  type="number"
                  required
                />
              </Box>
            </Box>

            {/* Nombre de participants minimum */}
            <Box sx={{ marginBottom: 2.5 }}>
              <SectionTitle>nombre de participant minimum</SectionTitle>
              <StyledTextField
                fullWidth
                name="minParticipants"
                value={formData.minParticipants}
                onChange={handleInputChange}
                variant="standard"
                type="number"
                required
              />
            </Box>

            {/* Dates et heures */}
            <Box sx={{ display: 'flex', gap: 3, marginBottom: 2.5 }}>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>Date de début</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="date"
                    name="startDate"
                    value={formData.startDate}
                    onChange={handleInputChange}
                    variant="standard"
                    required
                    InputLabelProps={{ shrink: true }}
                  />
                </Box>
              </Box>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>heure de départ</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="time"
                    name="startTime"
                    value={formData.startTime.format('HH:mm')}
                    onChange={(e) => {
                      const [hours, minutes] = e.target.value.split(':');
                      setFormData(prev => ({
                        ...prev,
                        startTime: prev.startTime.set('hour', parseInt(hours)).set('minute', parseInt(minutes)),
                      }));
                    }}
                    variant="standard"
                    InputProps={{
                      endAdornment: <AccessTimeIcon sx={{ ml: 1, color: '#999' }} />,
                    }}
                  />
                </Box>
              </Box>
            </Box>

            <Box sx={{ display: 'flex', gap: 3, marginBottom: 2 }}>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>Date de fin</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="date"
                    name="endDate"
                    value={formData.endDate}
                    onChange={handleInputChange}
                    variant="standard"
                    required
                    InputLabelProps={{ shrink: true }}
                  />
                </Box>
              </Box>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>heure de fin</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="time"
                    name="endTime"
                    value={formData.endTime.format('HH:mm')}
                    onChange={(e) => {
                      const [hours, minutes] = e.target.value.split(':');
                      setFormData(prev => ({
                        ...prev,
                        endTime: prev.endTime.set('hour', parseInt(hours)).set('minute', parseInt(minutes)),
                      }));
                    }}
                    variant="standard"
                    InputProps={{
                      endAdornment: <AccessTimeIcon sx={{ ml: 1, color: '#999' }} />,
                    }}
                  />
                </Box>
              </Box>
            </Box>

            {/* Submit Button */}
            <ValidateButton type="submit" variant="contained">
              VALIDER
            </ValidateButton>
          </FormPaper>
        </Container>
      </Box>
    </PageContainer>
  );
}
