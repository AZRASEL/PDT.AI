import React from 'react';
import { Container, useMediaQuery, useTheme } from '@mui/material';

/**
 * ResponsiveContainer component provides a responsive container
 * that adjusts its maximum width based on the screen size.
 * 
 * This helps maintain readability and usability across different devices.
 * 
 * @param {Object} props - Component props
 * @param {React.ReactNode} props.children - Child components
 * @param {Object} [props.sx] - Additional MUI system props
 * @param {string} [props.component] - The component to render as
 * @param {string} [props.id] - Optional ID for the container
 * @param {string} [props.className] - Optional class name
 * @param {Object} [props.rest] - Additional props to pass to the Container
 */
const ResponsiveContainer = ({ 
  children, 
  sx = {}, 
  component = 'div',
  id,
  className,
  ...rest 
}) => {
  const theme = useTheme();
  const isXs = useMediaQuery(theme.breakpoints.only('xs'));
  const isSm = useMediaQuery(theme.breakpoints.only('sm'));
  const isMd = useMediaQuery(theme.breakpoints.only('md'));

  // Determine padding based on screen size
  const getPadding = () => {
    if (isXs) return { px: 2, py: 3 };
    if (isSm) return { px: 3, py: 4 };
    if (isMd) return { px: 4, py: 5 };
    return { px: 4, py: 6 }; // For lg and above
  };

  return (
    <Container
      component={component}
      id={id}
      className={className}
      maxWidth="lg"
      sx={{
        ...getPadding(),
        ...sx,
      }}
      {...rest}
    >
      {children}
    </Container>
  );
};

export default ResponsiveContainer;