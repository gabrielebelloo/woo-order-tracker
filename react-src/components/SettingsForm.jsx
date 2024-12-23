import React, { useEffect, useState } from 'react';

const SettingsForm = () => {
  const [orderTracking, setOrderTracking] = useState(wooOrderTrackerSettings.order_tracking);
  const [webhookUrl, setWebhookUrl] = useState(wooOrderTrackerSettings.webhook_url);

  useEffect(() => {
    console.log(wooOrderTrackerSettings);
  });

  const handleSubmit = (e) => {
    e.preventDefault();

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
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
  }

  return <div>
    <h2>Woo Order Tracker Settings</h2>

    <form onSubmit={handleSubmit}>
      <label className='order-tracking'>  
        <div>Enable tracking</div>
        <select value={orderTracking} onChange={(e) => setOrderTracking(e.target.value)}>
          <option value='1'>Actived</option>
          <option value='0'>Deactivated</option>
        </select>
      </label>

      <label className='webhook-url'>
        <div>Webhook URL</div>
        <input type="text" value={webhookUrl} placeholder='https://your-webhook-url.com' onChange={(e) => setWebhookUrl(e.target.value)} />
      </label>

      <button type='submit'>Save</button>
    </form>
  </div>
}

export default SettingsForm;