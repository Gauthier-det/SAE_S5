import { createTheme } from '@mui/material/styles';

const theme = createTheme({
    palette: {
        primary: {
            main: '#1B3022', // Vert Sanglier
            light: '#2D5A27', // Mousse Profonde
            contrastText: '#FDFCF8',
        },
        secondary: {
            main: '#2D5A27',
        },
        warning: {
            main: '#FF6B00', // Orange Balise
        },
        background: {
            default: '#FDFCF8', // Bouleau
            paper: '#FFFFFF',
        },
        text: {
            primary: '#212529', // Charbon
        },
        divider: '#7A5C43', // Écorce
        grey: {
            100: '#E9ECEF', // Galet
        },
    },
    typography: {
        fontFamily: '"Inter", "Roboto", "Helvetica", "Arial", sans-serif',
        h1: {
            fontFamily: '"Archivo Black", sans-serif',
            fontSize: '80px',
        },
        h2: {
            fontFamily: '"Archivo Black", sans-serif',
            fontSize: '48px',
        },
        h3: {
            fontFamily: '"Archivo Black", sans-serif',
            fontSize: '24px',
        },
        h6: {
            fontFamily: '"Archivo Black", sans-serif',
        },
        button: {
            fontFamily: '"Inter", sans-serif',
            fontWeight: 700,
            fontSize: '18px',
            textTransform: 'uppercase',
        },
        body1: {
            fontSize: '18px',
        },
        caption: {
            fontWeight: 600,
        }
    },
    components: {
        MuiButton: {
            styleOverrides: {
                root: {
                    borderRadius: 0, // Sharp edges often fit the "robust/adventure" vibe, adjustable if needed
                },
            },
        },
    },
});

export default theme;
