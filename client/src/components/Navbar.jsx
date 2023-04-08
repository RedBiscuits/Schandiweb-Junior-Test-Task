import React, { useState } from "react";
import {
  LightModeOutlined,
  DarkModeOutlined,
} from "@mui/icons-material";
import FlexBetween from "components/FlexBetween";
import CustomButton from "components/CustomButton";
import { useDispatch, useSelector } from "react-redux";
import { setMode } from "state";
import {
  AppBar,
  IconButton,
  Toolbar,
  Typography,
  useTheme,
  Divider 
} from "@mui/material";
import { deleteProduct } from "controllers/ProductsReducer.mjs";
import axios from 'axios';

const Navbar = () => {
  const dispatch = useDispatch();
  const theme = useTheme();
  const selectedIds = useSelector(s => s.myFeature) 

  const handleMassDeleteClick = () => {
    const promises = [];
    const {promise} = axios.post('http://localhost:3000/asd/product/delete', {
      ids: JSON.stringify(selectedIds.map(product => parseInt(product.sku)))
    }, {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
  })

    Promise.all([promise]).then(()=>{
      for (let i = 0; i < selectedIds.length; i++) {
        const sku = selectedIds[i].sku;
        const promise = dispatch(deleteProduct(parseInt(sku)));
        promises.push(promise);
      }
    
      Promise.all(promises).then(() => {
      });
    });
    
  };

  const handleAddClick = () => {
    // add logic for add functionality
  }
  return (
    <AppBar
      sx={{
        marginTop:"1rem",
        position: "static",
        background: "none",
        boxShadow: "none",
      }}
    >
      <Toolbar sx={{ justifyContent: "space-between" }}>
        {/* LEFT SIDE */}
        <FlexBetween>
        <Typography           
          variant="h4"
          fontWeight="bold"
          sx={{marginLeft: "0.5rem"}}
          color={theme.palette.secondary[100]}
          fontFamily={theme.typography.fontFamily}
           >Product List</Typography>

        </FlexBetween>

        {/* RIGHT SIDE */}
        <FlexBetween gap="1.5rem">
          <IconButton onClick={() => dispatch(setMode())}>
            {theme.palette.mode === "dark" ? (
              <DarkModeOutlined sx={{ fontSize: "25px" }} />
            ) : (
              <LightModeOutlined sx={{ fontSize: "25px" }} />
            )}
          </IconButton>

          <FlexBetween>
            <FlexBetween
              sx={{
                marginRight:"0.5rem",
                display: "flex",
                justifyContent: "space-between",
                alignItems: "center",
                textTransform: "none",
                gap: "1rem",
              }}
            >


              <CustomButton text={"ADD"} onClick={handleAddClick}></CustomButton>
              <CustomButton text={"MASS DELETE"} onClick={handleMassDeleteClick}></CustomButton>


            </FlexBetween>

          </FlexBetween>
        </FlexBetween>
        
      </Toolbar>
      <Divider sx={{ backgroundColor: theme.palette.secondary[50] , marginX:"2rem" }} />

    </AppBar>
    
  );
};

export default Navbar;