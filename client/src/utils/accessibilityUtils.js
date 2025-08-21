/**
 * Accessibility utility functions for improving application accessibility
 */

/**
 * Creates props for an accessible accordion
 * @param {string} id - The base ID for the accordion
 * @returns {Object} Props for accordion and its components
 */
export const getAccessibleAccordionProps = (id) => {
  return {
    accordionProps: {
      id: `accordion-${id}`,
    },
    summaryProps: {
      id: `accordion-summary-${id}`,
      'aria-controls': `accordion-content-${id}`,
    },
    detailsProps: {
      id: `accordion-content-${id}`,
      'aria-labelledby': `accordion-summary-${id}`,
    },
  };
};

/**
 * Creates props for an accessible tab panel
 * @param {string} id - The base ID for the tab panel
 * @param {number} index - The index of the tab
 * @returns {Object} Props for tab and tab panel
 */
export const getAccessibleTabProps = (id, index) => {
  return {
    tabProps: {
      id: `tab-${id}-${index}`,
      'aria-controls': `tabpanel-${id}-${index}`,
    },
    tabPanelProps: {
      id: `tabpanel-${id}-${index}`,
      'aria-labelledby': `tab-${id}-${index}`,
      role: 'tabpanel',
    },
  };
};

/**
 * Creates props for an accessible modal
 * @param {string} id - The ID for the modal
 * @returns {Object} Props for modal and its components
 */
export const getAccessibleModalProps = (id) => {
  return {
    modalProps: {
      id: `modal-${id}`,
      'aria-labelledby': `modal-title-${id}`,
      'aria-describedby': `modal-description-${id}`,
      role: 'dialog',
    },
    titleProps: {
      id: `modal-title-${id}`,
    },
    descriptionProps: {
      id: `modal-description-${id}`,
    },
  };
};

/**
 * Creates props for an accessible form field
 * @param {string} id - The ID for the form field
 * @param {string} [errorId] - Optional ID for error message
 * @returns {Object} Props for form field and its components
 */
export const getAccessibleFormFieldProps = (id, errorId) => {
  const props = {
    labelProps: {
      id: `label-${id}`,
      htmlFor: id,
    },
    inputProps: {
      id: id,
      'aria-labelledby': `label-${id}`,
    },
  };

  if (errorId) {
    props.inputProps['aria-describedby'] = errorId;
    props.errorProps = {
      id: errorId,
      role: 'alert',
    };
  }

  return props;
};

/**
 * Creates an announcement for screen readers using aria-live regions
 * @param {string} message - The message to announce
 * @param {string} [priority='polite'] - The priority of the announcement ('polite' or 'assertive')
 */
export const announceToScreenReader = (message, priority = 'polite') => {
  // Find or create the live region
  let liveRegion = document.getElementById(`sr-live-${priority}`);
  
  if (!liveRegion) {
    liveRegion = document.createElement('div');
    liveRegion.id = `sr-live-${priority}`;
    liveRegion.setAttribute('aria-live', priority);
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.setAttribute('class', 'sr-only');
    document.body.appendChild(liveRegion);
  }

  // Set the message
  liveRegion.textContent = '';
  // Force a DOM reflow
  void liveRegion.offsetWidth;
  // Set the new message
  liveRegion.textContent = message;
};

/**
 * Adds keyboard navigation to a list of items
 * @param {Event} event - The keyboard event
 * @param {number} currentIndex - The current focused index
 * @param {number} maxIndex - The maximum index
 * @returns {number} The new index to focus
 */
export const handleListKeyboardNavigation = (event, currentIndex, maxIndex) => {
  let newIndex = currentIndex;

  switch (event.key) {
    case 'ArrowDown':
    case 'ArrowRight':
      newIndex = Math.min(currentIndex + 1, maxIndex);
      event.preventDefault();
      break;
    case 'ArrowUp':
    case 'ArrowLeft':
      newIndex = Math.max(currentIndex - 1, 0);
      event.preventDefault();
      break;
    case 'Home':
      newIndex = 0;
      event.preventDefault();
      break;
    case 'End':
      newIndex = maxIndex;
      event.preventDefault();
      break;
    default:
      return currentIndex;
  }

  return newIndex;
};

/**
 * Checks if an element is visible in the viewport
 * @param {HTMLElement} element - The element to check
 * @returns {boolean} Whether the element is visible
 */
export const isElementInViewport = (element) => {
  const rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
};

/**
 * Scrolls an element into view if it's not already visible
 * @param {HTMLElement} element - The element to scroll into view
 * @param {Object} [options] - Scroll options
 */
export const scrollIntoViewIfNeeded = (element, options = { behavior: 'smooth', block: 'nearest' }) => {
  if (!isElementInViewport(element)) {
    element.scrollIntoView(options);
  }
};