import { Container, Typography, Box } from '@mui/material';

export default function Raids() {
    return (
        <Container maxWidth="xl">
            <Box sx={{ my: 4 }}>
                <Typography variant="h2" component="h1" gutterBottom>
                    Les Raids
                </Typography>
                <Typography variant="body1">
                    Liste des raids disponibles à l'exploration.
                </Typography>
            </Box>
        </Container>
    );
}
