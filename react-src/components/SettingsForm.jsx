import React, { useState } from 'react';
import { toast, Toaster } from 'react-hot-toast';

const SettingsForm = () => {
  const [orderTracking, setOrderTracking] = useState(wooOrderTrackerSettings.order_tracking);
  const [webhookUrl, setWebhookUrl] = useState(wooOrderTrackerSettings.webhook_url);
  const [loading, setLoading] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();

    setLoading(true);

    const formData = new URLSearchParams();
    formData.append('action', 'save_settings');
    formData.append('nonce', wooOrderTrackerSettings.nonce);
    formData.append('order_tracking', orderTracking);
    formData.append('webhook_url', webhookUrl);

    fetch(wooOrderTrackerSettings.ajaxurl, {
      method: 'POST',
      body: formData,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      }
    })
    .then(response => {response.json(); setLoading(false); toast.success("Settings saved successfully")}) 
    .then(data => console.log(data))
    .catch(error => {console.error('Error:', error); setLoading(false); toast.error("Error saving settings")});
  }

  return <div>
    <h2>Woo Order Tracker Settings</h2>

    <form onSubmit={handleSubmit} disabled={loading}>
      <label className='order-tracking'>  
        <div>Enable tracking</div>
        <select value={orderTracking} onChange={(e) => setOrderTracking(e.target.value)} disabled={loading}>
          <option value='1'>Actived</option>
          <option value='0'>Deactivated</option>
        </select>
      </label>

      <label className='webhook-url'>
        <div>Webhook URL</div>
        <input type="text" value={webhookUrl} placeholder='https://your-webhook-url.com' onChange={(e) => setWebhookUrl(e.target.value)} disabled={loading}/>
      </label>

      <button 
          type='submit' 
          disabled={loading}
          style={{ opacity: loading ? 0.5 : 1 }}
        >
          {loading ? 'Saving...' : 'Save'}
        </button>
    </form> 
  </div>
}

export default SettingsForm;