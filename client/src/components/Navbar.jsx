import React from "react";
import { LightModeOutlined, DarkModeOutlined } from "@mui/icons-material";
import FlexBetween from "components/FlexBetween";
import { useDispatch, useSelector } from "react-redux";
import { setMode } from "state";
import {
  AppBar,
  IconButton,
  Toolbar,
  Typography,
  useTheme,
  Divider,
} from "@mui/material";

const Navbar = ({ rightButton , leftButton , title}) => {
  const dispatch = useDispatch();
  const theme = useTheme();

  return (
    <AppBar
      sx={{
        marginTop: "1rem",
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
            sx={{ marginLeft: "0.5rem" }}
            color={theme.palette.secondary[100]}
            fontFamily={theme.typography.fontFamily}
          >
            {title}
          </Typography>
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
                marginRight: "0.5rem",
                display: "flex",
                justifyContent: "space-between",
                alignItems: "center",
                textTransform: "none",
                gap: "1rem",
              }}
            >
              {leftButton}
              {rightButton}

              
            </FlexBetween>
          </FlexBetween>
        </FlexBetween>
      </Toolbar>
      <Divider
        sx={{ backgroundColor: theme.palette.secondary[50], marginX: "2rem" }}
      />
    </AppBar>
  );
};

export default Navbar;
