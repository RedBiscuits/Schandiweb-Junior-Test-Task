import React from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import App from "./App.jsx";
import { configureStore } from "@reduxjs/toolkit";
import globalReducer from "state";
import { Provider } from "react-redux";
import { setupListeners } from "@reduxjs/toolkit/query";
import reducer from "controllers/SelectedItemsReducer";
import productsReducer from "controllers/ProductsReducer.mjs";

const store = configureStore({
  reducer: {
    global: globalReducer,
    myFeature: reducer,
    products: productsReducer 
  },
});
setupListeners(store.dispatch);

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <React.StrictMode>
    <Provider store={store}>
      <App />
    </Provider>
  </React.StrictMode>
);