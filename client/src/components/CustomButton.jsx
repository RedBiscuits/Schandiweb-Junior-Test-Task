import React from 'react';
import {
  useTheme,
} from "@mui/material";
function CustomButton({ text, onClick }) {
  const theme = useTheme();

  return (
    <button
      onClick={onClick}
      style={{
        fontWeight: "bold",
        fontSize: "0.85rem",
        color: theme.palette.secondary[100],
        backgroundColor: theme.palette.secondary[600],
        borderRadius: "4px",
        padding: "6px 10px",
        border: "none",
        cursor: "pointer"
      }}
    >
      {text}
    </button>
  );
}

export default CustomButton;
