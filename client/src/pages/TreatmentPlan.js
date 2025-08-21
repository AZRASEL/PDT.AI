import React, { useState } from 'react';
import {
  Box,
  Button,
  Card,
  CardContent,
  CircularProgress,
  Divider,
  FormControl,
  FormControlLabel,
  FormLabel,
  Grid,
  InputAdornment,
  MenuItem,
  Paper,
  Radio,
  RadioGroup,
  Slider,
  TextField,
  Typography,
} from '@mui/material';
import CalculateIcon from '@mui/icons-material/Calculate';
import LightModeIcon from '@mui/icons-material/LightMode';
import ScienceIcon from '@mui/icons-material/Science';
import WarningIcon from '@mui/icons-material/Warning';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import axios from 'axios';
import ResponsiveContainer from '../components/layout/ResponsiveContainer';
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
  Title,
  Tooltip,
  Legend,
} from 'chart.js';
import { Line } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

const TreatmentPlan = () => {
  const [formData, setFormData] = useState({
    photosensitizer: 'ppix',
    wavelength: 635,
    fluence: 100,
    irradiance: 150,
    tissueType: 'oral_mucosa',
    tumorDepth: 3,
    tumorDiameter: 10,
    patientAge: 50,
    previousTreatments: 'none',
  });

  const [isLoading, setIsLoading] = useState(false);
  const [results, setResults] = useState(null);
  const [error, setError] = useState('');

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleSliderChange = (name) => (e, newValue) => {
    setFormData({
      ...formData,
      [name]: newValue,
    });
  };

  const calculateTreatment = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    setError('');
    
    // Announce to screen readers that calculation is in progress
    announceToScreenReader('Calculating treatment plan, please wait...');

    try {
      // For demo purposes, we'll simulate an API call with mock data
      // In production, this would be a real API call
      // const response = await axios.post('/api/treatment/calculate', formData);
      
      // Simulate API delay
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      // Mock response data
      const mockResults = {
        parameters: {
          penetrationDepth: (formData.wavelength / 100 - 2).toFixed(1),
          treatmentTime: Math.round(formData.fluence / formData.irradiance * 60),
          efficacy: Math.round(100 - (formData.tumorDepth / 10) * 100),
          fieldDiameter: Math.round(formData.tumorDiameter * 1.5)
        },
        charts: {
          lightPenetration: Array.from({length: 11}, (_, i) => 
            Math.round(100 * Math.exp(-0.2 * i * (650 / formData.wavelength)))),
          psActivation: Array.from({length: 11}, (_, i) => 
            Math.round(100 * Math.exp(-0.3 * i * (formData.photosensitizer === 'ppix' ? 1 : 1.2))))
        },
        safety: {
          maxFluence: formData.tissueType === 'oral_mucosa' ? 150 : 200,
          maxFluenceExceeded: formData.fluence > (formData.tissueType === 'oral_mucosa' ? 150 : 200),
          maxIrradiance: formData.tissueType === 'oral_mucosa' ? 200 : 250,
          maxIrradianceExceeded: formData.irradiance > (formData.tissueType === 'oral_mucosa' ? 200 : 250)
        },
        recommendations: {
          primary: `Based on the parameters provided, a ${formData.wavelength}nm light source with a fluence of ${formData.fluence}J/cm² delivered at ${formData.irradiance}mW/cm² is recommended for treating this ${formData.tissueType.replace('_', ' ')} lesion with ${formData.photosensitizer.toUpperCase()}.`,
          additional: [
            `Ensure adequate photosensitizer accumulation before light delivery.`,
            `Monitor patient comfort throughout the ${Math.round(formData.fluence / formData.irradiance * 60)} minute treatment.`,
            `Consider fractionated light delivery to enhance treatment efficacy.`,
            `Protect surrounding healthy tissue with appropriate shielding.`
          ]
        }
      };
      
      setResults(mockResults);
      
      // Announce results to screen readers
      announceToScreenReader('Treatment plan calculation complete. Results are now available.');
    } catch (err) {
      console.error('Error calculating treatment:', err);
      setError('Failed to calculate treatment parameters. Please try again.');
      announceToScreenReader('Error calculating treatment plan. Please try again.');
    } finally {
      setIsLoading(false);
    }
  };

  const renderLightPenetrationChart = () => {
    if (!results) return null;

    const data = {
      labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
      datasets: [
        {
          label: 'Light Intensity (%)',
          data: results.charts.lightPenetration,
          borderColor: '#3f51b5',
          backgroundColor: 'rgba(63, 81, 181, 0.1)',
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
          text: 'Light Penetration by Depth',
        },
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Depth (mm)',
          },
        },
        y: {
          title: {
            display: true,
            text: 'Relative Intensity (%)',
          },
          min: 0,
          max: 100,
        },
      },
    };

    return <Line data={data} options={options} />
  };

  const renderPsActivationChart = () => {
    if (!results) return null;

    const data = {
      labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
      datasets: [
        {
          label: 'Photosensitizer Activation (%)',
          data: results.charts.psActivation,
          borderColor: '#f50057',
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
          text: 'Photosensitizer Activation by Depth',
        },
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Depth (mm)',
          },
        },
        y: {
          title: {
            display: true,
            text: 'Activation Efficiency (%)',
          },
          min: 0,
          max: 100,
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
        id="treatment-calculator-heading"
      >
        Treatment Plan Calculator
      </Typography>
      
      <Typography 
        variant="h6" 
        align="center" 
        color="textSecondary" 
        sx={{ mb: 4 }}
      >
        Calculate optimal PDT parameters based on scientific models
      </Typography>

      <Grid container spacing={4}>
        <Grid item xs={12} md={5}>
          <Paper 
            component="form" 
            onSubmit={calculateTreatment}
            elevation={3} 
            sx={{ 
              p: 3, 
              borderRadius: 2
            }}
          >
            <Typography variant="h5" sx={{ mb: 3, fontWeight: 600 }}>
              <ScienceIcon sx={{ mr: 1, verticalAlign: 'middle' }} />
              Input Parameters
            </Typography>

            <AccessibleFormField
              id="photosensitizer"
              type="radio"
              label="Photosensitizer"
              value={formData.photosensitizer}
              onChange={handleInputChange}
              options={[
                { value: 'ppix', label: 'PpIX (Protoporphyrin IX)' },
                { value: 'photofrin', label: 'Photofrin (Porfimer Sodium)' },
                { value: 'foscan', label: 'Foscan (Temoporfin)' },
              ]}
              helperText="Select the photosensitizer used for treatment"
              required
              tooltipText="Different photosensitizers have different absorption spectra and activation wavelengths"
              fieldProps={{ row: true }}
            />

            <AccessibleFormField
              id="wavelength"
              type="slider"
              label="Wavelength (nm)"
              value={formData.wavelength}
              onChange={handleSliderChange('wavelength')}
              tooltipText="The wavelength of light used to activate the photosensitizer. Different photosensitizers have different optimal activation wavelengths."
              fieldProps={{
                min: 400,
                max: 700,
                step: 5,
                marks: [
                  { value: 400, label: '400' },
                  { value: 550, label: '550' },
                  { value: 700, label: '700' },
                ],
                valueLabelDisplay: "on",
              }}
              helperText={`Current value: ${formData.wavelength}nm (${formData.wavelength < 500 ? 'Blue-Violet' : formData.wavelength < 600 ? 'Green-Yellow' : 'Red'} light)`}
              required
            />

            <FormControl fullWidth sx={{ mb: 3 }}>
              <FormLabel id="fluence-label">Light Fluence (J/cm²)</FormLabel>
              <Grid container spacing={2} alignItems="center">
                <Grid item xs>
                  <Slider
                    value={formData.fluence}
                    onChange={handleSliderChange('fluence')}
                    min={10}
                    max={200}
                    step={5}
                    marks={[
                      { value: 10, label: '10' },
                      { value: 100, label: '100' },
                      { value: 200, label: '200' },
                    ]}
                    aria-labelledby="fluence-label"
                  />
                </Grid>
                <Grid item>
                  <TextField
                    value={formData.fluence}
                    onChange={handleInputChange}
                    name="fluence"
                    type="number"
                    InputProps={{
                      endAdornment: <InputAdornment position="end">J/cm²</InputAdornment>,
                    }}
                    inputProps={{
                      min: 10,
                      max: 200,
                      step: 5,
                    }}
                    sx={{ width: 120 }}
                  />
                </Grid>
              </Grid>
            </FormControl>

            <FormControl fullWidth sx={{ mb: 3 }}>
              <FormLabel id="irradiance-label">Irradiance (mW/cm²)</FormLabel>
              <Grid container spacing={2} alignItems="center">
                <Grid item xs>
                  <Slider
                    value={formData.irradiance}
                    onChange={handleSliderChange('irradiance')}
                    min={50}
                    max={300}
                    step={10}
                    marks={[
                      { value: 50, label: '50' },
                      { value: 150, label: '150' },
                      { value: 300, label: '300' },
                    ]}
                    aria-labelledby="irradiance-label"
                  />
                </Grid>
                <Grid item>
                  <TextField
                    value={formData.irradiance}
                    onChange={handleInputChange}
                    name="irradiance"
                    type="number"
                    InputProps={{
                      endAdornment: <InputAdornment position="end">mW/cm²</InputAdornment>,
                    }}
                    inputProps={{
                      min: 50,
                      max: 300,
                      step: 10,
                    }}
                    sx={{ width: 120 }}
                  />
                </Grid>
              </Grid>
            </FormControl>

            <AccessibleFormField
              id="tissueType"
              type="select"
              label="Tissue Type"
              value={formData.tissueType}
              onChange={handleInputChange}
              options={[
                { value: 'oral_mucosa', label: 'Oral Mucosa' },
                { value: 'tongue', label: 'Tongue' },
                { value: 'gingiva', label: 'Gingiva' },
                { value: 'buccal', label: 'Buccal Mucosa' },
                { value: 'floor_of_mouth', label: 'Floor of Mouth' },
              ]}
              helperText="Select the type of tissue being treated"
              tooltipText="Different tissues have different optical properties that affect light penetration"
              required
            />

            <Grid container spacing={3}>
              <Grid item xs={12} sm={6}>
                <FormControl fullWidth sx={{ mb: 3 }}>
                  <FormLabel>Tumor Depth (mm)</FormLabel>
                  <TextField
                    name="tumorDepth"
                    value={formData.tumorDepth}
                    onChange={handleInputChange}
                    type="number"
                    InputProps={{
                      endAdornment: <InputAdornment position="end">mm</InputAdornment>,
                    }}
                    inputProps={{
                      min: 0.5,
                      max: 10,
                      step: 0.5,
                    }}
                    sx={{ mt: 1 }}
                  />
                </FormControl>
              </Grid>
              <Grid item xs={12} sm={6}>
                <FormControl fullWidth sx={{ mb: 3 }}>
                  <FormLabel>Tumor Diameter (mm)</FormLabel>
                  <TextField
                    name="tumorDiameter"
                    value={formData.tumorDiameter}
                    onChange={handleInputChange}
                    type="number"
                    InputProps={{
                      endAdornment: <InputAdornment position="end">mm</InputAdornment>,
                    }}
                    inputProps={{
                      min: 1,
                      max: 50,
                      step: 1,
                    }}
                    sx={{ mt: 1 }}
                  />
                </FormControl>
              </Grid>
            </Grid>

            <Button
              type="submit"
              variant="contained"
              color="primary"
              fullWidth
              size="large"
              startIcon={isLoading ? <CircularProgress size={24} color="inherit" /> : <CalculateIcon />}
              disabled={isLoading}
              sx={{ mt: 2, py: 1.5 }}
              aria-live="polite"
              aria-busy={isLoading}
            >
              {isLoading ? 'Calculating...' : 'Calculate Treatment Plan'}
            </Button>
          </Paper>
        </Grid>

        <Grid item xs={12} md={7}>
          {error ? (
            <Paper sx={{ p: 3, bgcolor: '#fdeded', borderRadius: 2 }}>
              <Typography color="error" sx={{ display: 'flex', alignItems: 'center' }}>
                <WarningIcon sx={{ mr: 1 }} />
                {error}
              </Typography>
            </Paper>
          ) : isLoading ? (
            <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100%' }}>
              <CircularProgress />
            </Box>
          ) : results ? (
            <Box>
              <Paper sx={{ p: 3, mb: 3, borderRadius: 2 }}>
                <Typography variant="h5" sx={{ mb: 3, fontWeight: 600, display: 'flex', alignItems: 'center' }}>
                  <LightModeIcon sx={{ mr: 1 }} />
                  Treatment Parameters
                </Typography>

                <Grid container spacing={3}>
                  <Grid item xs={12} sm={6}>
                    <Typography variant="subtitle1" color="primary" fontWeight={600}>Penetration Depth</Typography>
                    <Typography variant="h4" sx={{ mb: 1 }}>{results.parameters.penetrationDepth} mm</Typography>
                    <Typography variant="body2" color="text.secondary">
                      Effective light penetration at {formData.wavelength}nm
                    </Typography>
                  </Grid>
                  
                  <Grid item xs={12} sm={6}>
                    <Typography variant="subtitle1" color="primary" fontWeight={600}>Treatment Time</Typography>
                    <Typography variant="h4" sx={{ mb: 1 }}>{results.parameters.treatmentTime} min</Typography>
                    <Typography variant="body2" color="text.secondary">
                      Based on {formData.fluence} J/cm² at {formData.irradiance} mW/cm²
                    </Typography>
                  </Grid>
                  
                  <Grid item xs={12} sm={6}>
                    <Typography variant="subtitle1" color="primary" fontWeight={600}>PDT Efficacy</Typography>
                    <Typography variant="h4" sx={{ mb: 1 }}>{results.parameters.efficacy}%</Typography>
                    <Typography variant="body2" color="text.secondary">
                      Estimated treatment effectiveness at tumor depth
                    </Typography>
                  </Grid>
                  
                  <Grid item xs={12} sm={6}>
                    <Typography variant="subtitle1" color="primary" fontWeight={600}>Treatment Field</Typography>
                    <Typography variant="h4" sx={{ mb: 1 }}>{results.parameters.fieldDiameter} mm</Typography>
                    <Typography variant="body2" color="text.secondary">
                      Recommended treatment area diameter
                    </Typography>
                  </Grid>
                </Grid>
              </Paper>

              <Grid container spacing={3} sx={{ mb: 3 }}>
                <Grid item xs={12} md={6}>
                  <Paper sx={{ p: 2, height: '100%', borderRadius: 2 }}>
                    {renderLightPenetrationChart()}
                  </Paper>
                </Grid>
                <Grid item xs={12} md={6}>
                  <Paper sx={{ p: 2, height: '100%', borderRadius: 2 }}>
                    {renderPsActivationChart()}
                  </Paper>
                </Grid>
              </Grid>

              <Paper sx={{ p: 3, mb: 3, borderRadius: 2 }}>
                <Typography variant="h5" sx={{ mb: 2, fontWeight: 600 }} id="safety-thresholds-heading">
                  Safety Thresholds
                </Typography>
                
                <AccessibleTable
                  caption="Safety Thresholds for PDT Treatment"
                  summary="This table shows the maximum safe fluence and irradiance values for the selected tissue type, and whether the current values exceed these thresholds."
                  ariaLabel="Safety thresholds table"
                  columns={[
                    { id: 'parameter', label: 'Parameter', width: '30%' },
                    { id: 'maxValue', label: 'Maximum Safe Value', width: '30%' },
                    { id: 'currentValue', label: 'Current Value', width: '20%' },
                    { id: 'status', label: 'Status', width: '20%' },
                  ]}
                  data={[
                    {
                      parameter: 'Light Fluence',
                      maxValue: `${results.safety.maxFluence} J/cm²`,
                      currentValue: `${formData.fluence} J/cm²`,
                      status: results.safety.maxFluenceExceeded ? 'Exceeds Threshold' : 'Within Limits',
                    },
                    {
                      parameter: 'Irradiance',
                      maxValue: `${results.safety.maxIrradiance} mW/cm²`,
                      currentValue: `${formData.irradiance} mW/cm²`,
                      status: results.safety.maxIrradianceExceeded ? 'Exceeds Threshold' : 'Within Limits',
                    },
                  ]}
                  striped
                  bordered
                  sx={{ mb: 2 }}
                />
                
                {(results.safety.maxFluenceExceeded || results.safety.maxIrradianceExceeded) && (
                  <Box 
                    sx={{ 
                      p: 2, 
                      bgcolor: '#fdeded', 
                      borderRadius: 1,
                      display: 'flex',
                      alignItems: 'flex-start'
                    }}
                    role="alert"
                  >
                    <WarningIcon color="error" sx={{ mr: 1, mt: 0.5 }} />
                    <Typography variant="body2" color="error">
                      Warning: One or more parameters exceed recommended safety thresholds for {formData.tissueType.replace('_', ' ')}. 
                      Consider adjusting these values to prevent potential tissue damage or side effects.
                    </Typography>
                  </Box>
                )}
              </Paper>

              <Paper sx={{ p: 3, borderRadius: 2 }}>
                <Typography variant="h5" sx={{ mb: 3, fontWeight: 600 }}>
                  Clinical Recommendations
                </Typography>
                
                <Typography variant="body1" paragraph>
                  {results.recommendations.primary}
                </Typography>
                
                <Divider sx={{ my: 2 }} />
                
                <Typography variant="subtitle1" color="primary" fontWeight={600} sx={{ mb: 1 }}>
                  Additional Considerations:
                </Typography>
                
                <ul>
                  {results.recommendations.additional.map((rec, index) => (
                    <Typography component="li" variant="body1" key={index} sx={{ mb: 1 }}>
                      {rec}
                    </Typography>
                  ))}
                </ul>
              </Paper>
            </Box>
          ) : (
            <Box sx={{ 
              display: 'flex', 
              flexDirection: 'column', 
              justifyContent: 'center', 
              alignItems: 'center', 
              height: '100%',
              p: 4,
              bgcolor: '#f5f5f5',
              borderRadius: 2
            }}>
              <CalculateIcon sx={{ fontSize: 60, color: 'text.secondary', opacity: 0.3, mb: 2 }} />
              <Typography variant="h6" color="textSecondary" align="center">
                Enter treatment parameters and calculate to see PDT recommendations
              </Typography>
              <Typography variant="body1" color="textSecondary" align="center" sx={{ mt: 2 }}>
                The calculator will provide penetration depth, treatment time, and efficacy estimates
              </Typography>
            </Box>
          )}
        </Grid>
      </Grid>
    </ResponsiveContainer>
  );
};

export default TreatmentPlan;