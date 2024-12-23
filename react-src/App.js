import React from 'react';
import SettingsForm from './components/SettingsForm';
import { Toaster } from 'react-hot-toast';

function App() {
  return <>
    <div><Toaster
      position="top-right"
      reverseOrder={false}
      toastOptions={{
        style: {
          marginTop: '25px',
        },
      }}
    /></div>
    <SettingsForm />
  </>;
}

export default App;