import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import Navbar from './components/common/Navbar';
import Profile from './pages/user/Profile';
import { UserProvider, useUser } from './contexts/userContext';
import ProtectedRoute from './components/router/ProtectedRoute';
import GuestRoute from './components/router/GuestRoute';
import RaidsList from './pages/raids/RaidsList';
import RaidDetails from './pages/raids/RaidDetails';
import About from './pages/About';
import Register from './pages/auth/Register';
import CreateRace from './pages/raids/CreateRace';
import CreateRaid from './pages/raids/CreateRaid';
import Login from './pages/auth/Login';
import Dashboard from './pages/Dashboard';
import Home from './pages/Home';


const MainLayout = () => {
  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', height: '100vh'}}>
      <Navbar />
      <Outlet />
    </Box>
  );
};

const AppRoutes = () => {
  const { isClubManager, isRaidManager } = useUser();

  return (
    <Routes>
      <Route element={<MainLayout />}>
        <Route path="/" element={<Home />} />

        <Route path="/raids" element={<RaidsList />} />
        <Route path="/raids/:id" element={<RaidDetails />} />
        <Route path="/about" element={<About />} />

        {/* non auth Routes */}
        <Route element={<GuestRoute />}>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        </Route>

        {/* Protected Routes */}
        <Route element={<ProtectedRoute />}>
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/profile" element={<Profile />} />
        </Route>
        {/* Protected Routes for Club Managers */}
        <Route element={<ProtectedRoute condition={isClubManager} />}>
          <Route path="/raid/create" element={<CreateRaid />} />
        </Route>
        <Route element={<ProtectedRoute condition={isRaidManager} />}>
          <Route path="/race/create" element={<CreateRace />} />
        </Route>
      </Route>
    </Routes>
  );
};

function App() {
  return (
    <UserProvider>
      <LocalizationProvider dateAdapter={AdapterDayjs}>
        <Router>
          <CssBaseline />
          <AppRoutes />
        </Router>
      </LocalizationProvider>
    </UserProvider>
  );
}

export default App;
