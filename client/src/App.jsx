import { CssBaseline, ThemeProvider } from "@mui/material";
import { createTheme } from "@mui/material/styles";
import { useMemo } from "react";
import { themeSettings } from "theme";
import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
import Dashboard from "scenes/dashboard";
import Layout from "scenes/layout";
import { useDispatch, useSelector } from "react-redux";
import { setProductsData } from "controllers/ProductsReducer.mjs";
import { useEffect } from "react";
import AddProduct from "scenes/add_product";

function App() {
  const mode = useSelector((state) => state.global.mode);
  const theme = useMemo(() => createTheme(themeSettings(mode)), [mode]);

  const dispatch = useDispatch();

  useEffect(() => {
    fetch("https://juniortaskapi.000webhostapp.com/read")
      .then((response) => response.json())
      .then((data) => {
        dispatch(setProductsData(data));
      });
  }, [dispatch]);
  return (
    <div className="app">
      <BrowserRouter>
        <ThemeProvider theme={theme}>
          <CssBaseline />
          <Routes>
            <Route element={<Layout />}>
              <Route path="/" element={<Dashboard />} />
              <Route path="/addproduct" element={<AddProduct />} />
            </Route>
          </Routes>
        </ThemeProvider>
      </BrowserRouter>
    </div>
  );
}

export default App;
