@component('mail::message')
  # Payment Failed

  Hello {{ $recipientType === 'client' ? $order->client->name : $order->artisan->user->name }},

  Unfortunately, the payment for your order could not be processed.

  @component('mail::panel')
    **Order Details**

    - **Order ID:** {{ $order->id }}
    - **Order Date:** {{ $order->created_at->format('M d, Y h:i A') }}
    - **Total Amount:** ZWL {{ number_format($order->total_amount, 2) }}
    - **Payment Status:** Failed
    - **Reason:** {{ $reason }}
  @endcomponent

  @if ($recipientType === 'client')
    ## What You Can Do

    1. **Try Again:** [Retry Payment]({{ route('user-pay-now', $order) }})
    2. **Contact Support:** If you continue to experience issues, please contact our support team
    3. **Check Your Account:** Verify that your mobile money account has sufficient balance
    4. **Check Order Status:** View your [order details]({{ route('user-order-details', $order) }}) for more information

    The order remains active and you can attempt payment again at any time.
  @else
    ## What Happens Next

    The client has been notified of the payment failure. The order is currently on hold and waiting for successful
    payment. Items will remain available for this order.

    Once the client successfully completes the payment, you will receive a notification.
  @endif

  If you need assistance, please contact our support team.

  Best regards,
  **ArtisanConnect Team**
@endcomponent
