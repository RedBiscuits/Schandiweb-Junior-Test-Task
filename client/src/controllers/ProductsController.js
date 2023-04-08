import { deleteProduct } from "controllers/ProductsReducer.mjs";
import axios from 'axios';

export const MassDelete = (selectedIds, dispatch) => {
    const promises = [];
  
    const { promise } = axios.post('http://localhost:3000/asd/product/delete', {
      ids: selectedIds
    }, {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    });
  
    Promise.all([promise]).then(() => {
      for (let i = 0; i < selectedIds.length; i++) {
        const sku = selectedIds[i].sku;
        const promise = dispatch(deleteProduct(parseInt(sku)));
        promises.push(promise);
      }
  
      Promise.all(promises).then(() => {
        // Handle success
      });
    });
  };