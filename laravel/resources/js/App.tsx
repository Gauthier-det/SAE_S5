import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import Navbar from './components/common/Navbar';
import Home from './pages/Home';
import Dashboard from './pages/Dashboard';
import RaidsList from './pages/raids/RaidsList';
import RaidDetails from './pages/raids/RaidDetails';
import About from './pages/About';
import Login from './pages/auth/Login';
import CreateRaid from './pages/raids/CreateRaid';
import Register from './pages/auth/Register';
import CreateRace from './pages/raids/CreateRace';

import { UserProvider } from './contexts/userContext';

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
              {/*Main*/}
              <Route path="/" element={<Home />} />
              <Route path="/dashboard" element={<Dashboard />} />
              {/* Raid */}
              <Route path="/raids" element={<RaidsList />} />
              <Route path="/raids/:id" element={<RaidDetails />} />
              <Route path="/create-raid" element={<CreateRaid />} />
              {/* Races */}
              <Route path="/create-race" element={<CreateRace />} />
              {/* About */}
              <Route path="/about" element={<About />} />
              {/* Login */}
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
            </Route>
          </Routes>
        </Router>
      </LocalizationProvider>
    </UserProvider>
  );
}

export default App;
