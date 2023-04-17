import React from "react";
import { deleteProduct } from "controllers/ProductsReducer.mjs";
import axios from "axios";
import { useDispatch, useSelector } from "react-redux";
import CustomButton from "./CustomButton";
import { useNavigate } from "react-router-dom";

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
  return <CustomButton text={"Cancel"} onClick={handleCancelClick}></CustomButton>;
};

export const SaveButton = () => {
  const navigate = useNavigate();

  const handleSaveClick = () => {
    navigate("/");

  };
  return <CustomButton text={"Save"} onClick={handleSaveClick}></CustomButton>;};

export const MassDeleteButton = () => {
  const dispatch = useDispatch();
  const selectedIds = useSelector((s) => s.myFeature);
  const handleMassDeleteClick = () => {
    const promises = [];
    const { promise } = axios.post(
      "http://localhost:3000/asd/product/delete",
      {
        ids: JSON.stringify(
          selectedIds.map((product) => parseInt(product.sku))
        ),
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    Promise.all([promise]).then(() => {
      for (let i = 0; i < selectedIds.length; i++) {
        const sku = selectedIds[i].sku;
        const promise = dispatch(deleteProduct(parseInt(sku)));
        promises.push(promise);
      }

      Promise.all(promises).then(() => {});
    });
  };
  return (
    <CustomButton
      text={"MASS DELETE"}
      onClick={handleMassDeleteClick}
    ></CustomButton>
  );
};
