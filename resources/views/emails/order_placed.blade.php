<h2>Hi {{ $order->name }},</h2>

<p>Thank you for your order!</p>

<p><strong>Order ID:</strong> {{ $order->id }}</p>
<p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
<p><strong>Total:</strong> BDT.{{ $order->total_amount }}</p>

<p>We’ll notify you when your order is on the way.</p>

<p>Regards,<br>Your Company Name</p>
