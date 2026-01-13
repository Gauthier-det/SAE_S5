import { BrowserRouter as Router, Routes, Route, Outlet } from 'react-router-dom';
import { CssBaseline, Box } from '@mui/material';
import Navbar from './components/Navbar';
import Home from './routes/Home';
import Dashboard from './routes/Dashboard';
import Raids from './routes/Raids';
import About from './routes/About';
import Login from './routes/Login';
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
      <Router>
        <CssBaseline />
        <Routes>
          <Route element={<MainLayout />}>
            <Route path="/" element={<Home />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/raids" element={<Raids />} />
            <Route path="/about" element={<About />} />
            <Route path="/login" element={<Login />} />
          </Route>
        </Routes>
      </Router>
    </UserProvider>
  );
}

export default App;
