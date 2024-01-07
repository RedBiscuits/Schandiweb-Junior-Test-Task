import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import './index.css'

// Create a root element using ReactDOM and render the app
ReactDOM.createRoot(document.getElementById('root')).render(
  // Enable strict mode for the app
  <React.StrictMode>
    // Render the App component
    <App />
  </React.StrictMode>,
);