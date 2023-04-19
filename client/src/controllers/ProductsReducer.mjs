const initialState = [];

export default function productsReducer(state = initialState, action) {
  switch (action.type) {
    case "SET_PRODUCTS_DATA":
      return action.payload;
    case "DELETE_PRODUCT":
      return state.filter((product) => product.sku !== action.payload);
    case "ADD_PRODUCT":
      return [...state, action.payload];
    default:
      return state;
  }
}

export const setProductsData = (data) => ({
  type: "SET_PRODUCTS_DATA",
  payload: data,
});

export const deleteProduct = (productId) => ({
  type: "DELETE_PRODUCT",
  payload: productId,
});

export const addProductReducer = (productData) => ({
  type: "ADD_PRODUCT",
  payload: productData,
});
