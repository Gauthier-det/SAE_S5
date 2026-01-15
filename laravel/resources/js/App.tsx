import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import Navbar from './components/common/Navbar';
import Profile from './pages/user/Profile';
import { UserProvider, useUser } from './contexts/userContext';
import { AlertProvider } from './contexts/AlertContext';
import ProtectedRoute from './components/router/ProtectedRoute';
import GuestRoute from './components/router/GuestRoute';
import RaidsList from './pages/raids/RaidsList';
import RaidDetails from './pages/raids/RaidDetails';
import Register from './pages/auth/Register';
import RaceDetails from './pages/races/RaceDetails';
import RaceResults from './pages/races/RaceResults';
import TeamRegistration from './pages/races/TeamRegistration';
import TeamRaceManagement from './pages/teams/TeamRaceManagement';
import CreateRace from './pages/raids/CreateRace';
import EditRace from './pages/races/EditRace';
import CreateRaid from './pages/raids/CreateRaid';
import EditRaid from './pages/raids/EditRaid';
import Login from './pages/auth/Login';
import Dashboard from './pages/Dashboard';
import Home from './pages/Home';
import AdminDashboard from './pages/AdminDashboard';
import Club from './pages/club/Club';


const MainLayout = () => {
  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', height: '100vh' }}>
      <Navbar />
      <Outlet />
    </Box>
  );
};

const AppRoutes = () => {
  const { isClubManager, isRaidManager, isAdmin } = useUser();

  return (
    <Routes>
      <Route element={<MainLayout />}>
        <Route path="/" element={<Home />} />

        <Route path="/raids" element={<RaidsList />} />
        <Route path="/raids/:id" element={<RaidDetails />} />
        <Route path="/races/:id" element={<RaceDetails />} />
        <Route path="/races/:id/results" element={<RaceResults />} />

        {/* non auth Routes */}
        <Route element={<GuestRoute />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>

        {/* Protected Routes */}
        <Route element={<ProtectedRoute />}>
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/profile" element={<Profile />} />
          <Route path="/races/:id/register" element={<TeamRegistration />} />
          <Route path="/teams/:teamId/races/:raceId/manage" element={<TeamRaceManagement />} />
        </Route>
        {/* Protected Routes for Club Managers */}
        <Route element={<ProtectedRoute condition={isClubManager} />}>
          <Route path="/raid/create" element={<CreateRaid />} />
          <Route path="/raids/:id/edit" element={<EditRaid />} />
        </Route>
        <Route element={<ProtectedRoute condition={isRaidManager} />}>
          <Route path="/raids/:id/create" element={<CreateRace />} />
          <Route path="/races/:id/edit" element={<EditRace />} />
        </Route>

        {/* Admin Routes */}
        <Route element={<ProtectedRoute condition={isAdmin} />}>
          <Route path="/admin" element={<AdminDashboard />} />
        </Route>
        <Route element={<ProtectedRoute condition={isClubManager} />}>
          <Route path="/club/:id" element={<Club />} />
        </Route>
      </Route>
    </Routes>
  );
};

function App() {
  return (
    <AlertProvider>
      <UserProvider>
        <LocalizationProvider dateAdapter={AdapterDayjs}>
          <Router>
            <CssBaseline />
            <AppRoutes />
          </Router>
        </LocalizationProvider>
      </UserProvider>
    </AlertProvider>
  );
}

export default App;
