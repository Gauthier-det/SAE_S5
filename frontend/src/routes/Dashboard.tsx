import { Container, Typography, Box } from '@mui/material';

export default function Dashboard() {
    return (
        <Container maxWidth="xl">
            <Box sx={{ my: 4 }}>
                <Typography variant="h2" component="h1" gutterBottom>
                    Dashboard
                </Typography>
                <Typography variant="body1">
                    Bienvenue sur le tableau de bord de Orient'Action.
                </Typography>
            </Box>
        </Container>
    );
}
