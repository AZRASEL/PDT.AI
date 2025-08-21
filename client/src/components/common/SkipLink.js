import React from 'react';
import { Box } from '@mui/material';

/**
 * SkipLink component provides keyboard users a way to bypass navigation
 * and jump directly to the main content of the page.
 * This is an important accessibility feature for keyboard-only users.
 */
const SkipLink = () => {
  return (
    <Box
      component="a"
      href="#main-content"
      className="skip-link"
      sx={{
        position: 'absolute',
        top: '-40px',
        left: 0,
        bgcolor: 'primary.main',
        color: 'white',
        padding: '8px',
        zIndex: 9999,
        transition: 'top 0.3s',
        '&:focus': {
          top: 0,
        },
      }}
    >
      Skip to main content
    </Box>
  );
};

export default SkipLink;