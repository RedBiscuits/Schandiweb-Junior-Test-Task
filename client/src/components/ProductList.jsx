import React from 'react';
import { Grid } from '@mui/material';
import ProductItem from './ProductItem';

function ProductList({ data, onCheckboxChange }) {
  return (
    <Grid container justifyContent='space-around' spacing={2} sx={{ marginLeft: '2rem' }}>
      {data.map((item) => (
        <Grid item xs={12} sm={6} md={3} key={item.sku}>
          <ProductItem item={item} onCheckboxChange={() => onCheckboxChange(item.sku)} />
        </Grid>
      ))}
    </Grid>
  );
}

export default ProductList;