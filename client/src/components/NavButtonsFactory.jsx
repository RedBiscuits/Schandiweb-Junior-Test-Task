import React from "react";
import { deleteProduct } from "controllers/ProductsReducer.mjs";
import { removeProduct } from "controllers/SelectedItemsReducer";
import axios from "axios";
import { useDispatch, useSelector } from "react-redux";
import CustomButton from "./CustomButton";
import { useNavigate } from "react-router-dom";
import { validateInput } from "controllers/AddProductController";
import { addProduct } from "controllers/AddProductController";
import { addProductReducer } from "controllers/ProductsReducer.mjs";

export const AddButton = () => {
  const navigate = useNavigate();

  const handleAddClick = () => {
    navigate("/addproduct");
  };
  return <CustomButton text={"ADD"} onClick={handleAddClick}></CustomButton>;
};

export const CancelButton = () => {
  const navigate = useNavigate();

  const handleCancelClick = () => {
    navigate("/");
  };
  return (
    <CustomButton text={"Cancel"} onClick={handleCancelClick}></CustomButton>
  );
};

export const SaveButton = ({ formik }) => {
  const products = useSelector((state) => state.products);
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const uniqueAttributeMap = {
    book: formik.values.weight,
    dvd: formik.values.size,
    furniture: formik.values.width + ' x ' + formik.values.height + ' x ' + formik.values.length,
  };
  const handleSaveClick = () => {
    try {
      validateInput(formik);
      const productExists = products.some(
        (product) => product.sku === formik.values.sku
      );
      if (productExists) {
        throw new Error("SKU must be unique.");
      }
      const res = addProduct(formik.values);
      if (res) {
        const productData = {
          sku: formik.values.sku,
          name: formik.values.name,
          price: formik.values.price.substr(1),
          unique_attribute: uniqueAttributeMap[formik.values.selectedOption],
        };
        dispatch(addProductReducer(productData));
        navigate("/");
      } else {
        throw new Error("Invalid data.");
      }
    } catch (err) {
      alert(err);
    }
  };
  return <CustomButton text={"Save"} onClick={handleSaveClick}></CustomButton>;
};

export const MassDeleteButton = () => {
  const dispatch = useDispatch();
  const selectedIds = useSelector((s) => s.myFeature);
  const handleMassDeleteClick = () => {
 axios
      .post(
        "https://juniortaskapi.000webhostapp.com/delete",
        {
          ids: JSON.stringify(
            selectedIds.map((product) => product.sku)
          ),
        },
        {
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
        }
      )
      .then(() => {
        for (let i = 0; i < selectedIds.length; i++) {
          const sku = selectedIds[i].sku;
          dispatch(deleteProduct(sku));
          dispatch(removeProduct(sku));
        }
      });
  };
  return (
    <CustomButton
      text={"MASS DELETE"}
      onClick={handleMassDeleteClick}
    ></CustomButton>
  );
};
