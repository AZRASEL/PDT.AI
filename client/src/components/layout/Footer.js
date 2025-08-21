import React from 'react';
import { Box, Typography, Link, Grid, Divider } from '@mui/material';
import ResponsiveContainer from './ResponsiveContainer';
import { Link as RouterLink } from 'react-router-dom';

const Footer = () => {
  return (
    <Box
      component="footer"
      sx={{
        py: 3,
        px: 2,
        mt: 'auto',
        backgroundColor: (theme) => theme.palette.grey[100],
      }}
      role="contentinfo"
    >
      <ResponsiveContainer>
        <Grid container spacing={3}>
          <Grid item xs={12} sm={4}>
            <Box display="flex" alignItems="center" mb={2}>
              <Box 
                component="img" 
                src="/logo.svg" 
                alt="PDT.AI Logo"
                sx={{ width: 40, height: 40, mr: 1 }} 
                aria-hidden="true"
              />
              <Typography variant="h6" color="text.primary">
                PDT.AI
              </Typography>
            </Box>
            <Typography variant="body2" color="text.secondary">
              AI-powered assistant for Photodynamic Therapy (PDT) for cancer treatment, especially oral cancers.
            </Typography>
          </Grid>
          
          <Grid item xs={12} sm={4}>
            <Typography variant="h6" color="text.primary" gutterBottom id="footer-nav-heading">
              Quick Links
            </Typography>
            <nav aria-labelledby="footer-nav-heading">
              <Link component={RouterLink} to="/" color="inherit" display="block" sx={{ mb: 1, py: 0.5 }} aria-label="Navigate to home page">
                Home
              </Link>
              <Link component={RouterLink} to="/research" color="inherit" display="block" sx={{ mb: 1, py: 0.5 }} aria-label="Navigate to article research page">
                Article Research
              </Link>
              <Link component={RouterLink} to="/treatment" color="inherit" display="block" sx={{ mb: 1, py: 0.5 }} aria-label="Navigate to treatment plan page">
                Treatment Plan
              </Link>
              <Link component={RouterLink} to="/analysis" color="inherit" display="block" sx={{ py: 0.5 }} aria-label="Navigate to image analysis page">
                Image Analysis
              </Link>
            </nav>
          </Grid>
          
          <Grid item xs={12} sm={4}>
            <Typography variant="h6" color="text.primary" gutterBottom id="external-resources-heading">
              Resources
            </Typography>
            <nav aria-labelledby="external-resources-heading">
              <Link 
                href="https://pubmed.ncbi.nlm.nih.gov/" 
                target="_blank" 
                rel="noopener noreferrer" 
                color="inherit" 
                display="block" 
                sx={{ mb: 1, py: 0.5 }}
                aria-label="Visit PubMed website (opens in new tab)"
              >
                PubMed
              </Link>
              <Link 
                href="https://www.cancer.gov/about-cancer/treatment/types/surgery/photodynamic-fact-sheet" 
                target="_blank" 
                rel="noopener noreferrer" 
                color="inherit" 
                display="block" 
                sx={{ mb: 1, py: 0.5 }}
                aria-label="Visit NCI PDT Information page (opens in new tab)"
              >
                NCI PDT Information
              </Link>
              <Link 
                href="https://www.cancer.org/cancer/oral-cavity-and-oropharyngeal-cancer.html" 
                target="_blank" 
                rel="noopener noreferrer" 
                color="inherit" 
                display="block"
                sx={{ py: 0.5 }}
                aria-label="Visit Oral Cancer Information page (opens in new tab)"
              >
                Oral Cancer Information
              </Link>
            </nav>
          </Grid>
        </Grid>
        
        <Divider sx={{ my: 2 }} />
        
        <Typography variant="body2" color="text.secondary" align="center">
          {'© '}
          {new Date().getFullYear()}
          {' PDT.AI. All rights reserved.'}
        </Typography>
      </ResponsiveContainer>
    </Box>
  );
};

export default Footer;