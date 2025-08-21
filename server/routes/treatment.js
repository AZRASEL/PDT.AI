const express = require('express');
const router = express.Router();

/**
 * @route   POST api/treatment/calculate
 * @desc    Calculate PDT treatment parameters
 * @access  Public
 */
router.post('/calculate', (req, res) => {
  try {
    const {
      photosensitizer,
      photosensitizer_dose,
      wavelength,
      light_fluence,
      tissue_type,
      treatment_area,
      patient_age,
      melanin_content,
      hemoglobin_content
    } = req.body;

    // Validate input parameters
    if (!photosensitizer || !wavelength || !light_fluence || !tissue_type) {
      return res.status(400).json({ msg: 'Missing required parameters' });
    }

    // Calculate effective penetration depth based on tissue optical properties
    // This is a simplified model - in a real application, this would be more complex
    const penetration_depth = calculatePenetrationDepth(
      wavelength,
      tissue_type,
      melanin_content,
      hemoglobin_content
    );

    // Calculate effective treatment depth
    const effective_treatment_depth = penetration_depth * 2.3; // Rule of thumb: effective depth ≈ 2.3 * penetration depth

    // Calculate treatment time based on light fluence and power density
    const power_density = 100; // mW/cm² (typical value, would be input in real app)
    const treatment_time = (light_fluence / power_density) * 60; // Convert to minutes

    // Calculate photosensitizer activation efficiency
    const activation_efficiency = calculateActivationEfficiency(photosensitizer, wavelength);

    // Calculate expected PDT efficacy
    const pdt_efficacy = calculatePDTEfficacy(
      photosensitizer,
      photosensitizer_dose,
      light_fluence,
      activation_efficiency,
      tissue_type
    );

    // Calculate safety thresholds
    const max_safe_fluence = calculateMaxSafeFluence(tissue_type, patient_age);
    const max_safe_irradiance = calculateMaxSafeIrradiance(tissue_type);

    // Prepare treatment recommendations
    const recommendations = generateRecommendations(
      photosensitizer,
      wavelength,
      light_fluence,
      max_safe_fluence,
      treatment_time,
      effective_treatment_depth,
      pdt_efficacy
    );

    // Return calculated parameters
    res.json({
      treatment_parameters: {
        penetration_depth: parseFloat(penetration_depth.toFixed(2)), // mm
        effective_treatment_depth: parseFloat(effective_treatment_depth.toFixed(2)), // mm
        treatment_time: parseFloat(treatment_time.toFixed(1)), // minutes
        activation_efficiency: parseFloat(activation_efficiency.toFixed(2)), // 0-1 scale
        pdt_efficacy: parseFloat(pdt_efficacy.toFixed(2)), // 0-1 scale
      },
      safety_thresholds: {
        max_safe_fluence: parseFloat(max_safe_fluence.toFixed(1)), // J/cm²
        max_safe_irradiance: parseFloat(max_safe_irradiance.toFixed(1)), // mW/cm²
        is_safe: light_fluence <= max_safe_fluence
      },
      recommendations
    });
  } catch (err) {
    console.error('Error calculating treatment parameters:', err.message);
    res.status(500).send('Server Error');
  }
});

/**
 * Calculate light penetration depth based on tissue optical properties
 * @param {number} wavelength - Light wavelength in nm
 * @param {string} tissue_type - Type of tissue
 * @param {number} melanin_content - Relative melanin content (0-1)
 * @param {number} hemoglobin_content - Relative hemoglobin content (0-1)
 * @returns {number} Penetration depth in mm
 */
function calculatePenetrationDepth(wavelength, tissue_type, melanin_content = 0.5, hemoglobin_content = 0.5) {
  // Base penetration depth values for different wavelengths (simplified model)
  // These values are approximations based on literature
  let base_depth;
  
  if (wavelength < 500) {
    base_depth = 0.5; // Very shallow for UV and blue light
  } else if (wavelength < 600) {
    base_depth = 1.5; // Green-yellow light
  } else if (wavelength < 700) {
    base_depth = 3.0; // Red light
  } else if (wavelength < 850) {
    base_depth = 4.0; // Deep red / Near-IR
  } else {
    base_depth = 5.0; // Near-IR
  }

  // Tissue-specific modifiers
  let tissue_modifier;
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      tissue_modifier = 1.0;
      break;
    case 'oral mucosa':
      tissue_modifier = 1.3; // Less scattering than skin
      break;
    case 'muscle':
      tissue_modifier = 0.8; // More dense
      break;
    case 'brain':
      tissue_modifier = 1.2; // Less scattering
      break;
    case 'liver':
      tissue_modifier = 0.7; // Very dense and vascular
      break;
    default:
      tissue_modifier = 1.0;
  }

  // Apply melanin and hemoglobin effects
  // Melanin absorbs strongly in UV and visible range, less in NIR
  const melanin_effect = 1 - (melanin_content * (1 - Math.min(wavelength / 1000, 1)));
  
  // Hemoglobin has specific absorption peaks
  let hemoglobin_effect;
  if ((wavelength > 400 && wavelength < 450) || (wavelength > 500 && wavelength < 600)) {
    // High absorption bands of hemoglobin
    hemoglobin_effect = 1 - (hemoglobin_content * 0.7);
  } else {
    hemoglobin_effect = 1 - (hemoglobin_content * 0.3);
  }

  // Calculate final penetration depth
  return base_depth * tissue_modifier * melanin_effect * hemoglobin_effect;
}

/**
 * Calculate photosensitizer activation efficiency at given wavelength
 * @param {string} photosensitizer - Type of photosensitizer
 * @param {number} wavelength - Light wavelength in nm
 * @returns {number} Activation efficiency (0-1)
 */
function calculateActivationEfficiency(photosensitizer, wavelength) {
  // Simplified absorption spectra for common photosensitizers
  let efficiency = 0;
  
  switch (photosensitizer.toLowerCase()) {
    case 'ppix':
    case '5-ala':
    case 'aminolevulinic acid':
      // PpIX has peaks at ~410nm and ~630nm
      if (wavelength >= 625 && wavelength <= 640) {
        efficiency = 0.8 - Math.abs(wavelength - 632) * 0.04;
      } else if (wavelength >= 400 && wavelength <= 420) {
        efficiency = 1.0 - Math.abs(wavelength - 410) * 0.05;
      } else {
        efficiency = 0.1; // Background activation
      }
      break;
      
    case 'photofrin':
    case 'porfimer sodium':
      // Photofrin has peaks at ~400nm and ~630nm
      if (wavelength >= 625 && wavelength <= 640) {
        efficiency = 0.7 - Math.abs(wavelength - 632) * 0.03;
      } else if (wavelength >= 395 && wavelength <= 415) {
        efficiency = 0.9 - Math.abs(wavelength - 405) * 0.04;
      } else {
        efficiency = 0.1; // Background activation
      }
      break;
      
    case 'verteporfin':
    case 'visudyne':
      // Verteporfin has peak at ~690nm
      if (wavelength >= 680 && wavelength <= 700) {
        efficiency = 0.9 - Math.abs(wavelength - 690) * 0.04;
      } else {
        efficiency = 0.1; // Background activation
      }
      break;
      
    case 'methylene blue':
      // Methylene Blue has peak at ~660nm
      if (wavelength >= 650 && wavelength <= 670) {
        efficiency = 0.8 - Math.abs(wavelength - 660) * 0.04;
      } else {
        efficiency = 0.1; // Background activation
      }
      break;
      
    default:
      efficiency = 0.5; // Default value for unknown photosensitizers
  }
  
  return Math.max(0, Math.min(1, efficiency)); // Ensure value is between 0 and 1
}

/**
 * Calculate expected PDT efficacy based on treatment parameters
 * @param {string} photosensitizer - Type of photosensitizer
 * @param {number} photosensitizer_dose - Dose in mg/kg
 * @param {number} light_fluence - Light fluence in J/cm²
 * @param {number} activation_efficiency - Activation efficiency (0-1)
 * @param {string} tissue_type - Type of tissue
 * @returns {number} PDT efficacy score (0-1)
 */
function calculatePDTEfficacy(
  photosensitizer,
  photosensitizer_dose,
  light_fluence,
  activation_efficiency,
  tissue_type
) {
  // Base efficacy from light and photosensitizer interaction
  let base_efficacy = activation_efficiency * (1 - Math.exp(-0.05 * light_fluence));
  
  // Dose response (simplified model)
  let dose_factor;
  if (!photosensitizer_dose) {
    dose_factor = 0.5; // Default if dose not provided
  } else {
    // Sigmoid-like response curve
    const optimal_dose = getOptimalDose(photosensitizer);
    dose_factor = 1 / (1 + Math.exp(-5 * (photosensitizer_dose / optimal_dose - 0.7)));
  }
  
  // Tissue-specific response
  let tissue_factor;
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      tissue_factor = 0.8;
      break;
    case 'oral mucosa':
      tissue_factor = 0.9; // Generally good response
      break;
    case 'muscle':
      tissue_factor = 0.6; // Less responsive
      break;
    case 'brain':
      tissue_factor = 0.7;
      break;
    case 'liver':
      tissue_factor = 0.75;
      break;
    default:
      tissue_factor = 0.7;
  }
  
  return base_efficacy * dose_factor * tissue_factor;
}

/**
 * Get optimal photosensitizer dose
 * @param {string} photosensitizer - Type of photosensitizer
 * @returns {number} Optimal dose in mg/kg
 */
function getOptimalDose(photosensitizer) {
  switch (photosensitizer.toLowerCase()) {
    case 'ppix':
    case '5-ala':
    case 'aminolevulinic acid':
      return 20; // mg/kg for systemic, or 20% concentration for topical
    case 'photofrin':
    case 'porfimer sodium':
      return 2; // mg/kg
    case 'verteporfin':
    case 'visudyne':
      return 6; // mg/m²
    case 'methylene blue':
      return 1; // mg/kg
    default:
      return 2; // Default value
  }
}

/**
 * Calculate maximum safe light fluence
 * @param {string} tissue_type - Type of tissue
 * @param {number} patient_age - Patient age in years
 * @returns {number} Maximum safe fluence in J/cm²
 */
function calculateMaxSafeFluence(tissue_type, patient_age = 50) {
  // Base safe fluence values for different tissues
  let base_max_fluence;
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      base_max_fluence = 200;
      break;
    case 'oral mucosa':
      base_max_fluence = 150;
      break;
    case 'muscle':
      base_max_fluence = 100;
      break;
    case 'brain':
      base_max_fluence = 50;
      break;
    case 'liver':
      base_max_fluence = 120;
      break;
    default:
      base_max_fluence = 100;
  }
  
  // Age adjustment factor (older patients may have reduced tolerance)
  const age_factor = patient_age > 65 ? 0.8 : 1.0;
  
  return base_max_fluence * age_factor;
}

/**
 * Calculate maximum safe irradiance (power density)
 * @param {string} tissue_type - Type of tissue
 * @returns {number} Maximum safe irradiance in mW/cm²
 */
function calculateMaxSafeIrradiance(tissue_type) {
  // Maximum safe irradiance to avoid thermal damage
  switch (tissue_type.toLowerCase()) {
    case 'skin':
      return 200;
    case 'oral mucosa':
      return 150;
    case 'muscle':
      return 120;
    case 'brain':
      return 80;
    case 'liver':
      return 100;
    default:
      return 120;
  }
}

/**
 * Generate treatment recommendations based on calculated parameters
 * @param {string} photosensitizer - Type of photosensitizer
 * @param {number} wavelength - Light wavelength in nm
 * @param {number} light_fluence - Light fluence in J/cm²
 * @param {number} max_safe_fluence - Maximum safe fluence in J/cm²
 * @param {number} treatment_time - Calculated treatment time in minutes
 * @param {number} effective_treatment_depth - Effective treatment depth in mm
 * @param {number} pdt_efficacy - Calculated PDT efficacy (0-1)
 * @returns {Array} Array of recommendation strings
 */
function generateRecommendations(
  photosensitizer,
  wavelength,
  light_fluence,
  max_safe_fluence,
  treatment_time,
  effective_treatment_depth,
  pdt_efficacy
) {
  const recommendations = [];
  
  // Fluence recommendations
  if (light_fluence < 0.5 * max_safe_fluence && pdt_efficacy < 0.7) {
    recommendations.push(
      `Consider increasing light fluence to ${Math.round(max_safe_fluence * 0.7)} J/cm² to improve treatment efficacy.`
    );
  } else if (light_fluence > 0.9 * max_safe_fluence) {
    recommendations.push(
      `Light fluence is near maximum safe threshold. Consider reducing to ${Math.round(max_safe_fluence * 0.8)} J/cm² to improve safety margin.`
    );
  }
  
  // Wavelength optimization
  const optimal_wavelength = getOptimalWavelength(photosensitizer);
  if (Math.abs(wavelength - optimal_wavelength) > 10) {
    recommendations.push(
      `For optimal ${photosensitizer} activation, consider adjusting wavelength to ${optimal_wavelength} nm.`
    );
  }
  
  // Treatment time recommendations
  if (treatment_time > 30) {
    recommendations.push(
      `Treatment time of ${Math.round(treatment_time)} minutes is relatively long. Consider increasing power density to reduce treatment time.`
    );
  }
  
  // Depth recommendations
  if (effective_treatment_depth < 2 && wavelength < 650) {
    recommendations.push(
      `For deeper tissue penetration, consider using longer wavelength light (650-800 nm).`
    );
  }
  
  // General efficacy recommendations
  if (pdt_efficacy < 0.5) {
    recommendations.push(
      `Predicted treatment efficacy is low. Consider optimizing photosensitizer dose, light parameters, or treatment protocol.`
    );
  } else if (pdt_efficacy > 0.8) {
    recommendations.push(
      `Predicted treatment efficacy is excellent. Maintain current parameters.`
    );
  }
  
  // Add default recommendation if none generated
  if (recommendations.length === 0) {
    recommendations.push(
      `Treatment parameters appear appropriate. Proceed with standard protocol.`
    );
  }
  
  return recommendations;
}

/**
 * Get optimal wavelength for photosensitizer
 * @param {string} photosensitizer - Type of photosensitizer
 * @returns {number} Optimal wavelength in nm
 */
function getOptimalWavelength(photosensitizer) {
  switch (photosensitizer.toLowerCase()) {
    case 'ppix':
    case '5-ala':
    case 'aminolevulinic acid':
      return 635; // Red peak for PpIX
    case 'photofrin':
    case 'porfimer sodium':
      return 630;
    case 'verteporfin':
    case 'visudyne':
      return 690;
    case 'methylene blue':
      return 660;
    default:
      return 630; // Default value
  }
}

module.exports = router;