import { Box, Divider, Typography } from "@mui/material";
import React from "react";
import { useTheme } from "@mui/material";

const styles = {
  footer: {
    backgroundColor: "#f5f5f5",
    padding: "1rem",
    textAlign: "center",
    position: "fixed",
    left: 0,
    bottom: 0,
    width: "100%",
  },
};

const Footer = () => {
  const theme = useTheme();

  return (
    <div style={{ minHeight: "100vh", position: "relative" }}>
      <Box
        justifyContent={"center"}
        textAlign={"center"}
        padding={"1rem"}
        width={"100%"}
        position={"absolute"}
        bottom={0}
        left={0}
        height={"3rem"}
        zIndex={1}
      >
        <Divider
          sx={{
            backgroundColor: theme.palette.secondary[50],
            marginX: "2rem",
          }}
        />
        <Typography
          color={theme.palette.secondary[100]}
          variant="h5"
          padding={"1rem"}
        >
          Schandiweb Junior Test Task
        </Typography>
      </Box>
    </div>
  );
};

export default Footer;
