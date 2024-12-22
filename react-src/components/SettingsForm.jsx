import React, { useEffect, useState } from 'react';

const SettingsForm = () => {
  const [orderTracking, setOrderTracking] = useState(wooOrderTrackerSettings.order_tracking == 1);
  const [webhookUrl, setWebhookUrl] = useState(wooOrderTrackerSettings.webhook_url);

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
    .then(response => console.log(response));
  }

  return <div>
    <h2>Woo Order Tracker Settings</h2>

    <form onSubmit={handleSubmit}>
      <label>
        <input type="checkbox" checked={orderTracking} onChange={(e) => setOrderTracking(e.target.checked ? 1 : 0)}/>
        Enable order tracking
      </label>

      <label>
        Webhook destination URL: 
        <input type="text" value={webhookUrl} placeholder='https://your-webhook-url.com' onChange={(e) => setWebhookUrl(e.target.value)} />
      </label>

      <button type='submit'>Save</button>
    </form>
  </div>
}

export default SettingsForm;