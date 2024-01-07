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

// Create a Redux store using configureStore
const store = configureStore({
  // Specify the reducers for various features of the app
  reducer: {
    global: globalReducer,
    myFeature: reducer,
    products: productsReducer,
  },
});

// Set up listeners for the store's dispatch method
setupListeners(store.dispatch);

// Create a root element using ReactDOM
const root = ReactDOM.createRoot(document.getElementById("root"));

// Render the app inside the root element
root.render(
  // Enable strict mode for the app
  <React.StrictMode>
    {/* Provide the Redux store to the app using the Provider component */}
    <Provider store={store}>
      {/* Render the App component */}
      <App />
    </Provider>
  </React.StrictMode>
);