import { Container, Typography, Box } from '@mui/material';

export default function About() {
    return (
        <Container maxWidth="xl">
            <Box sx={{ my: 4 }}>
                <Typography variant="h2" component="h1" gutterBottom>
                    À Propos
                </Typography>
                <Typography variant="body1">
                    En savoir plus sur Race Explorer.
                </Typography>
            </Box>
        </Container>
    );
}
