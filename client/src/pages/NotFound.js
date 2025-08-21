import React from 'react';
import { Link } from 'react-router-dom';
import { Box, Button, Typography } from '@mui/material';
import ResponsiveContainer from '../components/layout/ResponsiveContainer';
import HomeIcon from '@mui/icons-material/Home';

const NotFound = () => {
  return (
    <ResponsiveContainer maxWidth="md">
      <Box 
        sx={{
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          minHeight: '70vh',
          textAlign: 'center',
          py: 8
        }}
      >
        <Typography 
          variant="h1" 
          component="h1" 
          sx={{ 
            fontSize: { xs: '6rem', md: '10rem' },
            fontWeight: 700,
            color: 'primary.main',
            mb: 2,
            opacity: 0.8
          }}
          aria-live="polite"
        >
          404
        </Typography>
        
        <Typography 
          variant="h4" 
          component="h2" 
          sx={{ 
            mb: 3,
            fontWeight: 600
          }}
        >
          Page Not Found
        </Typography>
        
        <Typography 
          variant="body1" 
          sx={{ 
            mb: 4,
            maxWidth: '600px',
            color: 'text.secondary'
          }}
        >
          The page you are looking for might have been removed, had its name changed, 
          or is temporarily unavailable. Please return to the home page and try again.
        </Typography>
        
        <Button 
          variant="contained" 
          color="primary" 
          component={Link} 
          to="/"
          startIcon={<HomeIcon />}
          size="large"
          sx={{ 
            px: 4,
            py: 1.5,
            fontWeight: 600
          }}
          aria-label="Navigate back to home page"
        >
          Back to Home
        </Button>
      </Box>
    </ResponsiveContainer>
  );
};

export default NotFound;