import React, { useState, useEffect } from "react";
import { Box, useMediaQuery } from "@mui/material";
import { Outlet } from "react-router-dom";

import Navbar from "components/Navbar";

export const Layout = () => {
    const isNonMobile = useMediaQuery("(min-width: 600px)");


    return (
        <Box display={isNonMobile ? "flex" : "block"} width="100%" height="100%">
            <Box flexGrow={1}>
                <Outlet/>
            </Box>
        </Box>
    );
}

export default Layout;