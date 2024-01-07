import React from "react";
import { Box, useMediaQuery } from "@mui/material";
import { Outlet } from "react-router-dom";

// Define the Layout component
export const Layout = () => {
    // Use the useMediaQuery hook to check if the screen width is greater than or equal to 600px
    const isNonMobile = useMediaQuery("(min-width: 600px)");

    return (
        // Use the Box component from MUI to create a flexible layout
        <Box display={isNonMobile ? "flex" : "block"} width="100%" height="100%">
            <Box flexGrow={1}>
                {/* Render the Outlet component from react-router-dom */}
                <Outlet/>
            </Box>
        </Box>
    );
}

export default Layout;