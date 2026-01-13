import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import Navbar from './components/common/Navbar';
import Home from './routes/Home';
import Dashboard from './routes/Dashboard';
import Raids from './routes/Raids';
import InfoRaid from './routes/InfoRaid';
import About from './routes/About';
import Login from './routes/Login';
import CreateRaid from './routes/CreateRaid';
import Register from './routes/Register';
import CreateRace from './routes/CreateRace';
import Profile from './routes/Profile';

import { UserProvider } from './contexts/userContext';
import ProtectedRoute from './components/router/ProtectedRoute';
import GuestRoute from './components/router/GuestRoute';
import { isClubManager, isRaidManager } from './api/user';

const MainLayout = () => {
  return (
    <Box sx={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
      <Navbar />
      <Outlet />
    </Box>
  );
};

function App() {
  return (
    <UserProvider>
      <LocalizationProvider dateAdapter={AdapterDayjs}>
        <Router>
          <CssBaseline />
          <Routes>
            <Route element={<MainLayout />}>
              <Route path="/" element={<Home />} />
              <Route path="/raids" element={<Raids />} />
              <Route path="/raids/:id" element={<InfoRaid />} />
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
              <Route element={<ProtectedRoute condition={(user) => isClubManager(user.id)} />}>
                <Route path="/raid/create" element={<CreateRaid />} />
              </Route>
              <Route element={<ProtectedRoute condition={(user) => isRaidManager(user.id)} />}>
                <Route path="/race/create" element={<CreateRace />} />
              </Route>
            </Route>
          </Routes>
        </Router>
      </LocalizationProvider>
    </UserProvider>
  );
}

export default App;
