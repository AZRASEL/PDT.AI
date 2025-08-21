import React from 'react';
import { Box } from '@mui/material';

/**
 * ResponsiveImage component provides an accessible and responsive image
 * with proper loading behavior and fallback options.
 * 
 * @param {Object} props - Component props
 * @param {string} props.src - Image source URL
 * @param {string} props.alt - Alternative text for the image (required for accessibility)
 * @param {string} [props.fallbackSrc] - Fallback image to display if the main image fails to load
 * @param {Object} [props.sx] - Additional MUI system props for the container
 * @param {Object} [props.imgSx] - Additional MUI system props for the image itself
 * @param {string} [props.aspectRatio] - Aspect ratio of the image (e.g., '16/9', '4/3', '1/1')
 * @param {boolean} [props.lazy=true] - Whether to use lazy loading
 * @param {string} [props.objectFit='cover'] - Object-fit property for the image
 * @param {string} [props.objectPosition='center'] - Object-position property for the image
 * @param {Function} [props.onLoad] - Callback when the image loads successfully
 * @param {Function} [props.onError] - Callback when the image fails to load
 */
const ResponsiveImage = ({
  src,
  alt,
  fallbackSrc,
  sx = {},
  imgSx = {},
  aspectRatio,
  lazy = true,
  objectFit = 'cover',
  objectPosition = 'center',
  onLoad,
  onError,
  ...rest
}) => {
  const [imgSrc, setImgSrc] = React.useState(src);
  const [hasError, setHasError] = React.useState(false);

  React.useEffect(() => {
    setImgSrc(src);
    setHasError(false);
  }, [src]);

  const handleError = (e) => {
    if (fallbackSrc && !hasError) {
      setImgSrc(fallbackSrc);
      setHasError(true);
    }
    if (onError) onError(e);
  };

  const handleLoad = (e) => {
    if (onLoad) onLoad(e);
  };

  // Calculate padding based on aspect ratio
  const getPaddingBottom = () => {
    if (!aspectRatio) return undefined;
    
    // Handle different formats of aspect ratio
    if (aspectRatio.includes('/')) {
      const [width, height] = aspectRatio.split('/');
      return `${(Number(height) / Number(width)) * 100}%`;
    }
    
    if (aspectRatio.includes(':')) {
      const [width, height] = aspectRatio.split(':');
      return `${(Number(height) / Number(width)) * 100}%`;
    }
    
    return aspectRatio; // Assume it's already a valid CSS value
  };

  return (
    <Box
      sx={{
        position: aspectRatio ? 'relative' : 'static',
        paddingBottom: getPaddingBottom(),
        overflow: 'hidden',
        ...sx,
      }}
      {...rest}
    >
      <Box
        component="img"
        src={imgSrc}
        alt={alt}
        loading={lazy ? 'lazy' : 'eager'}
        onError={handleError}
        onLoad={handleLoad}
        sx={{
          width: '100%',
          height: aspectRatio ? '100%' : 'auto',
          objectFit,
          objectPosition,
          position: aspectRatio ? 'absolute' : 'static',
          top: aspectRatio ? 0 : undefined,
          left: aspectRatio ? 0 : undefined,
          ...imgSx,
        }}
      />
    </Box>
  );
};

export default ResponsiveImage;