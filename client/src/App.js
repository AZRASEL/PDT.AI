import React, { useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { Box } from '@mui/material';

// Accessibility Components
import AccessibilityMenu from './components/common/AccessibilityMenu';
import SkipLink from './components/common/SkipLink';
import './components/common/accessibility.css';

// Layout Components
import Navbar from './components/layout/Navbar';
import Footer from './components/layout/Footer';

// Page Components
import Home from './components/pages/Home';
import ArticleResearch from './components/pages/ArticleResearch';
import TreatmentPlan from './components/pages/TreatmentPlan';
import ImageAnalysis from './components/pages/ImageAnalysis';
import NotFound from './components/pages/NotFound';

function App() {
  // Track whether user is using keyboard or mouse for navigation
  useEffect(() => {
    const handleMouseDown = () => {
      document.body.classList.add('using-mouse');
    };

    const handleKeyDown = (event) => {
      // Only remove the class if Tab key is pressed
      if (event.key === 'Tab') {
        document.body.classList.remove('using-mouse');
      }
    };

    document.addEventListener('mousedown', handleMouseDown);
    document.addEventListener('keydown', handleKeyDown);

    return () => {
      document.removeEventListener('mousedown', handleMouseDown);
      document.removeEventListener('keydown', handleKeyDown);
    };
  }, []);

  return (
    <Router>
      <Box sx={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
        <SkipLink />
        <Navbar />
        <Box component="main" id="main-content" sx={{ flexGrow: 1 }}>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/research" element={<ArticleResearch />} />
            <Route path="/treatment" element={<TreatmentPlan />} />
            <Route path="/analysis" element={<ImageAnalysis />} />
            <Route path="*" element={<NotFound />} />
          </Routes>
        </Box>
        <Footer />
        <AccessibilityMenu />
      </Box>
    </Router>
  );
}

export default App;