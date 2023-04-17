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

                    <Select
                      value={formik.values.selectedOption}
                      onChange={formik.handleChange}
                      name="selectedOption"
                      disabled={formik.isSubmitting}
                    >
                      <title>Select an option</title>
                      {options.map((option) => (
                        <MenuItem key={option.value} value={option.value}>
                          {option.label}
                        </MenuItem>
                      ))}
                    </Select>

                    {fieldComponents(formik)[formik.values.selectedOption]?.(
                      {}
                    )}
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