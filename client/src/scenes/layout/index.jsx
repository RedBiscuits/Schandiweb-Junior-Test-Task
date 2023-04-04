import React, { useState, useEffect } from "react";
import { Box, useMediaQuery } from "@mui/material";
import { Outlet } from "react-router-dom";
import { useDispatch, useSelector } from 'react-redux';
import Navbar from "components/Navbar";
import Product from "components/ProductList";
import { setProductsData} from "controllers/ProductsReducer.mjs";
import * as reducer from "controllers/SelectedItemsReducer";

export const Layout = () => {
    const isNonMobile = useMediaQuery("(min-width: 600px)");
    const dispatch = useDispatch()
    const selectedIds = useSelector(s => s.myFeature) 
    const products = useSelector((state) => state.products);

    const handleCheckboxChange = (productSKU) => {
        const productExists = selectedIds.some(product => product.sku === productSKU);
        if (productExists) {
          dispatch(reducer.removeProduct(productSKU));
        } else {
          dispatch(reducer.addProduct(productSKU));
        }
    }



    return (
        <Box display={isNonMobile ? "flex" : "block"} width="100%" height="100%">
            <Box flexGrow={1}>
                <Navbar/>
                <Product data={products}  onCheckboxChange={handleCheckboxChange}/>
                <Outlet/>
            </Box>
        </Box>
    );
}

export default Layout;