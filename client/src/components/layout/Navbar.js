import React, { useState } from 'react';
import { Link as RouterLink, useLocation } from 'react-router-dom';
import {
  AppBar,
  Box,
  Toolbar,
  IconButton,
  Typography,
  Menu,
  Button,
  MenuItem,
  useMediaQuery,
  useTheme,
} from '@mui/material';
import ResponsiveContainer from './ResponsiveContainer';
import { handleListKeyboardNavigation } from '../../utils/accessibilityUtils';
import MenuIcon from '@mui/icons-material/Menu';
import ScienceIcon from '@mui/icons-material/Science';
import PersonIcon from '@mui/icons-material/Person';

const pages = [
  { title: 'Home', path: '/' },
  { title: 'Article Research', path: '/research' },
  { title: 'Treatment Plan', path: '/treatment' },
  { title: 'Image Analysis', path: '/analysis' },
];

const Navbar = () => {
  const [anchorElNav, setAnchorElNav] = useState(null);
  const [userType, setUserType] = useState('researcher'); // 'researcher' or 'patient'
  
  const theme = useTheme();
  const isMobile = useMediaQuery(theme.breakpoints.down('md'));
  const location = useLocation();

  const handleOpenNavMenu = (event) => {
    setAnchorElNav(event.currentTarget);
  };

  const handleCloseNavMenu = () => {
    setAnchorElNav(null);
  };

  const toggleUserType = () => {
    setUserType(userType === 'researcher' ? 'patient' : 'researcher');
  };

  return (
    <AppBar position="sticky" color="primary" component="nav" role="navigation">
      <ResponsiveContainer>
        <Toolbar disableGutters>
          {/* Logo and title - desktop */}
          <Box 
            component="img" 
            src="/logo.svg" 
            alt="PDT.AI Logo"
            sx={{ 
              display: { xs: 'none', md: 'flex' }, 
              mr: 1, 
              width: 40, 
              height: 40 
            }}
            aria-hidden="true"
          />
          <Typography
            variant="h6"
            noWrap
            component={RouterLink}
            to="/"
            sx={{
              mr: 2,
              display: { xs: 'none', md: 'flex' },
              fontWeight: 700,
              color: 'white',
              textDecoration: 'none',
            }}
          >
            PDT.AI
          </Typography>

          {/* Mobile menu */}
          <Box sx={{ flexGrow: 1, display: { xs: 'flex', md: 'none' } }}>
            <IconButton
              size="large"
              aria-label="Open navigation menu"
              aria-controls="menu-appbar"
              aria-haspopup="true"
              aria-expanded={Boolean(anchorElNav)}
              onClick={handleOpenNavMenu}
              color="inherit"
            >
              <MenuIcon />
            </IconButton>
            <Menu
              id="menu-appbar"
              anchorEl={anchorElNav}
              anchorOrigin={{
                vertical: 'bottom',
                horizontal: 'left',
              }}
              keepMounted
              transformOrigin={{
                vertical: 'top',
                horizontal: 'left',
              }}
              open={Boolean(anchorElNav)}
              onClose={handleCloseNavMenu}
              onKeyDown={(e) => handleListKeyboardNavigation(e, pages.length)}
              sx={{
                display: { xs: 'block', md: 'none' },
              }}
            >
              {pages.map((page) => (
                <MenuItem 
                  key={page.title} 
                  onClick={handleCloseNavMenu}
                  component={RouterLink}
                  to={page.path}
                  selected={location.pathname === page.path}
                  aria-current={location.pathname === page.path ? 'page' : undefined}
                >
                  <Typography textAlign="center">{page.title}</Typography>
                </MenuItem>
              ))}
            </Menu>
          </Box>

          {/* Logo and title - mobile */}
          <Box 
            component="img" 
            src="/logo.svg" 
            alt="PDT.AI Logo"
            sx={{ 
              display: { xs: 'flex', md: 'none' }, 
              mr: 1, 
              width: 32, 
              height: 32 
            }}
            aria-hidden="true"
          />
          <Typography
            variant="h6"
            noWrap
            component={RouterLink}
            to="/"
            sx={{
              mr: 2,
              display: { xs: 'flex', md: 'none' },
              flexGrow: 1,
              fontWeight: 700,
              color: 'white',
              textDecoration: 'none',
            }}
          >
            PDT.AI
          </Typography>

          {/* Desktop menu */}
          <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>
            {pages.map((page) => (
              <Button
                key={page.title}
                component={RouterLink}
                to={page.path}
                onClick={handleCloseNavMenu}
                sx={{
                  my: 2, 
                  color: 'white', 
                  display: 'block',
                  textDecoration: location.pathname === page.path ? 'underline' : 'none',
                  fontWeight: location.pathname === page.path ? 'bold' : 'normal'
                }}
                aria-current={location.pathname === page.path ? 'page' : undefined}
              >
                {page.title}
              </Button>
            ))}
          </Box>

          {/* User type toggle */}
          <Box sx={{ flexGrow: 0 }}>
            <Button
              variant="outlined"
              startIcon={userType === 'researcher' ? <ScienceIcon /> : <PersonIcon />}
              onClick={toggleUserType}
              aria-label={`Switch to ${userType === 'researcher' ? 'patient' : 'researcher'} view`}
              aria-pressed={userType === 'researcher'}
              sx={{
                color: 'white',
                borderColor: 'white',
                '&:hover': {
                  borderColor: 'white',
                  backgroundColor: 'rgba(255, 255, 255, 0.1)',
                },
              }}
            >
              {isMobile ? '' : userType === 'researcher' ? 'Researcher View' : 'Patient View'}
            </Button>
          </Box>
        </Toolbar>
      </ResponsiveContainer>
    </AppBar>
  );
};

export default Navbar;