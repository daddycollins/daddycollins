@component('mail::message')
  # Payment Cancelled

  Hello {{ $recipientType === 'client' ? $order->client->name : $order->artisan->user->name }},

  The payment for your order has been cancelled.

  @component('mail::panel')
    **Order Details**

    - **Order ID:** {{ $order->id }}
    - **Order Date:** {{ $order->created_at->format('M d, Y h:i A') }}
    - **Total Amount:** ZWL {{ number_format($order->total_amount, 2) }}
    - **Payment Status:** Cancelled
    - **Cancellation Date:** {{ now()->format('M d, Y h:i A') }}
  @endcomponent

  @if ($recipientType === 'client')
    ## What You Can Do

    1. **Try Again:** [Retry Payment]({{ route('user-pay-now', $order) }})
    2. **View Order:** [Return to Order]({{ route('user-order-details', $order) }})
    3. **Contact Support:** If you cancelled this by mistake, contact our support team to assist

    The order remains active and available for payment.
  @else
    ## What Happens Next

    The client has cancelled the payment for this order. The order is currently waiting for a new payment attempt.

    Items remain reserved for this order until payment is completed or the order is cancelled by the client.

    Once the client successfully completes the payment, you will receive a notification.
  @endif

  Best regards,
  **ArtisanConnect Team**
@endcomponent
