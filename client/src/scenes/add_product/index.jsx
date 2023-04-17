import React from "react";
import { useMediaQuery } from "@mui/material";

import Navbar from "components/Navbar";
import { CancelButton , SaveButton } from "components/NavButtonsFactory";
import AddProductForm from "components/AddProductForm";
import Footer from "components/Footer";
export const AddProduct = () => {
  useMediaQuery("(min-width: 600px)");

  return (
    <div>
      <Navbar title={"Add Product"} rightButton={<CancelButton/> } leftButton={<SaveButton/>}/>
      <AddProductForm/>
      <Footer/>
    </div>
  );
};

export default AddProduct;
