import React from 'react'
import { useDispatch, useSelector } from 'react-redux';
import Product from "components/ProductList";
import * as reducer from "controllers/SelectedItemsReducer";
import Navbar from 'components/Navbar';
import { MassDeleteButton , AddButton } from 'components/NavButtonsFactory';
import Footer from 'components/Footer';

const Dashboard = () => {
  const dispatch = useDispatch()
  const selectedIds = useSelector(s => s.myFeature) 
  const products = useSelector((state) => state.products);

  const handleCheckboxChange = (productSKU) => {
      const productExists = selectedIds.some(product => product.sku === productSKU);
      if (productExists) {
        dispatch(reducer.removeProduct(productSKU));
      } else {
        dispatch(reducer.addProduct(productSKU));
      }
  }

  return (
    <div>
    <Navbar rightButton={<MassDeleteButton/>} leftButton ={<AddButton/>}  title={"Product List"}/>
    <Product data={products}  onCheckboxChange={handleCheckboxChange}/>
    <Footer/>
    </div>
  )
}

export default Dashboard