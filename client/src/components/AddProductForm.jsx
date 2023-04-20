import React from "react";
import { Box, Typography, useMediaQuery } from "@mui/material";
import { useFormik } from "formik";
import { Stack, TextField, Select, MenuItem } from "@mui/material";
import { NumericFormat } from "react-number-format";
import Navbar from "components/Navbar";
import { CancelButton, SaveButton } from "components/NavButtonsFactory";
import { fieldComponents } from "./CustomFields";
import {
  getValidationObject,
  initialValues,
} from "controllers/AddProductController";
import { useTheme } from "@emotion/react";
const AddProductForm = () => {
  useMediaQuery("(min-width: 600px)");

  const formatCurrency = (value) => {
    if (!value) return "";
    return `${value.toFixed(2)}`;
  };

  const options = [
    { value: "dvd", label: "DVD" },
    { value: "furniture", label: "Furniture" },
    { value: "book", label: "Book" },
  ];

  const formik = useFormik({
    initialValues: initialValues,
    validationSchema: getValidationObject(options),
  });

  const theme = useTheme();

  return (
    <>
      {" "}
      <div>
        <Navbar
          title={"Add Product"}
          rightButton={<CancelButton />}
          leftButton={<SaveButton formik={formik} />}
        />
        <Box
          sx={{
            flex: "1 1 auto",
            alignItems: "start",
            display: "flex",
            justifyContent: "start",
            marginLeft: "2rem",
            marginRight: "2rem",
            marginTop: "0.2rem",
          }}
        >
          <Box
            sx={{
              maxWidth: 600,
              px: 3,
              py: "50px",
              width: "100%",
            }}
          >
            <div>
              {}
              {
                <form noValidate id="product_form">
                  <Stack spacing={2}>
                    <TextField
                      error={!!(formik.touched.sku && formik.errors.sku)}
                      fullWidth
                      helperText={formik.touched.sku && formik.errors.sku}
                      label="SKU"
                      name="sku"
                      id="sku"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      type="text"
                      value={formik.values.sku}
                    />
                    <TextField
                      error={!!(formik.touched.name && formik.errors.name)}
                      fullWidth
                      helperText={formik.touched.name && formik.errors.name}
                      label="Name"
                      name="name"
                      id="name"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      type="text"
                      value={formik.values.name}
                    />

                    <TextField
                      fullWidth
                      helperText={formik.touched.price && formik.errors.price}
                      error={!!(formik.touched.price && formik.errors.price)}
                      label="Price"
                      name="price"
                      id="price"
                      value={formik.values.price}
                      onChange={formik.handleChange}
                      InputProps={{
                        inputComponent: NumericFormat,
                        inputProps: {
                          prefix: "$",
                          thousandSeparator: true,
                          decimalScale: 2,
                          fixedDecimalScale: true,
                          format: formatCurrency,
                        },
                      }}
                    />

                    <select
                      id="productType"
                      name="selectedOption"
                      value={formik.values.selectedOption}
                      onChange={formik.handleChange}
                      disabled={formik.isSubmitting}
                      style={{
                        fontSize: "16px",
                        color: theme.palette.secondary[500],
                        backgroundColor: theme.palette.primary[500],
                        border: "1px solid #ccc",
                        borderRadius: "4px",
                        padding: "1rem",
                        width: "100%",
                        marginBottom: "10px",
                        "&:focus": {
                          backgroundColor: "#fff",
                          borderRadius: "4px",
                          borderColor: "#ccc",
                          boxShadow: "0 0 0 0.2rem rgba(0,123,255,.25)",
                        }}
                      }
                    >
                      <option value="" disabled>
                        Select an option
                      </option>
                      {options.map((option) => (
                        <option key={option.value} value={option.label}>
                          {option.label}
                        </option>
                      ))}
                    </select>

                    {fieldComponents(formik)[
                      formik.values.selectedOption.toLowerCase()
                    ]?.({})}
                  </Stack>

                  {formik.errors.submit && (
                    <Typography color="error" sx={{ mt: 3 }} variant="body2">
                      {formik.errors.submit}
                    </Typography>
                  )}
                </form>
              }
            </div>
          </Box>
        </Box>
      </div>
    </>
  );
};

export default AddProductForm;
