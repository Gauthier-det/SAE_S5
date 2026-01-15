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
  Stack,
  FormControlLabel,
  Checkbox
} from '@mui/material';
import { useNavigate, useParams } from 'react-router-dom';
import { createRaceWithPrices } from '../../api/race';
import type { RaceCreation } from '../../models/race.model';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import { TimePicker } from '@mui/x-date-pickers/TimePicker';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import 'dayjs/locale/fr';
import dayjs, { Dayjs } from 'dayjs';
import { useUser } from '../../contexts/userContext';
import { getClubUsers } from '../../api/club';
import { getRaidById } from '../../api/raid';
import type { User } from '../../models/user.model';
import type { Raid } from '../../models/raid.model';

/**
 * CreateRace Component
 * 
 * A comprehensive form component for creating a new race within a raid.
 * This component handles:
 * - Race metadata (type, gender, difficulty)
 * - Race date and time constraints (within raid boundaries)
 * - Participant and team configuration
 * - Age group specifications
 * - Pricing for different categories
 * - Chip requirement for competitive races
 * 
 * The form includes real-time validation with inline error messages and
 * enforces business logic constraints such as:
 * - Maximum participants >= minimum participants
 * - Teams configuration within participant limits
 * - Race dates/times within raid boundaries
 * - Age constraints (min <= middle <= max)
 * 
 * @component
 */
const CreateRace = () => {
  const navigate = useNavigate();
  const { id } = useParams<{ id: string }>();
  const { user } = useUser();
  
  // State for raid data and club members
  const [raid, setRaid] = useState<Raid | null>(null);
  const [clubUsers, setClubUsers] = useState<User[]>([]);
  const [selectedResponsible, setSelectedResponsible] = useState<number | ''>('');
  
  /**
   * Form data state containing all race creation fields
   * Initialized with default values and populated as user interacts with form
   */
  const [formData, setFormData] = useState<RaceCreation>({
    USE_ID: 0,
    RAI_ID: parseInt(id || '0'),
    RAC_TIME_START: '',
    RAC_TIME_END: '',
    RAC_GENDER: 'Mixte',
    RAC_TYPE: '',
    RAC_DIFFICULTY: '',
    RAC_MIN_PARTICIPANTS: 0,
    RAC_MAX_PARTICIPANTS: 0,
    RAC_MIN_TEAMS: 0,
    RAC_MAX_TEAMS: 0,
    RAC_MAX_TEAM_MEMBERS: 0,
    RAC_AGE_MIN: 0,
    RAC_AGE_MIDDLE: 0,
    RAC_AGE_MAX: 0,
    CAT_1_PRICE: 0,
    CAT_2_PRICE: 0,
    CAT_3_PRICE: 0,
    RAC_CHIP_REQUIRED: false
  });

  /**
   * Field-level error messages
   * Key: field name (e.g., 'RAC_MIN_PARTICIPANTS')
   * Value: error message string
   */
  const [errors, setErrors] = useState<Record<string, string>>({});

  /**
   * Initialize component by fetching raid and club user data
   * - Retrieves raid details from API using route parameter
   * - Fetches list of club users for race manager selection
   */
  useEffect(() => {
    const init = async () => {
      if (!id) return;
      try {
        const raidId = parseInt(id);
        const raidData = await getRaidById(raidId);
        setRaid(raidData);
        
        if (raidData.club) {
          const users = await getClubUsers(raidData.club.CLU_ID);
          setClubUsers(users || []);
        }
      } catch (error) {
        console.error('Failed to load raid info:', error);
      }
    };
    init();
  }, [id]);

  /**
   * Validates all form fields against business rules
   * 
   * @param {RaceCreation} data - Form data to validate
   * @returns {Record<string, string>} Object containing field names as keys and error messages as values
   * 
   * Validation rules:
   * - Participants: min > 0, max >= min
   * - Teams: min > 0, max >= min, max <= max_participants
   * - Team members: > 0, <= max_participants
   * - Ages: min <= middle <= max
   * - Dates/Times: within raid boundaries, end >= start
   */
  const validateForm = (data: RaceCreation) => {
    const newErrors: Record<string, string> = {};
    
    // Validation Participants
    if (data.RAC_MAX_PARTICIPANTS < data.RAC_MIN_PARTICIPANTS) {
      newErrors.RAC_MAX_PARTICIPANTS = "Le nombre maximum doit être supérieur au minimum";
    }
    if (data.RAC_MIN_PARTICIPANTS === 0) {
      newErrors.RAC_MIN_PARTICIPANTS = "Le nombre minimum de participants doit être au moins 1";
    }
    
    // Validation Équipes
    if (data.RAC_MAX_TEAMS < data.RAC_MIN_TEAMS) {
      newErrors.RAC_MAX_TEAMS = "Le nombre maximum d'équipes doit être supérieur au minimum";
    }
    if (data.RAC_MIN_TEAMS === 0) {
      newErrors.RAC_MIN_TEAMS = "Le nombre minimum d'équipes doit être au moins 1";
    }
    if (data.RAC_MAX_TEAMS === 0) {
      newErrors.RAC_MAX_TEAMS = "Le nombre maximum d'équipes doit être au moins 1";
    }
    
    // Validation Membres par équipe
    if (data.RAC_MAX_TEAM_MEMBERS > data.RAC_MAX_PARTICIPANTS) {
      newErrors.RAC_MAX_TEAM_MEMBERS = "Les membres par équipe ne peuvent pas dépasser le nombre maximum de participants";
    }
    if (data.RAC_MAX_TEAM_MEMBERS === 0) {
      newErrors.RAC_MAX_TEAM_MEMBERS = "Le nombre de membres par équipe doit être au moins 1";
    }
    
    // Validation Âges
    if (data.RAC_AGE_MIN > data.RAC_AGE_MIDDLE) {
      newErrors.RAC_AGE_MIN = "L'âge minimum ne peut pas être supérieur à l'âge moyen";
    }
    if (data.RAC_AGE_MIDDLE > data.RAC_AGE_MAX) {
      newErrors.RAC_AGE_MIDDLE = "L'âge moyen ne peut pas être supérieur à l'âge maximum";
    }
    if (data.RAC_AGE_MIN >= data.RAC_AGE_MAX) {
      newErrors.RAC_AGE_MAX = "L'âge maximum doit être supérieur à l'âge minimum";
    }
    if (data.RAC_AGE_MAX < data.RAC_AGE_MIDDLE) {
      newErrors.RAC_AGE_MAX = "L'âge maximum doit être supérieur ou égal à l'âge moyen";
    }

    // Validation des dates par rapport au raid
    if (raid) {
      // Parser les dates avec leurs formats respectifs
      const raceStart = dayjs(data.RAC_TIME_START, "YYYY-MM-DD HH:mm:ss");
      const raceEnd = dayjs(data.RAC_TIME_END, "YYYY-MM-DD HH:mm:ss");
      const raidStart = dayjs(raid.RAI_TIME_START);

      if (data.RAC_TIME_START && raceStart.isBefore(raidStart)) {
        newErrors.RAC_TIME_START = "L'heure de début ne peut pas être avant le début du raid";
      }
      if (data.RAC_TIME_START && data.RAC_TIME_END && raceEnd.isBefore(raceStart)) {
        newErrors.RAC_TIME_END = "L'heure de fin doit être après l'heure de début";
      }
    }
    return newErrors;
  };

  /**
   * Handles text/number input field changes with real-time validation
   * Automatically parses numeric fields and updates both form data and error state
   * 
   * @param {React.ChangeEvent} e - Change event from input field
   */
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | { name?: string; value: unknown }>) => {
    const { name, value } = e.target;
    const numValue = ['RAC_MIN_PARTICIPANTS', 'RAC_MAX_PARTICIPANTS', 'RAC_MIN_TEAMS', 'RAC_MAX_TEAMS', 'RAC_MAX_TEAM_MEMBERS', 'RAC_AGE_MIN', 'RAC_AGE_MIDDLE', 'RAC_AGE_MAX', 'CAT_1_PRICE', 'CAT_2_PRICE', 'CAT_3_PRICE'].includes(name as string) 
      ? parseFloat(value as string) 
      : value;
    const newFormData = {
      ...formData,
      [name as string]: numValue
    };
    setFormData(newFormData);
    
    // Real-time validation
    const newErrors = validateForm(newFormData);
    setErrors(newErrors);
  };

  /**
   * Handles dropdown/select field changes with real-time validation
   * Updates form data and triggers validation on selection change
   * 
   * @param {any} e - Change event from select field
   */
  const handleSelectChange = (e: any) => {
    const { name, value } = e.target;
    const newFormData = {
      ...formData,
      [name]: value
    };
    setFormData(newFormData);
    
    // Real-time validation
    const newErrors = validateForm(newFormData);
    setErrors(newErrors);
  };

  /**
   * Handles form submission
   * - Performs final validation
   * - Returns early if validation errors exist
   * - Submits race data to API on success
   * - Navigates to home page on successful creation
   * 
   * @param {React.FormEvent} e - Form submit event
   */
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    // Validation
    const newErrors = validateForm(formData);

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      return;
    }

    setErrors({});

    try {
      // Remove USE_ID from payload (will be set by server via authentication)
      const { USE_ID, ...raceData } = formData;
      const racePayload = {
        ...raceData,
        RAI_ID: parseInt(id || '0'),
        USE_ID: selectedResponsible ? (selectedResponsible as number) : (user?.USE_ID || 0),
      };
      await createRaceWithPrices(racePayload as any);
      setErrors({});
      navigate('/');
    } catch (error: any) {
      console.error('Error creating race:', error);
      setErrors({ submit: error.message || 'Error creating race' });
    }
  };

  /**
   * Render the race creation form with the following sections:
   * 1. Raid information (start/end dates with times)
   * 2. Race responsibility assignment
   * 3. Race type and difficulty
   * 4. Gender and chip requirements
   * 5. Date and time configuration
   * 6. Participant and team settings
   * 7. Age group configuration
   * 8. Pricing by category
   */
  return (
    <Box
      sx={{
        flexGrow: 1,
        bgcolor: '#1a2e22',
        minHeight: '150vh',
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
          mt: 5,
          mb: 4,
          fontFamily: '"Archivo Black", sans-serif'
        }}
      >
        CREATION D'UNE COURSE
      </Typography>

      <Paper
        elevation={3}
        sx={{
          p: 4,
          width: '100%',
          maxWidth: 800,
          borderRadius: 4,
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          mb: 4
        }}
      >
        {/* Raid Name */}
        <Typography component="h2" variant="h6" sx={{ mb: 2, fontWeight: 'bold', textTransform: 'uppercase' }}>
          {raid ? raid.RAI_NAME : 'Chargement...'}
        </Typography>

        {/* Raid Boundaries Information - Displays start and end dates/times */}
        {raid && (
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={3} sx={{ width: '100%', mb: 3, p: 2, bgcolor: '#f5f5f5', borderRadius: 2 }}>
            <Box>
              <Typography variant="body2" sx={{ color: '#666', fontWeight: 'bold', mb: 0.5 }}>
                Début du raid
              </Typography>
              <Typography variant="body1" sx={{ fontWeight: 'bold', color: '#1a2e22' }}>
                {dayjs(raid.RAI_TIME_START).format('DD/MM/YYYY')}
              </Typography>
              <Typography variant="body2" sx={{ color: '#1a2e22' }}>
                à {dayjs(raid.RAI_TIME_START).format('HH:mm')}
              </Typography>
            </Box>
            <Box>
              <Typography variant="body2" sx={{ color: '#666', fontWeight: 'bold', mb: 0.5 }}>
                Fin du raid
              </Typography>
              <Typography variant="body1" sx={{ fontWeight: 'bold', color: '#1a2e22' }}>
                {dayjs(raid.RAI_TIME_END).format('DD/MM/YYYY')}
              </Typography>
              <Typography variant="body2" sx={{ color: '#1a2e22' }}>
                à {dayjs(raid.RAI_TIME_END).format('HH:mm')}
              </Typography>
            </Box>
          </Stack>
        )}

        <LocalizationProvider dateAdapter={AdapterDayjs} adapterLocale="fr">
          <Box component="form" onSubmit={handleSubmit} sx={{ width: '100%' }}>
            {/* Submit Error Display */}
            {errors.submit && (
              <Box sx={{ 
                bgcolor: '#ffebee', 
                border: '1px solid #f44336', 
                borderRadius: 1, 
                p: 2, 
                mb: 2 
              }}>
                <Typography sx={{ color: '#d32f2f', fontWeight: 'bold' }}>
                  {errors.submit}
                </Typography>
              </Box>
            )}
          
          {/* Race Manager Selection - Dropdown to select responsible person */}
          <FormControl fullWidth variant="standard" margin="normal">
            <InputLabel shrink>Responsable de la course</InputLabel>
            <Select
              value={selectedResponsible}
              onChange={(e) => setSelectedResponsible(e.target.value as number)}
              displayEmpty
              required
            >
              <MenuItem value="" disabled>Sélectionner un responsable</MenuItem>
              {clubUsers.map(u => (
                <MenuItem key={u.USE_ID} value={u.USE_ID}>{u.USE_NAME} {u.USE_LAST_NAME}</MenuItem>
              ))}
            </Select>
          </FormControl>

          {/* Race Type + Chip Requirement */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <FormControl fullWidth variant="standard" margin="normal">
                <InputLabel shrink>Type de course</InputLabel>
                <Select
                  value={formData.RAC_TYPE}
                  onChange={handleSelectChange}
                  name="RAC_TYPE"
                  label="Type de course"
                  displayEmpty
                  required
                >
                  <MenuItem value="" disabled>Sélectionner un type</MenuItem>
                  <MenuItem value="Loisirs">Loisirs</MenuItem>
                  <MenuItem value="Compétitif">Compétitif</MenuItem>
                </Select>
              </FormControl>
            </Box>

            {/* Chip Requirement - Only visible for Competitive races */}
            {formData.RAC_TYPE === 'Compétitif' && (
              <Box sx={{ display: 'flex', alignItems: 'center', flex: 1 }}>
                <FormControlLabel
                  control={
                    <Checkbox
                      checked={formData.RAC_CHIP_REQUIRED || false}
                      onChange={(e) => setFormData({ ...formData, RAC_CHIP_REQUIRED: e.target.checked })}
                      name="RAC_CHIP_REQUIRED"
                    />
                  }
                  label="Puce requise"
                />
              </Box>
            )}
          </Stack>

          {/* Gender + Difficulty */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <FormControl fullWidth variant="standard" margin="normal">
              <InputLabel shrink>Genre</InputLabel>
              <Select
                value={formData.RAC_GENDER}
                onChange={handleSelectChange}
                name="RAC_GENDER"
                label="Genre"
                displayEmpty
                required
              >
                <MenuItem value="Homme">Homme</MenuItem>
                <MenuItem value="Femme">Femme</MenuItem>
                <MenuItem value="Mixte">Mixte</MenuItem>
              </Select>
            </FormControl>

            <TextField
              fullWidth
              label="Difficulté"
              name="RAC_DIFFICULTY"
              variant="standard"
              value={formData.RAC_DIFFICULTY}
              onChange={handleChange}
              margin="normal"
              required
              placeholder="Ex: Facile, Moyen, Difficile..."
            />
          </Stack>

          {/* Start Date & Time Configuration */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <DatePicker
                label="Date de début"
                value={formData.RAC_TIME_START ? dayjs(formData.RAC_TIME_START) : null}
                onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAC_TIME_START: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : '' })}
                minDate={raid ? dayjs(raid.RAI_TIME_START) : undefined}
                maxDate={raid ? dayjs(raid.RAI_TIME_END) : undefined}
                slotProps={{ textField: { variant: 'standard', fullWidth: true, required: true } }}
              />
            </Box>
            <Box sx={{ flex: 1 }}>
              <TimePicker
                label="Heure de départ"
                value={formData.RAC_TIME_START ? dayjs(formData.RAC_TIME_START, 'YYYY-MM-DD HH:mm:ss') : null}
                onChange={(newValue: Dayjs | null) => {
                  if (newValue && formData.RAC_TIME_START) {
                    const startDate = dayjs(formData.RAC_TIME_START, 'YYYY-MM-DD HH:mm:ss');
                    const newFormData = {
                      ...formData,
                      RAC_TIME_START: startDate.hour(newValue.hour()).minute(newValue.minute()).format('YYYY-MM-DD HH:mm:ss')
                    };
                    setFormData(newFormData);
                    // Real-time validation
                    const newErrors = validateForm(newFormData);
                    setErrors(newErrors);
                  }
                }}
                slotProps={{ textField: { variant: 'standard', fullWidth: true, error: !!errors.RAC_TIME_START, required: true } }}
              />
              {errors.RAC_TIME_START && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_TIME_START}
                </Typography>
              )}
            </Box>
          </Stack>

          {/* End Date & Time Configuration */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <DatePicker
                label="Date de fin"
                value={formData.RAC_TIME_END ? dayjs(formData.RAC_TIME_END) : null}
                onChange={(newValue: Dayjs | null) => setFormData({ ...formData, RAC_TIME_END: newValue ? newValue.format('YYYY-MM-DD HH:mm:ss') : '' })}
                minDate={raid ? dayjs(raid.RAI_TIME_START) : undefined}
                maxDate={raid ? dayjs(raid.RAI_TIME_END) : undefined}
                slotProps={{ textField: { variant: 'standard', fullWidth: true, required: true } }}
              />
            </Box>
            <Box sx={{ flex: 1 }}>
              <TimePicker
                label="Heure de fin"
                value={formData.RAC_TIME_END ? dayjs(formData.RAC_TIME_END, 'YYYY-MM-DD HH:mm:ss') : null}
                onChange={(newValue: Dayjs | null) => {
                  if (newValue && formData.RAC_TIME_END) {
                    const endDate = dayjs(formData.RAC_TIME_END, 'YYYY-MM-DD HH:mm:ss');
                    const newFormData = {
                      ...formData,
                      RAC_TIME_END: endDate.hour(newValue.hour()).minute(newValue.minute()).format('YYYY-MM-DD HH:mm:ss')
                    };
                    setFormData(newFormData);
                    // Real-time validation
                    const newErrors = validateForm(newFormData);
                    setErrors(newErrors);
                  }
                }}
                slotProps={{ textField: { variant: 'standard', fullWidth: true, error: !!errors.RAC_TIME_END, required: true } }}
              />
              {errors.RAC_TIME_END && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_TIME_END}
                </Typography>
              )}
            </Box>
          </Stack>

          {/* Participant Configuration - Min and Max participants */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Participants minimum"
                name="RAC_MIN_PARTICIPANTS"
                type="number"
                variant="standard"
                error={!!errors.RAC_MIN_PARTICIPANTS}
                value={formData.RAC_MIN_PARTICIPANTS}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_MIN_PARTICIPANTS && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_MIN_PARTICIPANTS}
                </Typography>
              )}
            </Box>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Participants maximum"
                name="RAC_MAX_PARTICIPANTS"
                type="number"
                variant="standard"
                value={formData.RAC_MAX_PARTICIPANTS}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
                error={!!errors.RAC_MAX_PARTICIPANTS}
              />
              {errors.RAC_MAX_PARTICIPANTS && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_MAX_PARTICIPANTS}
                </Typography>
              )}
            </Box>
          </Stack>

          {/* Team Configuration - Min and Max teams */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Équipes minimum"
                name="RAC_MIN_TEAMS"
                type="number"
                variant="standard"
                error={!!errors.RAC_MIN_TEAMS}
                value={formData.RAC_MIN_TEAMS}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_MIN_TEAMS && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_MIN_TEAMS}
                </Typography>
              )}
            </Box>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Équipes maximum"
                name="RAC_MAX_TEAMS"
                type="number"
                variant="standard"
                error={!!errors.RAC_MAX_TEAMS}
                value={formData.RAC_MAX_TEAMS}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_MAX_TEAMS && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_MAX_TEAMS}
                </Typography>
              )}
            </Box>
          </Stack>

          {/* Team Members Configuration */}
          <Box sx={{ mt: 2 }}>
            <TextField
              fullWidth
              label="Membres maximum par équipe"
              name="RAC_MAX_TEAM_MEMBERS"
              type="number"
              variant="standard"
              error={!!errors.RAC_MAX_TEAM_MEMBERS}
              value={formData.RAC_MAX_TEAM_MEMBERS}
              onChange={handleChange}
              margin="normal"
              required
              inputProps={{ min: 0 }}
            />
            {errors.RAC_MAX_TEAM_MEMBERS && (
              <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                {errors.RAC_MAX_TEAM_MEMBERS}
              </Typography>
            )}
          </Box>

          {/* Age Group Configuration - Min, Middle, Max ages */}
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Âge minimum"
                name="RAC_AGE_MIN"
                type="number"
                variant="standard"
                error={!!errors.RAC_AGE_MIN}
                value={formData.RAC_AGE_MIN}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_AGE_MIN && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_AGE_MIN}
                </Typography>
              )}
            </Box>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Âge moyen"
                name="RAC_AGE_MIDDLE"
                type="number"
                variant="standard"
                error={!!errors.RAC_AGE_MIDDLE}
                value={formData.RAC_AGE_MIDDLE}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_AGE_MIDDLE && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_AGE_MIDDLE}
                </Typography>
              )}
            </Box>
            <Box sx={{ flex: 1 }}>
              <TextField
                fullWidth
                label="Âge maximum"
                name="RAC_AGE_MAX"
                type="number"
                variant="standard"
                error={!!errors.RAC_AGE_MAX}
                value={formData.RAC_AGE_MAX}
                onChange={handleChange}
                margin="normal"
                required
                inputProps={{ min: 0 }}
              />
              {errors.RAC_AGE_MAX && (
                <Typography sx={{ color: '#d32f2f', fontSize: '0.75rem', mt: 0.5 }}>
                  {errors.RAC_AGE_MAX}
                </Typography>
              )}
            </Box>
          </Stack>

          {/* Prix par catégorie */}
          <Typography variant="h6" sx={{ mt: 2, fontWeight: 'bold' }}>
            Prix par catégorie
          </Typography>
          <Stack direction={{ xs: 'column', md: 'row' }} spacing={2} sx={{ mt: 1 }}>
            <TextField
              fullWidth
              label="Mineur"
              name="CAT_1_PRICE"
              type="number"
              variant="standard"
              value={formData.CAT_1_PRICE}
              onChange={handleChange}
              margin="normal"
              required
              inputProps={{ step: '0.01', min: 0 }}
            />
            <TextField
              fullWidth
              label="Majeur non licencié"
              name="CAT_2_PRICE"
              type="number"
              variant="standard"
              value={formData.CAT_2_PRICE}
              onChange={handleChange}
              margin="normal"
              required
              inputProps={{ step: '0.01', min: 0 }}
            />
            <TextField
              fullWidth
              label="Licencié"
              name="CAT_3_PRICE"
              type="number"
              variant="standard"
              value={formData.CAT_3_PRICE}
              onChange={handleChange}
              margin="normal"
              required
              inputProps={{ step: '0.01', min: 0 }}
            />
          </Stack>

          <Box sx={{ display: 'flex', justifyContent: 'flex-end', mt: 2 }}>
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
        </LocalizationProvider>
      </Paper>
    </Box>
  );
};

export default CreateRace;
