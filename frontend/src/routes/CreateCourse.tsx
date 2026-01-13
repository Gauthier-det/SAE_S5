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
  Grid,
  Popper,
} from '@mui/material';
import { styled } from '@mui/material/styles';
import CalendarTodayIcon from '@mui/icons-material/CalendarToday';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import { TimeClock } from '@mui/x-date-pickers/TimeClock';

const PageContainer = styled(Box)(({ theme }) => ({
  minHeight: '100vh',
  backgroundColor: theme.palette.mode === 'dark' ? '#1a3a2e' : '#f5f5f5',
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
  color: '#000000',
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

const CheckboxContainer = styled(Box)({
  display: 'flex',
  gap: '2rem',
  margin: '1.5rem 0',
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
    name: 'course durr burger',
    responsible: '',
    duration: '2h',
    minPrice: '69',
    maxPrice: '420',
    minParticipants: '67',
    illustration: 'course.png',
    difficulty: 'moyen',
    startDate: '',
    startTime: null as Date | null,
    endDate: '',
    endTime: null as Date | null,
    courseType: 'competition',
  });

  const [startTimeAnchor, setStartTimeAnchor] = useState<HTMLButtonElement | null>(null);
  const [endTimeAnchor, setEndTimeAnchor] = useState<HTMLButtonElement | null>(null);

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

  const handleStartTimeClick = (event: React.MouseEvent<HTMLButtonElement>) => {
    setStartTimeAnchor(event.currentTarget);
  };

  const handleEndTimeClick = (event: React.MouseEvent<HTMLButtonElement>) => {
    setEndTimeAnchor(event.currentTarget);
  };

  const handleStartTimeChange = (time: Date | null) => {
    setFormData(prev => ({
      ...prev,
      startTime: time,
    }));
    setStartTimeAnchor(null);
  };

  const handleEndTimeChange = (time: Date | null) => {
    setFormData(prev => ({
      ...prev,
      endTime: time,
    }));
    setEndTimeAnchor(null);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log('Form submitted:', formData);
    // TODO: Send formData to backend
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

            {/* Nom de la course */}
            <Box sx={{ marginBottom: 2.5 }}>
              <SectionTitle>Nom de la course</SectionTitle>
              <StyledTextField
                fullWidth
                name="name"
                value={formData.name}
                onChange={handleInputChange}
                variant="standard"
              />
            </Box>

            {/* Responsable + Radio Buttons */}
            <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 2.5, gap: 2 }}>
              <Box sx={{ flex: 1 }}>
                <SectionTitle>Responsable de la course</SectionTitle>
                <FormControl fullWidth size="small">
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

            {/* Durée + Difficulté */}
            <Grid container spacing={3} sx={{ marginBottom: 2.5 }}>
              <Grid item xs={6}>
                <SectionTitle>durée</SectionTitle>
                <StyledTextField
                  fullWidth
                  name="duration"
                  value={formData.duration}
                  onChange={handleInputChange}
                  variant="standard"
                />
              </Grid>
              <Grid item xs={6}>
                <SectionTitle>difficulté</SectionTitle>
                <FormControl fullWidth size="small">
                  <Select
                    name="difficulty"
                    value={formData.difficulty}
                    onChange={handleSelectChange}
                    variant="standard"
                  >
                    <MenuItem value="facile">Facile</MenuItem>
                    <MenuItem value="moyen">Moyen</MenuItem>
                    <MenuItem value="difficile">Difficile</MenuItem>
                  </Select>
                </FormControl>
              </Grid>
            </Grid>

            {/* Prix mineur + Prix majeur */}
            <Grid container spacing={3} sx={{ marginBottom: 2.5 }}>
              <Grid item xs={6}>
                <SectionTitle>prix mineur</SectionTitle>
                <StyledTextField
                  fullWidth
                  name="minPrice"
                  value={formData.minPrice}
                  onChange={handleInputChange}
                  variant="standard"
                />
              </Grid>
              <Grid item xs={6}>
                <SectionTitle>prix majeur</SectionTitle>
                <StyledTextField
                  fullWidth
                  name="maxPrice"
                  value={formData.maxPrice}
                  onChange={handleInputChange}
                  variant="standard"
                />
              </Grid>
            </Grid>

            {/* Nombre de participants minimum */}
            <Box sx={{ marginBottom: 2.5 }}>
              <SectionTitle>nombre de participant minimum</SectionTitle>
              <StyledTextField
                fullWidth
                name="minParticipants"
                value={formData.minParticipants}
                onChange={handleInputChange}
                variant="standard"
              />
            </Box>

            {/* Illustration */}
            <Box sx={{ marginBottom: 2.5 }}>
              <SectionTitle>Illustration</SectionTitle>
              <StyledTextField
                fullWidth
                name="illustration"
                value={formData.illustration}
                onChange={handleInputChange}
                variant="standard"
              />
            </Box>

            {/* Dates et heures */}
            <Grid container spacing={3} sx={{ marginBottom: 2.5 }}>
              <Grid item xs={6}>
                <SectionTitle>Date de début</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="date"
                    name="startDate"
                    value={formData.startDate}
                    onChange={handleInputChange}
                    variant="standard"
                  />
                </Box>
              </Grid>
              <Grid item xs={6}>
                <SectionTitle>heure de départ</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <Button
                    fullWidth
                    onClick={handleStartTimeClick}
                    sx={{
                      textAlign: 'left',
                      color: '#000',
                      justifyContent: 'flex-start',
                      fontSize: '1rem',
                      textTransform: 'none',
                    }}
                  >
                    {formData.startTime ? formData.startTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : 'Sélectionner l\'heure'}
                    <AccessTimeIcon sx={{ ml: 1, color: '#999' }} />
                  </Button>
                  <Popper open={Boolean(startTimeAnchor)} anchorEl={startTimeAnchor}>
                    <Box sx={{ p: 2, backgroundColor: 'white', boxShadow: 1, borderRadius: 1 }}>
                      <TimeClock
                        value={formData.startTime}
                        onChange={handleStartTimeChange}
                        ampm={false}
                      />
                    </Box>
                  </Popper>
                </Box>
              </Grid>
            </Grid>

            <Grid container spacing={3} sx={{ marginBottom: 2 }}>
              <Grid item xs={6}>
                <SectionTitle>Date de fin</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <StyledTextField
                    fullWidth
                    type="date"
                    name="endDate"
                    value={formData.endDate}
                    onChange={handleInputChange}
                    variant="standard"
                  />
                </Box>
              </Grid>
              <Grid item xs={6}>
                <SectionTitle>heure de fin</SectionTitle>
                <Box sx={{ display: 'flex', alignItems: 'center', borderBottom: '1px solid #e0e0e0', paddingBottom: 1 }}>
                  <Button
                    fullWidth
                    onClick={handleEndTimeClick}
                    sx={{
                      textAlign: 'left',
                      color: '#000',
                      justifyContent: 'flex-start',
                      fontSize: '1rem',
                      textTransform: 'none',
                    }}
                  >
                    {formData.endTime ? formData.endTime.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) : 'Sélectionner l\'heure'}
                    <AccessTimeIcon sx={{ ml: 1, color: '#999' }} />
                  </Button>
                  <Popper open={Boolean(endTimeAnchor)} anchorEl={endTimeAnchor}>
                    <Box sx={{ p: 2, backgroundColor: 'white', boxShadow: 1, borderRadius: 1 }}>
                      <TimeClock
                        value={formData.endTime}
                        onChange={handleEndTimeChange}
                        ampm={false}
                      />
                    </Box>
                  </Popper>
                </Box>
              </Grid>
            </Grid>

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
