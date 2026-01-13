import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import Navbar from './components/Navbar';
import Home from './routes/Home';
import Dashboard from './routes/Dashboard';
import Raids from './routes/Raids';
import InfoRaid from './routes/InfoRaid';
import About from './routes/About';
import Login from './routes/Login';
import CreateCourse from './routes/CreateCourse';
import CreateRaid from './routes/CreateRaid';

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
            <Route path="/" element={<Home />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/raids" element={<Raids />} />
            <Route path="/raids/:id" element={<InfoRaid />} />
            <Route path="/create-raid" element={<CreateRaid />} />

            <Route path="/about" element={<About />} />
            <Route path="/login" element={<Login />} />
            <Route path="/create-course" element={<CreateCourse />} />
          </Route>
        </Routes>
      </Router>
        </LocalizationProvider>
    </UserProvider>
  );
}

export default App;
