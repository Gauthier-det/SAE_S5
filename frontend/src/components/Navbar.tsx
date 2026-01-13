import React, { useState } from 'react';
import {
    AppBar,
    Box,
    Toolbar,
    Typography,
    Button,
    Container,
    Avatar,
    Menu,
    MenuItem,
    Stack,
    Tooltip,
    IconButton,
} from '@mui/material';
import { useUser } from '../contexts/userContext';
import LoginIcon from '@mui/icons-material/Login';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import { useNavigate, useLocation } from 'react-router-dom';
import logo from '../assets/logo-white.png';
import NoteAltIcon from '@mui/icons-material/NoteAlt';

const pages = [
    { name: 'DASHBOARD', path: '/dashboard' },
    { name: 'LES RAIDS', path: '/raids' },
    { name: 'A PROPOS', path: '/about' },
];

const settings = ['Profile', 'Logout'];

function Navbar() {
    const [anchorElUser, setAnchorElUser] = useState<null | HTMLElement>(null);
    const { user, logout } = useUser();
    const navigate = useNavigate();
    const location = useLocation();

    const handleOpenUserMenu = (event: React.MouseEvent<HTMLElement>) => {
        setAnchorElUser(event.currentTarget);
    };

    const handleCloseUserMenu = () => {
        setAnchorElUser(null);
    };

    const handleMenuClick = (setting: string) => {
        if (setting === 'Logout') {
            logout();
        } else if (setting === 'Profile') {
            navigate('/profile');
        }
        handleCloseUserMenu();
    };

    const handlePageClick = (path: string) => {
        navigate(path);
    };

    return (
        <AppBar position="static" sx={{ backgroundColor: 'primary.main' }}>
            <Container maxWidth={false} disableGutters>
                <Toolbar sx={{ justifyContent: 'space-between', px: 2 }}>
                    <Box sx={{ display: 'flex', alignItems: 'left', gap: 1 }}>
                        <Box
                            component="img"
                            sx={{
                                height: 60,
                                display: { xs: 'none', md: 'flex' },
                                mr: 1,
                                cursor: 'pointer'
                            }}
                            alt="Orient'Action Logo"
                            src={logo}
                            onClick={() => navigate('/')}
                        />
                    </Box>

                    <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' }, justifyContent: 'center', gap: 4 }}>
                        {pages.map((page) => (
                            <Button
                                key={page.name}
                                onClick={() => handlePageClick(page.path)}
                                sx={{
                                    my: 2,
                                    borderRadius: 1,
                                    color: location.pathname === page.path ? 'warning.main' : 'white',
                                    display: 'block',
                                    px: 3,
                                    fontFamily: '"Archivo Black", sans-serif',
                                    '&:hover': {
                                        backgroundColor: 'secondary.main',
                                    }
                                }}
                            >
                                {page.name}
                            </Button>
                        ))}
                    </Box>

                    <Box sx={{ flexGrow: 0 }}>
                        {user ?
                            <>
                                <Button
                                    onClick={handleOpenUserMenu}
                                    sx={{ p: 0, color: 'white', textTransform: 'none' }}
                                    endIcon={<KeyboardArrowDownIcon />}
                                >
                                    <Stack direction="row" spacing={2} alignItems="center">
                                        <Avatar alt={user.last_name + ' ' + user.name} />
                                        <Typography variant="body2" sx={{ fontWeight: 'bold' }}>
                                            {user.last_name + ' ' + user.name}
                                        </Typography>
                                    </Stack>
                                </Button>
                                <Menu
                                    sx={{ mt: '45px' }}
                                    id="menu-appbar"
                                    anchorEl={anchorElUser}
                                    anchorOrigin={{
                                        vertical: 'top',
                                        horizontal: 'right',
                                    }}
                                    keepMounted
                                    transformOrigin={{
                                        vertical: 'top',
                                        horizontal: 'right',
                                    }}
                                    open={!!anchorElUser}
                                    onClose={handleCloseUserMenu}
                                >
                                    {settings.map((setting) => (
                                        <MenuItem key={setting} onClick={() => handleMenuClick(setting)}>
                                            <Typography textAlign="center">{setting}</Typography>
                                        </MenuItem>
                                    ))}
                                </Menu>
                            </>
                            :
                            <>
                                <Tooltip title={<Typography variant="body2">Connexion</Typography>} placement="bottom" arrow>
                                    <IconButton
                                        onClick={() => navigate('/login')}
                                        aria-label="login"
                                        size="large"
                                        sx={{ '&:hover': { color: 'warning.main' } }}
                                    >
                                        <LoginIcon fontSize="inherit" color="warning" />
                                    </IconButton>
                                </Tooltip>
                                <Tooltip title={<Typography variant="body2">Inscription</Typography>} placement="bottom" arrow>
                                    <IconButton
                                        onClick={() => navigate('/register')}
                                        aria-label="register"
                                        size="large"
                                        sx={{ '&:hover': { color: 'warning.main' } }}
                                    >
                                        <NoteAltIcon fontSize="inherit" color="warning" />
                                    </IconButton>
                                </Tooltip>
                            </>
                        }
                    </Box>

                </Toolbar>
            </Container>
        </AppBar >
    );
}
export default Navbar;
