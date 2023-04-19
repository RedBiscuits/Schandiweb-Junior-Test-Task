import * as Yup from "yup";
import axios from "axios";

export function getValidationObject(options) {
  const productValidationSchema = Yup.object({
    name: Yup.string().max(255).required("Name is required"),
    sku: Yup.string().max(255).required("SKU is required"),
    price: Yup.number()
      .transform((value, originalValue) => {
        const newValue = originalValue.replace("$", "");
        return parseFloat(newValue);
      })
      .min(0)
      .required("Price is required"),
    selectedOption: Yup.string()
      .oneOf(options.map((option) => option.value))
      .required("Type is required"),
  });

  return productValidationSchema;
}

export const initialValues = {
  name: "",
  sku: "",
  selectedOption: "",
  price: "",
  size: "",
  width: "",
  length: "",
  height: "",
  weight: "",
};

export function addProduct(values) {
  return axios
    .post(
      "http://localhost:3000/asd/product/create",
      {
        sku: values.sku,
        name: values.name,
        price: values.price.substr(1),
        optionSelected: values.selectedOption,
        weight: values.weight,
        length: values.length,
        height: values.height,
        width: values.width,
        size: values.size,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    )
    .then((response) => {
      console.log(response.status)
      if (response.status === 200) {
        return true;
      } else {
        console.log(response.status);
        return false;
      }
    })
    .catch((error) => {
      console.error(error);
      return false;
    });
}

export function validateInput(formik) {
  if (!formik.values.sku) {
    throw new Error("SKU is required");
  } else if (!formik.values["name"]) {
    throw new Error("Name is required");
  } else if (!formik.values["price"]) {
    throw new Error("Price is required");
  } else if (!formik.values["selectedOption"]) {
    throw new Error("Selected Option is required");
  } else if (
    formik.values["selectedOption"] === "dvd" &&
    !formik.values["size"]
  ) {
    throw new Error("Size is required");
  } else if (
    formik.values["selectedOption"] === "book" &&
    !formik.values["weight"]
  ) {
    throw new Error("Weight is required");
  } else if (
    formik.values["selectedOption"] === "furniture" &&
    !formik.values["height"]
  ) {
    throw new Error("Height is required");
  } else if (
    formik.values["selectedOption"] === "furniture" &&
    !formik.values["width"]
  ) {
    throw new Error("Width is required");
  } else if (
    formik.values["selectedOption"] === "furniture" &&
    !formik.values["length"]
  ) {
    throw new Error("Length is required");
  } else {
    if (formik.values["selectedOption"] === "book") {
      if (isNaN(parseInt(formik.values["weight"]))) {
        throw new Error("Please, provide the data of indicated type");
      }
    } else if (formik.values["selectedOption"] === "dvd") {
      if (isNaN(parseInt(formik.values["size"]))) {
        throw new Error("Please, provide the data of indicated type");
      }
    } else if (formik.values["selectedOption"] === "furniture") {
      if (
        isNaN(parseInt(formik.values["width"])) ||
        isNaN(parseInt(formik.values["height"])) ||
        isNaN(parseInt(formik.values["length"]))
      ) {
        throw new Error("Please, provide the data of indicated type");
      }
    }
  }
}
