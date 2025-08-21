const express = require('express');
const router = express.Router();

/**
 * @route   POST api/analysis/fluorescence
 * @desc    Analyze PpIX fluorescence images
 * @access  Public
 */
router.post('/fluorescence', (req, res) => {
  try {
    const {
      pre_treatment_data,
      post_treatment_data,
      tissue_type,
      excitation_wavelength,
      emission_wavelength,
      background_correction,
      normalization_method
    } = req.body;

    // Validate input parameters
    if (!pre_treatment_data || !tissue_type) {
      return res.status(400).json({ msg: 'Missing required parameters' });
    }

    // Process pre-treatment data
    const pre_treatment_results = processImageData(
      pre_treatment_data,
      tissue_type,
      excitation_wavelength,
      emission_wavelength,
      background_correction,
      normalization_method
    );

    // Process post-treatment data if available
    let post_treatment_results = null;
    let comparison_results = null;

    if (post_treatment_data) {
      post_treatment_results = processImageData(
        post_treatment_data,
        tissue_type,
        excitation_wavelength,
        emission_wavelength,
        background_correction,
        normalization_method
      );

      // Compare pre and post treatment results
      comparison_results = compareResults(pre_treatment_results, post_treatment_results);
    }

    // Generate analysis report
    const report = generateAnalysisReport(
      pre_treatment_results,
      post_treatment_results,
      comparison_results,
      tissue_type
    );

    res.json({
      pre_treatment: pre_treatment_results,
      post_treatment: post_treatment_results,
      comparison: comparison_results,
      report
    });
  } catch (err) {
    console.error('Error analyzing fluorescence data:', err.message);
    res.status(500).send('Server Error');
  }
});

/**
 * Process image data to extract fluorescence metrics
 * @param {Object} image_data - Raw image data or pixel intensity values
 * @param {string} tissue_type - Type of tissue being analyzed
 * @param {number} excitation_wavelength - Excitation wavelength in nm
 * @param {number} emission_wavelength - Emission wavelength in nm
 * @param {boolean} background_correction - Whether to apply background correction
 * @param {string} normalization_method - Method for normalization
 * @returns {Object} Processed image metrics
 */
function processImageData(
  image_data,
  tissue_type,
  excitation_wavelength = 405,
  emission_wavelength = 635,
  background_correction = true,
  normalization_method = 'max'
) {
  // In a real application, this would process actual image data
  // For this example, we'll simulate the processing

  // Extract intensity values (assuming image_data contains pixel values or histogram)
  let intensity_values = image_data.intensity || image_data;
  
  // Apply background correction if requested
  if (background_correction && image_data.background) {
    intensity_values = applyBackgroundCorrection(intensity_values, image_data.background);
  }
  
  // Apply tissue-specific corrections
  intensity_values = applyTissueCorrection(intensity_values, tissue_type);
  
  // Calculate fluorescence metrics
  const mean_intensity = calculateMean(intensity_values);
  const max_intensity = Math.max(...intensity_values);
  const min_intensity = Math.min(...intensity_values);
  const std_deviation = calculateStdDeviation(intensity_values, mean_intensity);
  
  // Calculate region-specific metrics if regions are defined
  let region_metrics = {};
  if (image_data.regions) {
    for (const [region_name, region_data] of Object.entries(image_data.regions)) {
      region_metrics[region_name] = {
        mean_intensity: calculateMean(region_data),
        max_intensity: Math.max(...region_data),
        relative_intensity: calculateMean(region_data) / mean_intensity
      };
    }
  }
  
  // Apply normalization if requested
  let normalized_values;
  switch (normalization_method.toLowerCase()) {
    case 'max':
      normalized_values = intensity_values.map(val => val / max_intensity);
      break;
    case 'mean':
      normalized_values = intensity_values.map(val => val / mean_intensity);
      break;
    case 'minmax':
      normalized_values = intensity_values.map(
        val => (val - min_intensity) / (max_intensity - min_intensity)
      );
      break;
    default:
      normalized_values = intensity_values;
  }
  
  // Calculate histogram for visualization
  const histogram = calculateHistogram(intensity_values, 20);
  
  // Return processed metrics
  return {
    mean_intensity,
    max_intensity,
    min_intensity,
    std_deviation,
    coefficient_of_variation: std_deviation / mean_intensity,
    region_metrics,
    histogram,
    normalized_values: normalized_values.slice(0, 100), // Return subset for API response
    tissue_type,
    excitation_wavelength,
    emission_wavelength
  };
}

/**
 * Apply background correction to intensity values
 * @param {Array} intensity_values - Raw intensity values
 * @param {Array|number} background - Background intensity values or single value
 * @returns {Array} Corrected intensity values
 */
function applyBackgroundCorrection(intensity_values, background) {
  // If background is a single value, subtract from all intensities
  if (typeof background === 'number') {
    return intensity_values.map(val => Math.max(0, val - background));
  }
  
  // If background is an array, subtract corresponding values
  if (Array.isArray(background) && background.length === intensity_values.length) {
    return intensity_values.map((val, i) => Math.max(0, val - background[i]));
  }
  
  // If background is an array but different length, use mean
  if (Array.isArray(background)) {
    const bg_mean = calculateMean(background);
    return intensity_values.map(val => Math.max(0, val - bg_mean));
  }
  
  // Default: return original values
  return intensity_values;
}

/**
 * Apply tissue-specific corrections to intensity values
 * @param {Array} intensity_values - Raw intensity values
 * @param {string} tissue_type - Type of tissue
 * @returns {Array} Corrected intensity values
 */
function applyTissueCorrection(intensity_values, tissue_type) {
  // Apply tissue-specific correction factors
  // These would be based on optical properties of different tissues
  let correction_factor;
  
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      correction_factor = 1.2; // Higher correction due to melanin and scattering
      break;
    case 'oral mucosa':
      correction_factor = 1.0; // Reference tissue
      break;
    case 'muscle':
      correction_factor = 1.3; // Higher correction due to myoglobin
      break;
    case 'brain':
      correction_factor = 0.9; // Less correction needed
      break;
    case 'liver':
      correction_factor = 1.4; // Higher correction due to blood content
      break;
    default:
      correction_factor = 1.0;
  }
  
  return intensity_values.map(val => val * correction_factor);
}

/**
 * Calculate mean of array values
 * @param {Array} values - Array of numeric values
 * @returns {number} Mean value
 */
function calculateMean(values) {
  return values.reduce((sum, val) => sum + val, 0) / values.length;
}

/**
 * Calculate standard deviation of array values
 * @param {Array} values - Array of numeric values
 * @param {number} mean - Mean value (optional)
 * @returns {number} Standard deviation
 */
function calculateStdDeviation(values, mean = null) {
  const avg = mean !== null ? mean : calculateMean(values);
  const squareDiffs = values.map(val => Math.pow(val - avg, 2));
  return Math.sqrt(calculateMean(squareDiffs));
}

/**
 * Calculate histogram from array values
 * @param {Array} values - Array of numeric values
 * @param {number} bins - Number of histogram bins
 * @returns {Object} Histogram data with bins and counts
 */
function calculateHistogram(values, bins = 10) {
  const min = Math.min(...values);
  const max = Math.max(...values);
  const range = max - min;
  const bin_width = range / bins;
  
  // Initialize bins
  const histogram = {
    bin_edges: Array(bins + 1).fill(0).map((_, i) => min + i * bin_width),
    counts: Array(bins).fill(0)
  };
  
  // Count values in each bin
  values.forEach(val => {
    const bin_index = Math.min(Math.floor((val - min) / bin_width), bins - 1);
    histogram.counts[bin_index]++;
  });
  
  return histogram;
}

/**
 * Compare pre and post treatment results
 * @param {Object} pre_results - Pre-treatment analysis results
 * @param {Object} post_results - Post-treatment analysis results
 * @returns {Object} Comparison metrics
 */
function compareResults(pre_results, post_results) {
  if (!pre_results || !post_results) {
    return null;
  }
  
  // Calculate percentage changes
  const mean_intensity_change = (
    (post_results.mean_intensity - pre_results.mean_intensity) / pre_results.mean_intensity
  ) * 100;
  
  const max_intensity_change = (
    (post_results.max_intensity - pre_results.max_intensity) / pre_results.max_intensity
  ) * 100;
  
  // Calculate region-specific changes if available
  const region_changes = {};
  if (pre_results.region_metrics && post_results.region_metrics) {
    for (const region in pre_results.region_metrics) {
      if (post_results.region_metrics[region]) {
        const pre_mean = pre_results.region_metrics[region].mean_intensity;
        const post_mean = post_results.region_metrics[region].mean_intensity;
        
        region_changes[region] = {
          mean_intensity_change: ((post_mean - pre_mean) / pre_mean) * 100,
          relative_change: (
            post_results.region_metrics[region].relative_intensity -
            pre_results.region_metrics[region].relative_intensity
          )
        };
      }
    }
  }
  
  // Calculate photobleaching ratio
  const photobleaching_ratio = post_results.mean_intensity / pre_results.mean_intensity;
  
  return {
    mean_intensity_change,
    max_intensity_change,
    region_changes,
    photobleaching_ratio,
    treatment_effect_score: calculateTreatmentEffectScore(
      mean_intensity_change,
      photobleaching_ratio,
      pre_results.tissue_type
    )
  };
}

/**
 * Calculate treatment effect score based on fluorescence changes
 * @param {number} mean_intensity_change - Percentage change in mean intensity
 * @param {number} photobleaching_ratio - Ratio of post/pre treatment intensity
 * @param {string} tissue_type - Type of tissue
 * @returns {Object} Treatment effect score and interpretation
 */
function calculateTreatmentEffectScore(
  mean_intensity_change,
  photobleaching_ratio,
  tissue_type
) {
  // Effective PDT typically results in photobleaching (reduced fluorescence)
  // A good response would show negative mean_intensity_change
  
  // Base score on photobleaching ratio (lower is better, indicates more photobleaching)
  let base_score = 10 * (1 - photobleaching_ratio);
  
  // Adjust for tissue type
  let tissue_factor;
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      tissue_factor = 1.0;
      break;
    case 'oral mucosa':
      tissue_factor = 1.2; // Oral mucosa typically shows stronger photobleaching
      break;
    case 'muscle':
      tissue_factor = 0.8; // Muscle may show less photobleaching
      break;
    default:
      tissue_factor = 1.0;
  }
  
  // Calculate final score (0-10 scale)
  const score = Math.max(0, Math.min(10, base_score * tissue_factor));
  
  // Generate interpretation
  let interpretation;
  if (score >= 8) {
    interpretation = 'Excellent treatment response with significant photobleaching';
  } else if (score >= 6) {
    interpretation = 'Good treatment response with moderate photobleaching';
  } else if (score >= 4) {
    interpretation = 'Moderate treatment response with some photobleaching';
  } else if (score >= 2) {
    interpretation = 'Limited treatment response with minimal photobleaching';
  } else {
    interpretation = 'Poor treatment response with negligible photobleaching';
  }
  
  return {
    score: parseFloat(score.toFixed(1)),
    interpretation
  };
}

/**
 * Generate comprehensive analysis report
 * @param {Object} pre_results - Pre-treatment analysis results
 * @param {Object} post_results - Post-treatment analysis results
 * @param {Object} comparison - Comparison results
 * @param {string} tissue_type - Type of tissue
 * @returns {Object} Analysis report
 */
function generateAnalysisReport(pre_results, post_results, comparison, tissue_type) {
  const report = {
    summary: '',
    findings: [],
    recommendations: []
  };
  
  // Generate summary
  if (pre_results && !post_results) {
    // Pre-treatment only
    report.summary = `PpIX fluorescence analysis of ${tissue_type} tissue shows a mean intensity of ${pre_results.mean_intensity.toFixed(1)} units with a coefficient of variation of ${(pre_results.coefficient_of_variation * 100).toFixed(1)}%.`;
    
    // Add findings based on pre-treatment data
    if (pre_results.mean_intensity > 100) {
      report.findings.push('High photosensitizer accumulation detected, indicating good uptake.');
    } else if (pre_results.mean_intensity < 30) {
      report.findings.push('Low photosensitizer accumulation detected, which may result in suboptimal PDT response.');
    }
    
    if (pre_results.coefficient_of_variation > 0.5) {
      report.findings.push('High variability in photosensitizer distribution, suggesting heterogeneous uptake.');
    }
    
    // Add recommendations
    if (pre_results.mean_intensity < 30) {
      report.recommendations.push('Consider extending photosensitizer incubation time or adjusting dose.');
    }
    
    report.recommendations.push('Proceed with PDT treatment using standard protocol for this tissue type.');
  } else if (pre_results && post_results && comparison) {
    // Pre and post treatment comparison
    report.summary = `Comparison of pre and post-treatment PpIX fluorescence in ${tissue_type} tissue shows a ${Math.abs(comparison.mean_intensity_change).toFixed(1)}% ${comparison.mean_intensity_change < 0 ? 'decrease' : 'increase'} in mean intensity, with a photobleaching ratio of ${comparison.photobleaching_ratio.toFixed(2)}.`;
    
    // Add findings based on comparison
    report.findings.push(`Treatment effect score: ${comparison.treatment_effect_score.score}/10 - ${comparison.treatment_effect_score.interpretation}`);
    
    if (comparison.mean_intensity_change < -50) {
      report.findings.push('Significant photobleaching observed, indicating effective photodynamic reaction.');
    } else if (comparison.mean_intensity_change > 0) {
      report.findings.push('Increased fluorescence post-treatment, which is unusual and may indicate incomplete treatment or measurement error.');
    }
    
    // Add region-specific findings if available
    if (comparison.region_changes && Object.keys(comparison.region_changes).length > 0) {
      for (const [region, changes] of Object.entries(comparison.region_changes)) {
        if (changes.mean_intensity_change < -70) {
          report.findings.push(`Region "${region}" shows excellent response with ${Math.abs(changes.mean_intensity_change).toFixed(1)}% decrease in fluorescence.`);
        } else if (changes.mean_intensity_change > 0) {
          report.findings.push(`Region "${region}" shows unusual increase in fluorescence by ${changes.mean_intensity_change.toFixed(1)}%.`);
        }
      }
    }
    
    // Add recommendations
    if (comparison.treatment_effect_score.score < 4) {
      report.recommendations.push('Consider follow-up treatment with adjusted parameters due to limited photobleaching response.');
    } else if (comparison.treatment_effect_score.score >= 8) {
      report.recommendations.push('Excellent treatment response. Standard follow-up protocol recommended.');
    } else {
      report.recommendations.push('Moderate treatment response. Consider standard follow-up with potential for retreatment assessment.');
    }
  }
  
  return report;
}

module.exports = router;