const initialState = [];

export default function productsReducer(state = initialState, action) {
  switch (action.type) {
    case "SET_PRODUCTS_DATA":
      return action.payload;
    case "DELETE_PRODUCT":
      return state.filter((product) => product.id !== action.payload);
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

