import React, { useState, useRef } from 'react';
import {
  Box,
  Button,
  Card,
  CardContent,
  CircularProgress,
  Container,
  Divider,
  FormControl,
  FormControlLabel,
  FormLabel,
  Grid,
  Paper,
  Radio,
  RadioGroup,
  Slider,
  Tab,
  Tabs,
  TextField,
  Typography,
} from '@mui/material';
import UploadFileIcon from '@mui/icons-material/UploadFile';
import ImageIcon from '@mui/icons-material/Image';
import AnalyticsIcon from '@mui/icons-material/Analytics';
import CompareIcon from '@mui/icons-material/Compare';
import WarningIcon from '@mui/icons-material/Warning';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import axios from 'axios';
import ResponsiveContainer from '../components/layout/ResponsiveContainer';
import ResponsiveImage from '../components/common/ResponsiveImage';
import AccessibleFormField from '../components/common/AccessibleFormField';
import AccessibleTable from '../components/common/AccessibleTable';
import { announceToScreenReader } from '../utils/accessibilityUtils';

// Chart components
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';
import { Line, Bar } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend
);

const ImageAnalysis = () => {
  const [activeTab, setActiveTab] = useState(0);
  const [preImage, setPreImage] = useState(null);
  const [postImage, setPostImage] = useState(null);
  const [preImagePreview, setPreImagePreview] = useState(null);
  const [postImagePreview, setPostImagePreview] = useState(null);
  const [analysisSettings, setAnalysisSettings] = useState({
    photosensitizer: 'ppix',
    tissueType: 'oral_mucosa',
    backgroundCorrection: true,
    normalizationMethod: 'max',
    roiSize: 50,
  });
  const [isLoading, setIsLoading] = useState(false);
  const [results, setResults] = useState(null);
  const [error, setError] = useState('');
  
  const preImageInputRef = useRef(null);
  const postImageInputRef = useRef(null);

  const handleTabChange = (event, newValue) => {
    setActiveTab(newValue);
  };

  const handleSettingsChange = (e) => {
    const { name, value, type, checked } = e.target;
    setAnalysisSettings({
      ...analysisSettings,
      [name]: type === 'checkbox' ? checked : value,
    });
  };

  const handleSliderChange = (name) => (e, newValue) => {
    setAnalysisSettings({
      ...analysisSettings,
      [name]: newValue,
    });
  };

  const handlePreImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPreImage(file);
      const reader = new FileReader();
      reader.onloadend = () => {
        setPreImagePreview(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  const handlePostImageUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPostImage(file);
      const reader = new FileReader();
      reader.onloadend = () => {
        setPostImagePreview(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  const triggerPreImageUpload = () => {
    preImageInputRef.current.click();
  };

  const triggerPostImageUpload = () => {
    postImageInputRef.current.click();
  };

  const analyzeImages = async () => {
    if (!preImage || !postImage) {
      setError('Both pre-treatment and post-treatment images are required');
      return;
    }

    setIsLoading(true);
    setError('');
    
    // Announce to screen readers that analysis is in progress
    announceToScreenReader('Analyzing fluorescence images, please wait...');

    const formData = new FormData();
    formData.append('preImage', preImage);
    formData.append('postImage', postImage);
    formData.append('settings', JSON.stringify(analysisSettings));

    try {
      const response = await axios.post('/api/analysis/fluorescence', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      setResults(response.data);
      setActiveTab(1); // Switch to Results tab
      
      // Announce results to screen readers
      announceToScreenReader('Image analysis complete. Results are now available.');
    } catch (err) {
      console.error('Error analyzing images:', err);
      setError('Failed to analyze images. Please try again.');
      announceToScreenReader('Error analyzing images. Please try again.');
    } finally {
      setIsLoading(false);
    }
  };

  const renderHistogramChart = () => {
    if (!results) return null;

    const data = {
      labels: results.histogramBins,
      datasets: [
        {
          label: 'Pre-treatment',
          data: results.preHistogram,
          backgroundColor: 'rgba(63, 81, 181, 0.5)',
        },
        {
          label: 'Post-treatment',
          data: results.postHistogram,
          backgroundColor: 'rgba(245, 0, 87, 0.5)',
        },
      ],
    };

    const options = {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Fluorescence Intensity Distribution',
        },
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Intensity',
          },
        },
        y: {
          title: {
            display: true,
            text: 'Frequency',
          },
        },
      },
    };

    return <Bar data={data} options={options} />
  };

  const renderDepthProfileChart = () => {
    if (!results) return null;

    const data = {
      labels: ['Surface', '0.5mm', '1.0mm', '1.5mm', '2.0mm', '2.5mm', '3.0mm'],
      datasets: [
        {
          label: 'Pre-treatment',
          data: results.preDepthProfile,
          borderColor: 'rgba(63, 81, 181, 1)',
          backgroundColor: 'rgba(63, 81, 181, 0.1)',
          tension: 0.4,
        },
        {
          label: 'Post-treatment',
          data: results.postDepthProfile,
          borderColor: 'rgba(245, 0, 87, 1)',
          backgroundColor: 'rgba(245, 0, 87, 0.1)',
          tension: 0.4,
        },
      ],
    };

    const options = {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Fluorescence Depth Profile',
        },
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Depth',
          },
        },
        y: {
          title: {
            display: true,
            text: 'Relative Intensity (%)',
          },
          min: 0,
        },
      },
    };

    return <Line data={data} options={options} />
  };

  return (
    <ResponsiveContainer sx={{ py: 4 }}>
      <Typography 
        variant="h3" 
        component="h1" 
        align="center" 
        sx={{ 
          mb: 1, 
          fontWeight: 700,
          color: 'primary.main'
        }}
        id="image-analysis-heading"
      >
        PpIX Fluorescence Analysis
      </Typography>
      
      <Typography 
        variant="h6" 
        align="center" 
        color="textSecondary" 
        sx={{ mb: 4 }}
      >
        Quantitative analysis of photosensitizer fluorescence for PDT monitoring
      </Typography>

      <Paper sx={{ mb: 4, borderRadius: 2 }}>
        <Tabs 
          value={activeTab} 
          onChange={handleTabChange} 
          variant="fullWidth"
          textColor="primary"
          indicatorColor="primary"
          aria-label="image analysis tabs"
        >
          <Tab icon={<UploadFileIcon />} label="Upload Images" />
          <Tab icon={<AnalyticsIcon />} label="Analysis Results" disabled={!results} />
          <Tab icon={<CompareIcon />} label="Comparison" disabled={!results} />
        </Tabs>
      </Paper>

      {activeTab === 0 && (
        <Grid container spacing={4}>
          <Grid item xs={12} md={7}>
            <Paper sx={{ p: 3, borderRadius: 2 }}>
              <Typography variant="h5" sx={{ mb: 3, fontWeight: 600 }}>
                <ImageIcon sx={{ mr: 1, verticalAlign: 'middle' }} />
                Upload Fluorescence Images
              </Typography>

              <Grid container spacing={3}>
                <Grid item xs={12} sm={6}>
                  <Card sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                    <CardContent sx={{ flexGrow: 1, display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
                      <Typography variant="h6" sx={{ mb: 2 }}>
                        Pre-Treatment Image
                      </Typography>
                      
                      <Box 
                        sx={{ 
                          width: '100%', 
                          height: 200, 
                          bgcolor: '#f5f5f5', 
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'center',
                          mb: 2,
                          borderRadius: 1,
                          overflow: 'hidden'
                        }}
                      >
                        {preImagePreview ? (
                          <img 
                            src={preImagePreview} 
                            alt="Pre-treatment" 
                            style={{ maxWidth: '100%', maxHeight: '100%', objectFit: 'contain' }} 
                          />
                        ) : (
                          <Typography color="textSecondary">
                            No image selected
                          </Typography>
                        )}
                      </Box>
                      
                      <input
                        type="file"
                        accept="image/*"
                        onChange={handlePreImageUpload}
                        style={{ display: 'none' }}
                        ref={preImageInputRef}
                      />
                      
                      <Button
                        variant="outlined"
                        color="primary"
                        onClick={triggerPreImageUpload}
                        startIcon={<UploadFileIcon />}
                        fullWidth
                      >
                        Select Pre-Treatment Image
                      </Button>
                    </CardContent>
                  </Card>
                </Grid>
                
                <Grid item xs={12} sm={6}>
                  <Card sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                    <CardContent sx={{ flexGrow: 1, display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
                      <Typography variant="h6" sx={{ mb: 2 }}>
                        Post-Treatment Image
                      </Typography>
                      
                      <Box 
                        sx={{ 
                          width: '100%', 
                          height: 200, 
                          bgcolor: '#f5f5f5', 
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'center',
                          mb: 2,
                          borderRadius: 1,
                          overflow: 'hidden'
                        }}
                      >
                        {postImagePreview ? (
                          <img 
                            src={postImagePreview} 
                            alt="Post-treatment" 
                            style={{ maxWidth: '100%', maxHeight: '100%', objectFit: 'contain' }} 
                          />
                        ) : (
                          <Typography color="textSecondary">
                            No image selected
                          </Typography>
                        )}
                      </Box>
                      
                      <input
                        type="file"
                        accept="image/*"
                        onChange={handlePostImageUpload}
                        style={{ display: 'none' }}
                        ref={postImageInputRef}
                      />
                      
                      <Button
                        variant="outlined"
                        color="primary"
                        onClick={triggerPostImageUpload}
                        startIcon={<UploadFileIcon />}
                        fullWidth
                      >
                        Select Post-Treatment Image
                      </Button>
                    </CardContent>
                  </Card>
                </Grid>
              </Grid>

              {error && (
                <Box sx={{ mt: 3, p: 2, bgcolor: '#fdeded', borderRadius: 1 }}>
                  <Typography color="error" sx={{ display: 'flex', alignItems: 'center' }}>
                    <WarningIcon sx={{ mr: 1 }} />
                    {error}
                  </Typography>
                </Box>
              )}

              <Button
                variant="contained"
                color="primary"
                fullWidth
                size="large"
                onClick={analyzeImages}
                disabled={isLoading || !preImage || !postImage}
                startIcon={isLoading ? <CircularProgress size={24} color="inherit" /> : <AnalyticsIcon />}
                sx={{ mt: 3, py: 1.5 }}
                aria-live="polite"
                aria-busy={isLoading}
              >
                {isLoading ? 'Analyzing...' : 'Analyze Fluorescence'}
              </Button>
            </Paper>
          </Grid>

          <Grid item xs={12} md={5}>
            <Paper sx={{ p: 3, borderRadius: 2 }}>
              <Typography variant="h5" sx={{ mb: 3, fontWeight: 600 }}>
                Analysis Settings
              </Typography>

              <AccessibleFormField
              id="photosensitizer"
              type="radio"
              label="Photosensitizer"
              value={analysisSettings.photosensitizer}
              onChange={handleSettingsChange}
              options={[
                { value: 'ppix', label: 'PpIX (Protoporphyrin IX)' },
                { value: 'photofrin', label: 'Photofrin (Porfimer Sodium)' },
                { value: 'foscan', label: 'Foscan (Temoporfin)' },
              ]}
              helperText="Select the photosensitizer used in the fluorescence images"
              required
              tooltipText="Different photosensitizers have different fluorescence characteristics and emission spectra"
              fieldProps={{ row: true }}
            />

              <AccessibleFormField
              id="tissueType"
              type="select"
              label="Tissue Type"
              value={analysisSettings.tissueType}
              onChange={handleSettingsChange}
              options={[
                { value: 'oral_mucosa', label: 'Oral Mucosa' },
                { value: 'tongue', label: 'Tongue' },
                { value: 'gingiva', label: 'Gingiva' },
                { value: 'buccal', label: 'Buccal Mucosa' },
                { value: 'floor_of_mouth', label: 'Floor of Mouth' },
              ]}
              helperText="Select the type of tissue being analyzed"
              tooltipText="Different tissues have different autofluorescence properties that affect analysis"
              required
            />

              <FormControl fullWidth sx={{ mb: 3 }}>
                <FormLabel>Background Correction</FormLabel>
                <RadioGroup
                  row
                  name="backgroundCorrection"
                  value={analysisSettings.backgroundCorrection.toString()}
                  onChange={handleSettingsChange}
                >
                  <FormControlLabel value="true" control={<Radio />} label="Enabled" />
                  <FormControlLabel value="false" control={<Radio />} label="Disabled" />
                </RadioGroup>
              </FormControl>

              <FormControl fullWidth sx={{ mb: 3 }}>
                <FormLabel>Normalization Method</FormLabel>
                <RadioGroup
                  row
                  name="normalizationMethod"
                  value={analysisSettings.normalizationMethod}
                  onChange={handleSettingsChange}
                >
                  <FormControlLabel value="max" control={<Radio />} label="Maximum" />
                  <FormControlLabel value="mean" control={<Radio />} label="Mean" />
                  <FormControlLabel value="none" control={<Radio />} label="None" />
                </RadioGroup>
              </FormControl>

              <FormControl fullWidth sx={{ mb: 3 }}>
                <FormLabel id="roi-size-label">ROI Size (%)</FormLabel>
                <Grid container spacing={2} alignItems="center">
                  <Grid item xs>
                    <Slider
                      value={analysisSettings.roiSize}
                      onChange={handleSliderChange('roiSize')}
                      min={10}
                      max={100}
                      step={5}
                      marks={[
                        { value: 10, label: '10%' },
                        { value: 50, label: '50%' },
                        { value: 100, label: '100%' },
                      ]}
                      aria-labelledby="roi-size-label"
                    />
                  </Grid>
                  <Grid item>
                    <Typography>{analysisSettings.roiSize}%</Typography>
                  </Grid>
                </Grid>
              </FormControl>

              <Typography variant="body2" color="textSecondary" sx={{ mt: 2 }}>
                These settings affect how the fluorescence images are processed and analyzed. 
                Adjust them based on your specific imaging setup and research requirements.
              </Typography>
            </Paper>

            <Paper sx={{ p: 3, mt: 3, borderRadius: 2 }}>
              <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                Image Requirements
              </Typography>
              
              <Typography variant="body2" paragraph>
                • Images should be in standard format (JPEG, PNG, TIFF)
              </Typography>
              <Typography variant="body2" paragraph>
                • Ensure consistent imaging conditions between pre and post
              </Typography>
              <Typography variant="body2" paragraph>
                • Include a reference standard in images if available
              </Typography>
              <Typography variant="body2" paragraph>
                • Optimal resolution: 1280×720 pixels or higher
              </Typography>
            </Paper>
          </Grid>
        </Grid>
      )}

      {activeTab === 1 && results && (
        <Grid container spacing={4}>
          <Grid item xs={12}>
            <Paper sx={{ p: 3, borderRadius: 2 }}>
              <Typography variant="h5" sx={{ mb: 3, fontWeight: 600, display: 'flex', alignItems: 'center' }}>
                <AnalyticsIcon sx={{ mr: 1 }} />
                Fluorescence Analysis Results
              </Typography>

              <Grid container spacing={3}>
                <Grid item xs={12} md={6}>
                  <Card sx={{ height: '100%' }}>
                    <CardContent>
                      <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                        Pre-Treatment Metrics
                      </Typography>
                      
                      <Grid container spacing={2}>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Mean Intensity</Typography>
                          <Typography variant="h6">{results.preMetrics.mean.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Max Intensity</Typography>
                          <Typography variant="h6">{results.preMetrics.max.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Standard Deviation</Typography>
                          <Typography variant="h6">{results.preMetrics.stdDev.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Total Signal</Typography>
                          <Typography variant="h6">{results.preMetrics.totalSignal.toFixed(2)}</Typography>
                        </Grid>
                      </Grid>
                    </CardContent>
                  </Card>
                </Grid>
                
                <Grid item xs={12} md={6}>
                  <Card sx={{ height: '100%' }}>
                    <CardContent>
                      <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                        Post-Treatment Metrics
                      </Typography>
                      
                      <Grid container spacing={2}>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Mean Intensity</Typography>
                          <Typography variant="h6">{results.postMetrics.mean.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Max Intensity</Typography>
                          <Typography variant="h6">{results.postMetrics.max.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Standard Deviation</Typography>
                          <Typography variant="h6">{results.postMetrics.stdDev.toFixed(2)}</Typography>
                        </Grid>
                        <Grid item xs={6}>
                          <Typography variant="subtitle2" color="textSecondary">Total Signal</Typography>
                          <Typography variant="h6">{results.postMetrics.totalSignal.toFixed(2)}</Typography>
                        </Grid>
                      </Grid>
                    </CardContent>
                  </Card>
                </Grid>
              </Grid>

              <Grid container spacing={3} sx={{ mt: 1 }}>
                <Grid item xs={12} md={6}>
                  <Paper sx={{ p: 2, height: '100%', borderRadius: 2 }}>
                    {renderHistogramChart()}
                  </Paper>
                </Grid>
                <Grid item xs={12} md={6}>
                  <Paper sx={{ p: 2, height: '100%', borderRadius: 2 }}>
                    {renderDepthProfileChart()}
                  </Paper>
                </Grid>
              </Grid>
            </Paper>
          </Grid>
        </Grid>
      )}

      {activeTab === 2 && results && (
        <Grid container spacing={4}>
          <Grid item xs={12}>
            <Paper sx={{ p: 3, borderRadius: 2 }}>
              <Typography variant="h5" sx={{ mb: 3, fontWeight: 600, display: 'flex', alignItems: 'center' }}>
                <CompareIcon sx={{ mr: 1 }} />
                Treatment Effect Analysis
              </Typography>

              <Grid container spacing={3}>
                <Grid item xs={12} md={4}>
                  <Card sx={{ 
                    bgcolor: results.treatmentEffect.score > 70 ? '#edf7ed' : 
                            results.treatmentEffect.score > 30 ? '#fff8e1' : '#fdeded',
                    height: '100%'
                  }}>
                    <CardContent>
                      <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                        Treatment Effect Score
                      </Typography>
                      
                      <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'center', mb: 2 }}>
                        <Typography variant="h2" sx={{ fontWeight: 700 }}>
                          {results.treatmentEffect.score}
                        </Typography>
                        <Typography variant="h5" sx={{ ml: 1 }}>/100</Typography>
                      </Box>
                      
                      <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                        {results.treatmentEffect.score > 70 ? (
                          <CheckCircleIcon color="success" sx={{ mr: 1 }} />
                        ) : results.treatmentEffect.score > 30 ? (
                          <WarningIcon sx={{ mr: 1, color: '#f57c00' }} />
                        ) : (
                          <WarningIcon color="error" sx={{ mr: 1 }} />
                        )}
                        <Typography variant="body1" fontWeight={500}>
                          {results.treatmentEffect.score > 70 ? 'Excellent Response' : 
                           results.treatmentEffect.score > 30 ? 'Moderate Response' : 'Poor Response'}
                        </Typography>
                      </Box>
                    </CardContent>
                  </Card>
                </Grid>
                
                <Grid item xs={12} md={8}>
                  <Card sx={{ height: '100%' }}>
                    <CardContent>
                      <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                        Comparative Metrics
                      </Typography>
                      
                      <Grid container spacing={2}>
                        <Grid item xs={12} sm={6}>
                          <Typography variant="subtitle2" color="textSecondary">Fluorescence Ratio (Post/Pre)</Typography>
                          <Typography variant="h5">{results.comparison.fluorescenceRatio.toFixed(2)}x</Typography>
                          <Typography variant="body2" color="textSecondary" sx={{ mt: 0.5 }}>
                            {results.comparison.fluorescenceRatio > 1.5 ? 'Significant increase' : 
                             results.comparison.fluorescenceRatio < 0.8 ? 'Significant decrease' : 'Minimal change'}
                          </Typography>
                        </Grid>
                        
                        <Grid item xs={12} sm={6}>
                          <Typography variant="subtitle2" color="textSecondary">Signal Change</Typography>
                          <Typography variant="h5" color={results.comparison.signalChange > 0 ? 'success.main' : 'error.main'}>
                            {results.comparison.signalChange > 0 ? '+' : ''}{results.comparison.signalChange.toFixed(2)}%
                          </Typography>
                          <Typography variant="body2" color="textSecondary" sx={{ mt: 0.5 }}>
                            {Math.abs(results.comparison.signalChange) > 30 ? 'Major change' : 'Minor change'} in fluorescence
                          </Typography>
                        </Grid>
                        
                        <Grid item xs={12} sm={6}>
                          <Typography variant="subtitle2" color="textSecondary">Distribution Similarity</Typography>
                          <Typography variant="h5">{results.comparison.distributionSimilarity.toFixed(2)}%</Typography>
                          <Typography variant="body2" color="textSecondary" sx={{ mt: 0.5 }}>
                            {results.comparison.distributionSimilarity > 80 ? 'Very similar patterns' : 
                             results.comparison.distributionSimilarity > 50 ? 'Moderately similar' : 'Distinct patterns'}
                          </Typography>
                        </Grid>
                        
                        <Grid item xs={12} sm={6}>
                          <Typography variant="subtitle2" color="textSecondary">Depth Penetration Change</Typography>
                          <Typography variant="h5" color={results.comparison.depthPenetrationChange > 0 ? 'success.main' : 'error.main'}>
                            {results.comparison.depthPenetrationChange > 0 ? '+' : ''}{results.comparison.depthPenetrationChange.toFixed(2)}%
                          </Typography>
                          <Typography variant="body2" color="textSecondary" sx={{ mt: 0.5 }}>
                            {Math.abs(results.comparison.depthPenetrationChange) > 20 ? 'Significant' : 'Minimal'} change in depth profile
                          </Typography>
                        </Grid>
                      </Grid>
                    </CardContent>
                  </Card>
                </Grid>
              </Grid>

              <Paper sx={{ p: 3, mt: 3, borderRadius: 2 }}>
                <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                  Clinical Interpretation
                </Typography>
                
                <Typography variant="body1" paragraph>
                  {results.interpretation.summary}
                </Typography>
                
                <Divider sx={{ my: 2 }} />
                
                <Typography variant="subtitle1" color="primary" fontWeight={600} sx={{ mb: 1 }}>
                  Key Findings:
                </Typography>
                
                <ul>
                  {results.interpretation.keyFindings.map((finding, index) => (
                    <Typography component="li" variant="body1" key={index} sx={{ mb: 1 }}>
                      {finding}
                    </Typography>
                  ))}
                </ul>
                
                <Divider sx={{ my: 2 }} />
                
                <Typography variant="subtitle1" color="primary" fontWeight={600} sx={{ mb: 1 }}>
                  Recommendations:
                </Typography>
                
                <ul>
                  {results.interpretation.recommendations.map((rec, index) => (
                    <Typography component="li" variant="body1" key={index} sx={{ mb: 1 }}>
                      {rec}
                    </Typography>
                  ))}
                </ul>
              </Paper>
            </Paper>
          </Grid>
        </Grid>
      )}
    </ResponsiveContainer>
  );
};

export default ImageAnalysis;