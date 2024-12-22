import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

const rootNode = document.getElementById('root');
if (rootNode) {
  const root = ReactDOM.createRoot(rootNode);
  root.render(<App />);
}