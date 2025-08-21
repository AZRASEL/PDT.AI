import React from 'react';
import { Link } from 'react-router-dom';
import { 
  Box, 
  Button, 
  Card, 
  CardActionArea, 
  CardContent, 
  CardMedia, 
  Container, 
  Grid, 
  Typography,
  useMediaQuery
} from '@mui/material';
import { useTheme } from '@mui/material/styles';
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import SearchIcon from '@mui/icons-material/Search';
import CalculateIcon from '@mui/icons-material/Calculate';
import ImageSearchIcon from '@mui/icons-material/ImageSearch';

const Home = () => {
  const theme = useTheme();
  const isMobile = useMediaQuery(theme.breakpoints.down('sm'));

  return (
    <Box>
      {/* Hero Section */}
      <Box 
        sx={{
          background: `url(/hero-background.svg)`,
          backgroundSize: 'cover',
          backgroundPosition: 'center',
          color: 'white',
          py: { xs: 8, md: 12 },
          position: 'relative',
          overflow: 'hidden'
        }}
      >
        <Container maxWidth="lg">
          <Grid container spacing={4} alignItems="center">
            <Grid item xs={12} md={6}>
              <Box sx={{ textAlign: { xs: 'center', md: 'left' } }}>
                <img 
                  src="/logo.svg" 
                  alt="PDT.AI Logo" 
                  style={{ 
                    width: isMobile ? '120px' : '180px', 
                    marginBottom: theme.spacing(3),
                    filter: 'drop-shadow(0px 0px 10px rgba(255,255,255,0.3))'
                  }} 
                />
                <Typography 
                  variant="h2" 
                  component="h1" 
                  sx={{ 
                    fontWeight: 700, 
                    mb: 2,
                    fontSize: { xs: '2.5rem', md: '3.5rem' },
                    textShadow: '0px 2px 4px rgba(0,0,0,0.3)'
                  }}
                >
                  PDT.AI
                </Typography>
                <Typography 
                  variant="h5" 
                  sx={{ 
                    mb: 4, 
                    fontWeight: 300,
                    maxWidth: '600px',
                    mx: { xs: 'auto', md: 0 },
                    textShadow: '0px 1px 2px rgba(0,0,0,0.3)'
                  }}
                >
                  Advanced AI-powered assistant for Photodynamic Therapy in cancer treatment
                </Typography>
                <Box sx={{ display: 'flex', gap: 2, justifyContent: { xs: 'center', md: 'flex-start' } }}>
                  <Button 
                    variant="contained" 
                    color="secondary" 
                    size="large"
                    component={Link}
                    to="/treatment"
                    endIcon={<ArrowForwardIcon />}
                    sx={{ 
                      px: 3, 
                      py: 1.5,
                      fontWeight: 600,
                      boxShadow: theme.shadows[4]
                    }}
                  >
                    Start Treatment Plan
                  </Button>
                  <Button 
                    variant="outlined" 
                    color="inherit" 
                    size="large"
                    component={Link}
                    to="/articles"
                    sx={{ 
                      px: 3, 
                      py: 1.5,
                      fontWeight: 600,
                      borderWidth: 2,
                      '&:hover': {
                        borderWidth: 2
                      }
                    }}
                  >
                    Explore Research
                  </Button>
                </Box>
              </Box>
            </Grid>
            <Grid item xs={12} md={6} sx={{ display: { xs: 'none', md: 'block' } }}>
              {/* This space is intentionally left empty to balance the hero section */}
              {/* It allows the background SVG to be more visible on this side */}
            </Grid>
          </Grid>
        </Container>
      </Box>

      {/* Features Section */}
      <Container maxWidth="lg" sx={{ py: { xs: 6, md: 10 } }}>
        <Typography 
          variant="h3" 
          component="h2" 
          align="center" 
          sx={{ 
            mb: 2, 
            fontWeight: 700,
            color: theme.palette.primary.main
          }}
        >
          Features
        </Typography>
        <Typography 
          variant="h6" 
          align="center" 
          color="textSecondary" 
          sx={{ 
            mb: 6, 
            maxWidth: '800px', 
            mx: 'auto'
          }}
        >
          Comprehensive tools for researchers and clinicians in photodynamic therapy
        </Typography>

        <Grid container spacing={4}>
          {/* Article Research Feature */}
          <Grid item xs={12} md={4}>
            <Card 
              sx={{ 
                height: '100%', 
                display: 'flex', 
                flexDirection: 'column',
                transition: 'transform 0.3s, box-shadow 0.3s',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: theme.shadows[8]
                }
              }}
            >
              <CardActionArea component={Link} to="/articles" sx={{ flexGrow: 1 }}>
                <CardMedia
                  component="img"
                  height="200"
                  image="/article-research.svg"
                  alt="Article Research"
                  sx={{ p: 2, objectFit: 'contain' }}
                />
                <CardContent sx={{ flexGrow: 1 }}>
                  <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                    <SearchIcon color="primary" sx={{ mr: 1 }} />
                    <Typography gutterBottom variant="h5" component="h3" sx={{ fontWeight: 600 }}>
                      Article Research
                    </Typography>
                  </Box>
                  <Typography variant="body1" color="text.secondary">
                    Search and access the latest scientific publications on photodynamic therapy and oral cancer treatments from PubMed and other credible sources.
                  </Typography>
                </CardContent>
              </CardActionArea>
            </Card>
          </Grid>

          {/* Treatment Plan Feature */}
          <Grid item xs={12} md={4}>
            <Card 
              sx={{ 
                height: '100%', 
                display: 'flex', 
                flexDirection: 'column',
                transition: 'transform 0.3s, box-shadow 0.3s',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: theme.shadows[8]
                }
              }}
            >
              <CardActionArea component={Link} to="/treatment" sx={{ flexGrow: 1 }}>
                <CardMedia
                  component="img"
                  height="200"
                  image="/treatment-plan.svg"
                  alt="Treatment Plan"
                  sx={{ p: 2, objectFit: 'contain' }}
                />
                <CardContent sx={{ flexGrow: 1 }}>
                  <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                    <CalculateIcon color="primary" sx={{ mr: 1 }} />
                    <Typography gutterBottom variant="h5" component="h3" sx={{ fontWeight: 600 }}>
                      Treatment Plan
                    </Typography>
                  </Box>
                  <Typography variant="body1" color="text.secondary">
                    Calculate optimal PDT parameters including light fluence, wavelength, and photosensitizer dose based on tissue properties and treatment goals.
                  </Typography>
                </CardContent>
              </CardActionArea>
            </Card>
          </Grid>

          {/* Image Analysis Feature */}
          <Grid item xs={12} md={4}>
            <Card 
              sx={{ 
                height: '100%', 
                display: 'flex', 
                flexDirection: 'column',
                transition: 'transform 0.3s, box-shadow 0.3s',
                '&:hover': {
                  transform: 'translateY(-8px)',
                  boxShadow: theme.shadows[8]
                }
              }}
            >
              <CardActionArea component={Link} to="/analysis" sx={{ flexGrow: 1 }}>
                <CardMedia
                  component="img"
                  height="200"
                  image="/image-analysis.svg"
                  alt="Image Analysis"
                  sx={{ p: 2, objectFit: 'contain' }}
                />
                <CardContent sx={{ flexGrow: 1 }}>
                  <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
                    <ImageSearchIcon color="primary" sx={{ mr: 1 }} />
                    <Typography gutterBottom variant="h5" component="h3" sx={{ fontWeight: 600 }}>
                      Image Analysis
                    </Typography>
                  </Box>
                  <Typography variant="body1" color="text.secondary">
                    Analyze PpIX fluorescence images to quantify photosensitizer uptake, treatment efficacy, and generate comprehensive reports for clinical use.
                  </Typography>
                </CardContent>
              </CardActionArea>
            </Card>
          </Grid>
        </Grid>
      </Container>

      {/* Call to Action Section */}
      <Box 
        sx={{ 
          bgcolor: theme.palette.primary.main, 
          color: 'white',
          py: { xs: 6, md: 8 },
          mt: 6
        }}
      >
        <Container maxWidth="md">
          <Typography 
            variant="h4" 
            component="h2" 
            align="center" 
            sx={{ 
              mb: 3, 
              fontWeight: 700 
            }}
          >
            Ready to enhance your PDT research and treatment?
          </Typography>
          <Typography 
            variant="h6" 
            align="center" 
            sx={{ 
              mb: 4, 
              fontWeight: 300,
              maxWidth: '800px',
              mx: 'auto'
            }}
          >
            PDT.AI provides evidence-based recommendations, scientific interpretation, and advanced image analysis tools for photodynamic therapy.
          </Typography>
          <Box sx={{ display: 'flex', justifyContent: 'center', gap: 3, flexWrap: 'wrap' }}>
            <Button 
              variant="contained" 
              color="secondary" 
              size="large"
              component={Link}
              to="/treatment"
              sx={{ 
                px: 4, 
                py: 1.5,
                fontWeight: 600
              }}
            >
              Start Treatment Planning
            </Button>
            <Button 
              variant="outlined" 
              color="inherit" 
              size="large"
              component={Link}
              to="/analysis"
              sx={{ 
                px: 4, 
                py: 1.5,
                fontWeight: 600,
                borderWidth: 2,
                '&:hover': {
                  borderWidth: 2
                }
              }}
            >
              Try Image Analysis
            </Button>
          </Box>
        </Container>
      </Box>
    </Box>
  );
};

export default Home;