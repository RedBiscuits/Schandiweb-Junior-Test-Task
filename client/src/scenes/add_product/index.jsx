import React from "react";
import { useMediaQuery } from "@mui/material";

import AddProductForm from "components/AddProductForm";
import Footer from "components/Footer";
export const AddProduct = () => {
  useMediaQuery("(min-width: 600px)");

  return (
    <div>
      <AddProductForm/>
      <Footer/>
    </div>
  );
};

export default AddProduct;
