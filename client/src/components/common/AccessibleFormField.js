import React from 'react';
import {
  TextField,
  FormControl,
  FormHelperText,
  InputLabel,
  Select,
  MenuItem,
  Checkbox,
  FormControlLabel,
  Radio,
  RadioGroup,
  FormLabel,
  FormGroup,
  Switch,
  Slider,
  Typography,
  Box,
  Tooltip,
  IconButton,
} from '@mui/material';
import HelpOutlineIcon from '@mui/icons-material/HelpOutline';
import { getAccessibleFormFieldProps } from '../../utils/accessibilityUtils';

/**
 * AccessibleFormField component provides an accessible form field with proper ARIA attributes,
 * validation, and error handling.
 * 
 * @param {Object} props - Component props
 * @param {string} props.id - Unique ID for the form field
 * @param {string} props.type - Type of form field (text, select, checkbox, radio, switch, slider)
 * @param {string} props.label - Label for the form field
 * @param {string} [props.helperText] - Helper text for the form field
 * @param {string} [props.errorText] - Error text for the form field
 * @param {boolean} [props.required] - Whether the field is required
 * @param {boolean} [props.disabled] - Whether the field is disabled
 * @param {boolean} [props.fullWidth] - Whether the field should take up the full width
 * @param {string} [props.tooltipText] - Text to display in a tooltip
 * @param {Function} [props.onChange] - Callback when the field value changes
 * @param {Function} [props.onBlur] - Callback when the field loses focus
 * @param {Array} [props.options] - Options for select, radio, or checkbox group fields
 * @param {Object} [props.fieldProps] - Additional props for the specific field type
 * @param {Object} [props.sx] - Additional MUI system props
 */
const AccessibleFormField = ({
  id,
  type = 'text',
  label,
  helperText,
  errorText,
  required = false,
  disabled = false,
  fullWidth = true,
  tooltipText,
  onChange,
  onBlur,
  options = [],
  fieldProps = {},
  sx = {},
  ...rest
}) => {
  // Get accessible props for the form field
  const accessibleProps = getAccessibleFormFieldProps({
    id,
    type,
    label,
    required,
    disabled,
    hasError: !!errorText,
  });

  // Helper to render a tooltip icon if tooltipText is provided
  const renderTooltip = () => {
    if (!tooltipText) return null;
    
    return (
      <Tooltip title={tooltipText} arrow placement="top">
        <IconButton 
          aria-label={`Help for ${label}`} 
          size="small" 
          sx={{ ml: 0.5, p: 0.5 }}
          tabIndex={0}
        >
          <HelpOutlineIcon fontSize="small" />
        </IconButton>
      </Tooltip>
    );
  };

  // Helper to render the appropriate form field based on type
  const renderField = () => {
    const hasError = !!errorText;
    const commonProps = {
      id,
      required,
      disabled,
      error: hasError,
      onChange,
      onBlur,
      ...accessibleProps,
      ...fieldProps,
    };

    switch (type) {
      case 'text':
      case 'email':
      case 'password':
      case 'number':
      case 'tel':
      case 'url':
      case 'date':
      case 'datetime-local':
      case 'time':
      case 'month':
      case 'week':
      case 'color':
        return (
          <TextField
            label={label}
            type={type}
            helperText={errorText || helperText}
            fullWidth={fullWidth}
            {...commonProps}
          />
        );

      case 'textarea':
        return (
          <TextField
            label={label}
            multiline
            rows={fieldProps.rows || 4}
            helperText={errorText || helperText}
            fullWidth={fullWidth}
            {...commonProps}
          />
        );

      case 'select':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
          >
            <InputLabel id={`${id}-label`}>{label}</InputLabel>
            <Select
              labelId={`${id}-label`}
              label={label}
              {...commonProps}
            >
              {options.map((option) => (
                <MenuItem 
                  key={option.value} 
                  value={option.value}
                  disabled={option.disabled}
                >
                  {option.label}
                </MenuItem>
              ))}
            </Select>
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      case 'checkbox':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
            component="fieldset"
          >
            <FormControlLabel
              control={
                <Checkbox
                  {...commonProps}
                />
              }
              label={(
                <Box component="span" sx={{ display: 'flex', alignItems: 'center' }}>
                  {label}
                  {renderTooltip()}
                </Box>
              )}
            />
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      case 'checkbox-group':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
            component="fieldset"
          >
            <FormLabel component="legend" id={`${id}-group-label`}>
              <Box component="span" sx={{ display: 'flex', alignItems: 'center' }}>
                {label}
                {renderTooltip()}
              </Box>
            </FormLabel>
            <FormGroup aria-labelledby={`${id}-group-label`}>
              {options.map((option) => (
                <FormControlLabel
                  key={option.value}
                  control={
                    <Checkbox
                      id={`${id}-${option.value}`}
                      value={option.value}
                      disabled={disabled || option.disabled}
                      {...fieldProps}
                    />
                  }
                  label={option.label}
                />
              ))}
            </FormGroup>
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      case 'radio':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
            component="fieldset"
          >
            <FormLabel component="legend" id={`${id}-radio-group-label`}>
              <Box component="span" sx={{ display: 'flex', alignItems: 'center' }}>
                {label}
                {renderTooltip()}
              </Box>
            </FormLabel>
            <RadioGroup 
              aria-labelledby={`${id}-radio-group-label`}
              name={id}
              {...fieldProps}
            >
              {options.map((option) => (
                <FormControlLabel
                  key={option.value}
                  value={option.value}
                  control={<Radio />}
                  label={option.label}
                  disabled={disabled || option.disabled}
                />
              ))}
            </RadioGroup>
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      case 'switch':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
          >
            <FormControlLabel
              control={
                <Switch
                  {...commonProps}
                />
              }
              label={(
                <Box component="span" sx={{ display: 'flex', alignItems: 'center' }}>
                  {label}
                  {renderTooltip()}
                </Box>
              )}
            />
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      case 'slider':
        return (
          <FormControl 
            fullWidth={fullWidth} 
            error={hasError}
            required={required}
            disabled={disabled}
          >
            <Typography id={`${id}-slider-label`} gutterBottom>
              <Box component="span" sx={{ display: 'flex', alignItems: 'center' }}>
                {label}
                {required && (
                  <Box component="span" sx={{ color: 'error.main', ml: 0.5 }}>*</Box>
                )}
                {renderTooltip()}
              </Box>
            </Typography>
            <Slider
              aria-labelledby={`${id}-slider-label`}
              valueLabelDisplay="auto"
              {...commonProps}
            />
            {(errorText || helperText) && (
              <FormHelperText>{errorText || helperText}</FormHelperText>
            )}
          </FormControl>
        );

      default:
        return (
          <TextField
            label={label}
            helperText={errorText || helperText}
            fullWidth={fullWidth}
            {...commonProps}
          />
        );
    }
  };

  return (
    <Box sx={{ mb: 2, ...sx }} {...rest}>
      {renderField()}
    </Box>
  );
};

export default AccessibleFormField;