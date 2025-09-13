<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f2f2f2; font-family: 'Segoe UI', sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          
          <!-- Header -->
          <tr style="background-color: #2ecc71;">
            <td align="center" style="padding: 25px; color: #ffffff; font-size: 24px; font-weight: 600;">
              ✅ Order Confirmed!
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 35px; color: #333; font-size: 16px; line-height: 1.7;">
              <h2 style="margin-top: 0; font-weight: 600; color:rgb(70, 80, 129);">Hi {{ $order->name }},</h2>

              <p>Thank you for shopping with <strong>Elegance Bd</strong>! We're happy to let you know that your order has been successfully received and is now being processed.</p>

              <h3 style="margin-bottom: 12px; color:rgb(33, 80, 105);">🛍️ Order Details:</h3>
              <table style="width: 100%; font-size: 15px; margin-bottom: 20px;">
                <tr>
                  <td style="padding: 6px 0;"><strong>Order ID:</strong></td>
                  <td>{{ $order->id }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0;"><strong>Transaction ID:</strong></td>
                  <td>{{ $order->transaction_id }}</td>
                </tr>
                <tr>
                  <td style="padding: 6px 0;"><strong>Total Amount:</strong></td>
                  <td><span style="color:rgb(33, 80, 105);">BDT {{ $order->total_amount }}</span></td>
                </tr>
              </table>

              <p>You’ll receive a notification once your order is on the way 🚚.</p>

              <!-- <div style="text-align: center; margin: 30px 0;">
                <a href="#" style="display: inline-block; background-color: #2ecc71; color: #fff; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: bold;">Track Your Order</a>
              </div> -->

              <p>If you have any questions, just reply to this email or contact our support team — we're here to help!</p>

              <p style="margin-top: 35px;">Warm regards,<br><strong>Elegance Bd Team</strong></p>
            </td>
          </tr>

          <!-- Footer -->
          <tr style="background-color: #f9f9f9;">
            <td style="padding: 20px; text-align: center; font-size: 13px; color: #999999;">
              <p>Elegance Bd<br>Uttara, Dhaka, Bangladesh</p>
              <p>Email: elegancebd@gmail.com | Phone: +880 01795-053841</p>
              <p style="margin: 0;">&copy; {{ date('Y') }} Elegance Bd. All rights reserved.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
