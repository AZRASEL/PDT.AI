import React, { useState, useEffect } from 'react';
import {
  Box,
  Button,
  Drawer,
  Typography,
  Slider,
  FormControlLabel,
  Switch,
  Divider,
  IconButton,
  Tooltip,
} from '@mui/material';
import AccessibilityNewIcon from '@mui/icons-material/AccessibilityNew';
import CloseIcon from '@mui/icons-material/Close';
import TextIncreaseIcon from '@mui/icons-material/TextIncrease';
import TextDecreaseIcon from '@mui/icons-material/TextDecrease';
import ContrastIcon from '@mui/icons-material/Contrast';
import BrightnessAutoIcon from '@mui/icons-material/BrightnessAuto';
import TranslateIcon from '@mui/icons-material/Translate';

const AccessibilityMenu = () => {
  const [open, setOpen] = useState(false);
  const [settings, setSettings] = useState({
    fontSize: 100, // percentage of default size
    highContrast: false,
    reducedMotion: false,
    screenReader: false,
    dyslexicFont: false,
    language: 'en',
  });

  // Load settings from localStorage on component mount
  useEffect(() => {
    const savedSettings = localStorage.getItem('accessibilitySettings');
    if (savedSettings) {
      setSettings(JSON.parse(savedSettings));
    }
  }, []);

  // Apply settings whenever they change
  useEffect(() => {
    // Save settings to localStorage
    localStorage.setItem('accessibilitySettings', JSON.stringify(settings));

    // Apply font size
    document.documentElement.style.fontSize = `${settings.fontSize}%`;

    // Apply high contrast
    if (settings.highContrast) {
      document.body.classList.add('high-contrast');
    } else {
      document.body.classList.remove('high-contrast');
    }

    // Apply reduced motion
    if (settings.reducedMotion) {
      document.body.classList.add('reduced-motion');
    } else {
      document.body.classList.remove('reduced-motion');
    }

    // Apply dyslexic font
    if (settings.dyslexicFont) {
      document.body.classList.add('dyslexic-font');
    } else {
      document.body.classList.remove('dyslexic-font');
    }

    // Apply screen reader announcements if needed
    if (settings.screenReader) {
      // This would typically integrate with aria-live regions
      document.body.setAttribute('data-screen-reader-enabled', 'true');
    } else {
      document.body.removeAttribute('data-screen-reader-enabled');
    }
  }, [settings]);

  const toggleDrawer = (newOpen) => () => {
    setOpen(newOpen);
  };

  const handleFontSizeChange = (event, newValue) => {
    setSettings({ ...settings, fontSize: newValue });
  };

  const handleSwitchChange = (name) => (event) => {
    setSettings({ ...settings, [name]: event.target.checked });
  };

  const handleLanguageChange = (lang) => {
    setSettings({ ...settings, language: lang });
    // In a real app, this would trigger language change throughout the app
    // For now, we'll just save the preference
  };

  const resetSettings = () => {
    const defaultSettings = {
      fontSize: 100,
      highContrast: false,
      reducedMotion: false,
      screenReader: false,
      dyslexicFont: false,
      language: 'en',
    };
    setSettings(defaultSettings);
  };

  return (
    <>
      <Tooltip title="Accessibility Options" arrow>
        <IconButton
          onClick={toggleDrawer(true)}
          color="primary"
          aria-label="accessibility options"
          sx={{
            position: 'fixed',
            bottom: 20,
            right: 20,
            bgcolor: 'primary.main',
            color: 'white',
            '&:hover': {
              bgcolor: 'primary.dark',
            },
            zIndex: 1000,
            width: 56,
            height: 56,
            boxShadow: 3,
          }}
        >
          <AccessibilityNewIcon />
        </IconButton>
      </Tooltip>

      <Drawer
        anchor="right"
        open={open}
        onClose={toggleDrawer(false)}
        sx={{
          '& .MuiDrawer-paper': {
            width: { xs: '100%', sm: 350 },
            p: 3,
            boxSizing: 'border-box',
          },
        }}
      >
        <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
          <Typography variant="h5" component="h2" sx={{ fontWeight: 600 }}>
            Accessibility Options
          </Typography>
          <IconButton onClick={toggleDrawer(false)} aria-label="close accessibility menu">
            <CloseIcon />
          </IconButton>
        </Box>

        <Divider sx={{ mb: 3 }} />

        <Typography variant="h6" gutterBottom>
          Text Size
        </Typography>
        <Box sx={{ display: 'flex', alignItems: 'center', mb: 3 }}>
          <TextDecreaseIcon color="primary" />
          <Slider
            value={settings.fontSize}
            onChange={handleFontSizeChange}
            aria-labelledby="font-size-slider"
            valueLabelDisplay="auto"
            step={10}
            marks
            min={70}
            max={150}
            sx={{ mx: 2 }}
          />
          <TextIncreaseIcon color="primary" />
        </Box>

        <Typography variant="h6" gutterBottom>
          Display Options
        </Typography>
        <FormControlLabel
          control={
            <Switch
              checked={settings.highContrast}
              onChange={handleSwitchChange('highContrast')}
              name="highContrast"
              color="primary"
            />
          }
          label="High Contrast"
          sx={{ display: 'block', mb: 1 }}
        />
        <FormControlLabel
          control={
            <Switch
              checked={settings.reducedMotion}
              onChange={handleSwitchChange('reducedMotion')}
              name="reducedMotion"
              color="primary"
            />
          }
          label="Reduced Motion"
          sx={{ display: 'block', mb: 1 }}
        />
        <FormControlLabel
          control={
            <Switch
              checked={settings.dyslexicFont}
              onChange={handleSwitchChange('dyslexicFont')}
              name="dyslexicFont"
              color="primary"
            />
          }
          label="Dyslexia-friendly Font"
          sx={{ display: 'block', mb: 3 }}
        />

        <Typography variant="h6" gutterBottom>
          Assistive Technology
        </Typography>
        <FormControlLabel
          control={
            <Switch
              checked={settings.screenReader}
              onChange={handleSwitchChange('screenReader')}
              name="screenReader"
              color="primary"
            />
          }
          label="Screen Reader Support"
          sx={{ display: 'block', mb: 3 }}
        />

        <Typography variant="h6" gutterBottom>
          Language
        </Typography>
        <Box sx={{ display: 'flex', flexWrap: 'wrap', gap: 1, mb: 3 }}>
          <Button
            variant={settings.language === 'en' ? 'contained' : 'outlined'}
            onClick={() => handleLanguageChange('en')}
            startIcon={<TranslateIcon />}
            size="small"
          >
            English
          </Button>
          <Button
            variant={settings.language === 'es' ? 'contained' : 'outlined'}
            onClick={() => handleLanguageChange('es')}
            startIcon={<TranslateIcon />}
            size="small"
          >
            Español
          </Button>
          <Button
            variant={settings.language === 'fr' ? 'contained' : 'outlined'}
            onClick={() => handleLanguageChange('fr')}
            startIcon={<TranslateIcon />}
            size="small"
          >
            Français
          </Button>
          <Button
            variant={settings.language === 'zh' ? 'contained' : 'outlined'}
            onClick={() => handleLanguageChange('zh')}
            startIcon={<TranslateIcon />}
            size="small"
          >
            中文
          </Button>
        </Box>

        <Divider sx={{ my: 3 }} />

        <Button
          variant="outlined"
          color="secondary"
          onClick={resetSettings}
          startIcon={<BrightnessAutoIcon />}
          fullWidth
        >
          Reset to Default
        </Button>
      </Drawer>
    </>
  );
};

export default AccessibilityMenu;