import React from 'react';
import { Checkbox, FormControlLabel, FormGroup, Typography, useTheme } from '@mui/material';

function ProductItem({ item, onCheckboxChange }) {
  const theme = useTheme();
  return (
    <div>
      <FormGroup
        sx={{
          display: 'flex',
          bgcolor: theme.palette.grey[100],
          position: 'relative',
          padding: '1.5rem',
          width: '14rem',
          height: '11rem',
          border: `2px solid ${theme.palette.secondary[500]}`,
          marginTop: '1.5rem',
        }}
      >
        <FormControlLabel
          sx={{ position: 'absolute', top: 8, left: 13 }}
          control={<Checkbox className='delete-checkbox' onChange={onCheckboxChange}
          color="primary" sx={{ width: '100%', height: '100%', color: theme.palette.primary[500] }} />}
          label=""
        />
        <div style={{ flex: 1, marginLeft: '1rem', marginTop: '1.2rem' }}>
          <Typography sx={{ color: theme.palette.primary[500], textAlign: 'center' }}>SKU: {item.sku}</Typography>
          <Typography sx={{ color: theme.palette.primary[500], textAlign: 'center' }}>Name: {item.name}</Typography>
          <Typography sx={{ color: theme.palette.primary[500], textAlign: 'center' }}>Price: {item.price}</Typography>
          <Typography sx={{ color: theme.palette.primary[500], textAlign: 'center' }}>{item.unique_attribute}</Typography>
        </div>
      </FormGroup>
    </div>
  );
}

export default ProductItem;