import React, { useMemo, useState } from 'react';
import {
    AppBar,
    Box,
    Toolbar,
    Typography,
    Button,
    Container,
    Menu,
    MenuItem,
    Stack,
    Tooltip,
    IconButton,
} from '@mui/material';
import { useUser } from '../../contexts/userContext';
import LoginIcon from '@mui/icons-material/Login';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import { useNavigate, useLocation } from 'react-router-dom';
import logo from '../../assets/logo-white.png';
import PersonAddIcon from '@mui/icons-material/PersonAdd';
import { createAvatar } from '@dicebear/core';
import { thumbs } from '@dicebear/collection';

const settings = ['Profile', 'Logout'];

function Navbar() {
    const [anchorElUser, setAnchorElUser] = useState<null | HTMLElement>(null);
    const { user, isAdmin, logout } = useUser();
    const navigate = useNavigate();
    const location = useLocation();
    console.log("isAdmin", isAdmin);
    const avatarSvg = useMemo(() => {
        if (!user) return '';
        const avatar = createAvatar(thumbs, {
            seed: `${user.USE_NAME}${user.USE_LAST_NAME}`,
            backgroundColor: ['1a2e22', '1b5e20', 'f97316'],
        });
        return avatar.toDataUri();
    }, [user]);

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
                        {user && <Button
                            key="TABLEAU DE BORD"
                            onClick={() => handlePageClick('/dashboard')}
                            sx={{
                                my: 2,
                                borderRadius: 1,
                                color: location.pathname === '/dashboard' ? 'warning.main' : 'white',
                                display: 'block',
                                px: 3,
                                fontFamily: '"Archivo Black", sans-serif',
                                '&:hover': {
                                    backgroundColor: 'secondary.main',
                                }
                            }}
                        >
                            TABLEAU DE BORD
                        </Button>}
                        <Button
                            key="LES RAIDS"
                            onClick={() => handlePageClick('/raids')}
                            sx={{
                                my: 2,
                                borderRadius: 1,
                                color: location.pathname === '/raids' ? 'warning.main' : 'white',
                                display: 'block',
                                px: 3,
                                fontFamily: '"Archivo Black", sans-serif',
                                '&:hover': {
                                    backgroundColor: 'secondary.main',
                                }
                            }}
                        >
                            LES RAIDS
                        </Button>
                        {isAdmin && (
                            <Button
                                key="Admin"
                                onClick={() => navigate('/admin')}
                                sx={{
                                    my: 2,
                                    borderRadius: 1,
                                    color: location.pathname === '/admin' ? 'warning.main' : 'white',
                                    display: 'block',
                                    px: 3,
                                    fontFamily: '"Archivo Black", sans-serif',
                                    '&:hover': {
                                        backgroundColor: 'secondary.main',
                                    }
                                }}
                            >
                                Admin
                            </Button>
                        )}
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
                                        <Box
                                            sx={{
                                                width: "50px",
                                                height: "auto",
                                                mb: 2,
                                                borderRadius: '50%',
                                                overflow: 'hidden',
                                                border: '2px solid #2D5A27',
                                                boxShadow: '0 4px 14px 0 rgba(0,0,0,0.1)'
                                            }}
                                        >
                                            <img src={avatarSvg} alt="Avatar" style={{ width: '100%', height: '100%' }} />
                                        </Box>
                                        <Typography variant="body2" sx={{ fontWeight: 'bold' }}>
                                            {user.USE_NAME + ' ' + user.USE_LAST_NAME}
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
                                        <LoginIcon fontSize="inherit" color="info" />
                                    </IconButton>
                                </Tooltip>
                                <Tooltip title={<Typography variant="body2">Inscription</Typography>} placement="bottom" arrow>
                                    <IconButton
                                        onClick={() => navigate('/register')}
                                        aria-label="register"
                                        size="large"
                                        sx={{ '&:hover': { color: 'warning.main' } }}
                                    >
                                        <PersonAddIcon fontSize="inherit" color="info" />
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


