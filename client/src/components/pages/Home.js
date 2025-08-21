import React from 'react';
import { Link as RouterLink } from 'react-router-dom';
import {
  Box,
  Button,
  Card,
  CardContent,
  CardMedia,
  Grid,
  Typography,
  useTheme,
  useMediaQuery,
} from '@mui/material';
import ResponsiveContainer from '../layout/ResponsiveContainer';
import ResponsiveImage from '../common/ResponsiveImage';
import SearchIcon from '@mui/icons-material/Search';
import CalculateIcon from '@mui/icons-material/Calculate';
import ImageSearchIcon from '@mui/icons-material/ImageSearch';

// Hero image placeholder
const heroImageUrl = '/hero-background.svg';

// Feature images placeholders
const featureImages = {
  research: '/article-research.svg',
  treatment: '/treatment-plan.svg',
  analysis: '/image-analysis.svg',
};

const Home = () => {
  const theme = useTheme();
  const isMobile = useMediaQuery(theme.breakpoints.down('sm'));
  const isMedium = useMediaQuery(theme.breakpoints.down('md'));

  return (
    <Box>
      {/* Hero Section */}
      <Box
        sx={{
          bgcolor: 'primary.main',
          color: 'white',
          pt: { xs: 6, md: 12 },
          pb: { xs: 8, md: 16 },
          position: 'relative',
          overflow: 'hidden',
        }}
      >
        {/* Background SVG pattern */}
        <Box
          sx={{
            position: 'absolute',
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            opacity: 0.1,
            backgroundImage: `url(${heroImageUrl})`,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            zIndex: 0,
          }}
        />

        <ResponsiveContainer sx={{ position: 'relative', zIndex: 1 }}>
          <Grid container spacing={4} alignItems="center">
            <Grid item xs={12} md={6}>
              <Typography
                variant="h1"
                gutterBottom
                sx={{
                  fontWeight: 700,
                  fontSize: { xs: '2.5rem', md: '3.5rem' },
                  mb: 2,
                }}
              >
                PDT.AI
              </Typography>
              <Typography
                variant="h2"
                gutterBottom
                sx={{
                  fontWeight: 600,
                  fontSize: { xs: '1.5rem', md: '2rem' },
                  mb: 3,
                }}
              >
                AI-Powered Photodynamic Therapy Assistant
              </Typography>
              <Typography
                variant="subtitle1"
                sx={{ mb: 4, maxWidth: '600px', fontSize: { xs: '1rem', md: '1.25rem' } }}
              >
                Advancing cancer treatment through intelligent analysis, evidence-based recommendations, 
                and cutting-edge fluorescence imaging for researchers and clinicians.
              </Typography>
              <Box sx={{ display: 'flex', gap: 2, flexWrap: 'wrap' }}>
                <Button
                  variant="contained"
                  color="secondary"
                  size="large"
                  component={RouterLink}
                  to="/research"
                  sx={{ px: 4, py: 1.5 }}
                >
                  Explore Research
                </Button>
                <Button
                  variant="outlined"
                  size="large"
                  sx={{
                    px: 4,
                    py: 1.5,
                    color: 'white',
                    borderColor: 'white',
                    '&:hover': {
                      borderColor: 'white',
                      backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    },
                  }}
                  component={RouterLink}
                  to="/treatment"
                >
                  Treatment Calculator
                </Button>
              </Box>
            </Grid>
            <Grid
              item
              xs={12}
              md={6}
              sx={{
                display: { xs: 'none', md: 'flex' },
                justifyContent: 'center',
                alignItems: 'center',
              }}
            >
              <ResponsiveImage
                src="/logo.svg"
                alt="PDT.AI Logo - Photodynamic Therapy AI Assistant"
                sx={{
                  width: '80%',
                  maxWidth: 400,
                }}
                imgSx={{
                  filter: 'drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2))',
                }}
              />
            </Grid>
          </Grid>
        </ResponsiveContainer>
      </Box>

      {/* Features Section */}
      <ResponsiveContainer sx={{ py: { xs: 6, md: 10 } }}>
        <Typography
          variant="h2"
          align="center"
          gutterBottom
          sx={{ mb: { xs: 4, md: 6 }, fontWeight: 600 }}
        >
          Comprehensive PDT Solutions
        </Typography>

        <Grid container spacing={4}>
          {/* Feature 1: Article Research */}
          <Grid item xs={12} md={4}>
            <Card
              sx={{
                height: '100%',
                display: 'flex',
                flexDirection: 'column',
                transition: 'transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: '0 12px 20px rgba(0, 0, 0, 0.1)',
                },
              }}
            >
              <Box sx={{ height: 200, overflow: 'hidden' }}>
                <ResponsiveImage
                  src={featureImages.research}
                  alt="Article Research - Search and analyze scientific publications on Photodynamic Therapy"
                  aspectRatio="16/9"
                  sx={{ height: 200 }}
                />
              </Box>
              <CardContent sx={{ flexGrow: 1 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                  <SearchIcon color="primary" sx={{ mr: 1, fontSize: 28 }} />
                  <Typography variant="h5" component="h2" gutterBottom>
                    Article Research
                  </Typography>
                </Box>
                <Typography variant="body1" paragraph>
                  Access the latest scientific publications on Photodynamic Therapy. Search, filter, and analyze
                  research papers to stay updated with cutting-edge developments.
                </Typography>
                <Button
                  variant="outlined"
                  color="primary"
                  component={RouterLink}
                  to="/research"
                  sx={{ mt: 'auto' }}
                >
                  Explore Research
                </Button>
              </CardContent>
            </Card>
          </Grid>

          {/* Feature 2: Treatment Plan */}
          <Grid item xs={12} md={4}>
            <Card
              sx={{
                height: '100%',
                display: 'flex',
                flexDirection: 'column',
                transition: 'transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: '0 12px 20px rgba(0, 0, 0, 0.1)',
                },
              }}
            >
              <Box sx={{ height: 200, overflow: 'hidden' }}>
                <ResponsiveImage
                  src={featureImages.treatment}
                  alt="Treatment Plan - Calculate optimal PDT parameters for personalized treatment"
                  aspectRatio="16/9"
                  sx={{ height: 200 }}
                />
              </Box>
              <CardContent sx={{ flexGrow: 1 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                  <CalculateIcon color="primary" sx={{ mr: 1, fontSize: 28 }} />
                  <Typography variant="h5" component="h2" gutterBottom>
                    Treatment Plan
                  </Typography>
                </Box>
                <Typography variant="body1" paragraph>
                  Calculate optimal PDT parameters based on scientific models. Adjust light fluence, wavelength,
                  photosensitizer dose, and tissue properties to generate personalized treatment plans.
                </Typography>
                <Button
                  variant="outlined"
                  color="primary"
                  component={RouterLink}
                  to="/treatment"
                  sx={{ mt: 'auto' }}
                >
                  Plan Treatment
                </Button>
              </CardContent>
            </Card>
          </Grid>

          {/* Feature 3: Image Analysis */}
          <Grid item xs={12} md={4}>
            <Card
              sx={{
                height: '100%',
                display: 'flex',
                flexDirection: 'column',
                transition: 'transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: '0 12px 20px rgba(0, 0, 0, 0.1)',
                },
              }}
            >
              <Box sx={{ height: 200, overflow: 'hidden' }}>
                <ResponsiveImage
                  src={featureImages.analysis}
                  alt="Image Analysis - Analyze PpIX fluorescence images to quantify treatment efficacy"
                  aspectRatio="16/9"
                  sx={{ height: 200 }}
                />
              </Box>
              <CardContent sx={{ flexGrow: 1 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                  <ImageSearchIcon color="primary" sx={{ mr: 1, fontSize: 28 }} />
                  <Typography variant="h5" component="h2" gutterBottom>
                    Image Analysis
                  </Typography>
                </Box>
                <Typography variant="body1" paragraph>
                  Analyze PpIX fluorescence images to quantify photosensitizer distribution and treatment efficacy.
                  Compare pre- and post-treatment results with advanced visualization tools.
                </Typography>
                <Button
                  variant="outlined"
                  color="primary"
                  component={RouterLink}
                  to="/analysis"
                  sx={{ mt: 'auto' }}
                >
                  Analyze Images
                </Button>
              </CardContent>
            </Card>
          </Grid>
        </Grid>
      </ResponsiveContainer>

      {/* Call to Action Section */}
      <Box sx={{ bgcolor: 'secondary.light', py: { xs: 6, md: 10 } }}>
        <ResponsiveContainer maxWidth="md">
          <Typography
            variant="h3"
            align="center"
            gutterBottom
            sx={{ color: 'white', mb: 3 }}
          >
            Advancing PDT Research and Clinical Practice
          </Typography>
          <Typography
            variant="subtitle1"
            align="center"
            sx={{ color: 'white', mb: 4, fontSize: { xs: '1rem', md: '1.25rem' } }}
          >
            Join the community of researchers and clinicians using PDT.AI to improve cancer treatment outcomes.
          </Typography>
          <Box sx={{ display: 'flex', justifyContent: 'center', gap: 3, flexWrap: 'wrap' }}>
            <Button
              variant="contained"
              color="primary"
              size="large"
              component={RouterLink}
              to="/research"
              sx={{ px: 4, py: 1.5 }}
            >
              Start Researching
            </Button>
            <Button
              variant="outlined"
              size="large"
              component={RouterLink}
              to="/treatment"
              sx={{
                px: 4,
                py: 1.5,
                color: 'white',
                borderColor: 'white',
                '&:hover': {
                  borderColor: 'white',
                  backgroundColor: 'rgba(255, 255, 255, 0.1)',
                },
              }}
            >
              Calculate Treatment
            </Button>
          </Box>
        </ResponsiveContainer>
      </Box>
    </Box>
  );
};

export default Home;