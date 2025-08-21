import React from 'react';
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Typography,
  Box,
  useTheme,
} from '@mui/material';
import { handleListKeyboardNavigation } from '../../utils/accessibilityUtils';

/**
 * AccessibleTable component provides an accessible table with proper ARIA attributes
 * and keyboard navigation support.
 * 
 * @param {Object} props - Component props
 * @param {Array} props.columns - Array of column definitions with at least 'id' and 'label' properties
 * @param {Array} props.data - Array of data objects to display in the table
 * @param {string} [props.caption] - Table caption for screen readers
 * @param {string} [props.summary] - Table summary for screen readers (deprecated in HTML5 but useful for accessibility)
 * @param {string} [props.ariaLabel] - ARIA label for the table
 * @param {Function} [props.onRowClick] - Callback when a row is clicked
 * @param {Function} [props.getRowId] - Function to get a unique ID for each row (defaults to index)
 * @param {Object} [props.sx] - Additional MUI system props for the TableContainer
 * @param {boolean} [props.stickyHeader] - Whether to make the header sticky
 * @param {boolean} [props.dense] - Whether to use a more compact table style
 * @param {boolean} [props.striped] - Whether to use striped rows
 * @param {boolean} [props.hoverable] - Whether to highlight rows on hover
 * @param {boolean} [props.bordered] - Whether to add borders to cells
 * @param {string} [props.emptyMessage] - Message to display when there is no data
 */
const AccessibleTable = ({
  columns,
  data,
  caption,
  summary,
  ariaLabel,
  onRowClick,
  getRowId = (row, index) => index,
  sx = {},
  stickyHeader = false,
  dense = false,
  striped = false,
  hoverable = false,
  bordered = false,
  emptyMessage = 'No data available',
  ...rest
}) => {
  const theme = useTheme();
  
  // Handle keyboard navigation for the table
  const handleKeyDown = (event, rowIndex, rowData) => {
    if (onRowClick) {
      // Handle Enter or Space to activate row click
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        onRowClick(rowData, rowIndex);
        return;
      }
    }
    
    // Handle arrow key navigation between rows
    handleListKeyboardNavigation(event, {
      containerSelector: 'tbody',
      itemSelector: '[role="row"]',
      currentIndex: rowIndex,
    });
  };

  // Generate cell styles based on props
  const getCellStyles = (isHeader = false, isEvenRow = false) => {
    const styles = {
      ...(dense ? { padding: theme.spacing(1) } : {}),
      ...(bordered ? { border: `1px solid ${theme.palette.divider}` } : {}),
    };

    if (isHeader) {
      return {
        ...styles,
        fontWeight: 'bold',
        backgroundColor: theme.palette.primary.main,
        color: theme.palette.primary.contrastText,
      };
    }

    if (striped && isEvenRow) {
      return {
        ...styles,
        backgroundColor: theme.palette.action.hover,
      };
    }

    return styles;
  };

  return (
    <TableContainer 
      component={Paper} 
      sx={{
        overflowX: 'auto',
        ...sx,
      }}
      {...rest}
    >
      {caption && (
        <Typography 
          component="caption" 
          variant="subtitle1"
          sx={{ p: 2, fontWeight: 'bold' }}
        >
          {caption}
        </Typography>
      )}
      
      <Table 
        aria-label={ariaLabel || caption || 'Data table'}
        {...(summary ? { 'aria-describedby': `table-summary-${ariaLabel || 'data'}` } : {})}
        stickyHeader={stickyHeader}
        size={dense ? 'small' : 'medium'}
      >
        {summary && (
          <Box 
            id={`table-summary-${ariaLabel || 'data'}`} 
            sx={{ position: 'absolute', left: '-9999px', height: 1, overflow: 'hidden' }}
            aria-hidden="false"
          >
            {summary}
          </Box>
        )}
        
        <TableHead>
          <TableRow>
            {columns.map((column) => (
              <TableCell 
                key={column.id}
                align={column.align || 'left'}
                style={getCellStyles(true)}
                {...(column.width ? { width: column.width } : {})}
                {...(column.sortDirection ? { sortDirection: column.sortDirection } : {})}
                {...(column.ariaSort ? { 'aria-sort': column.ariaSort } : {})}
              >
                {column.label}
              </TableCell>
            ))}
          </TableRow>
        </TableHead>
        
        <TableBody>
          {data.length > 0 ? (
            data.map((row, rowIndex) => {
              const rowId = getRowId(row, rowIndex);
              const isEvenRow = rowIndex % 2 === 0;
              
              return (
                <TableRow
                  key={rowId}
                  hover={hoverable}
                  onClick={onRowClick ? () => onRowClick(row, rowIndex) : undefined}
                  onKeyDown={onRowClick ? (e) => handleKeyDown(e, rowIndex, row) : undefined}
                  tabIndex={onRowClick ? 0 : -1}
                  role="row"
                  aria-rowindex={rowIndex + 2} // +2 because header row is 1
                  sx={{
                    cursor: onRowClick ? 'pointer' : 'default',
                    '&:focus': onRowClick ? {
                      outline: `2px solid ${theme.palette.primary.main}`,
                      outlineOffset: '-2px',
                    } : {},
                    '&:last-child td, &:last-child th': {
                      border: bordered ? `1px solid ${theme.palette.divider}` : undefined,
                    },
                  }}
                >
                  {columns.map((column, colIndex) => {
                    const value = row[column.id];
                    const cellContent = column.render ? column.render(value, row, rowIndex) : value;
                    
                    return (
                      <TableCell 
                        key={`${rowId}-${column.id}`}
                        align={column.align || 'left'}
                        style={getCellStyles(false, isEvenRow)}
                        role="cell"
                        aria-colindex={colIndex + 1}
                      >
                        {cellContent}
                      </TableCell>
                    );
                  })}
                </TableRow>
              );
            })
          ) : (
            <TableRow>
              <TableCell 
                colSpan={columns.length} 
                align="center"
                sx={{ py: 3 }}
              >
                <Typography variant="body1" color="text.secondary">
                  {emptyMessage}
                </Typography>
              </TableCell>
            </TableRow>
          )}
        </TableBody>
      </Table>
    </TableContainer>
  );
};

export default AccessibleTable;