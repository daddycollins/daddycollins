@component('mail::message')
  # Payment Confirmation

  Hello {{ $order->client->name }},

  Thank you for your payment! Your order has been confirmed and is being processed.

  @component('mail::panel')
    **Order Details**

    - **Order ID:** {{ $order->id }}
    - **Order Date:** {{ $order->created_at->format('M d, Y h:i A') }}
    - **Status:** {{ ucfirst($order->status) }}
    - **Payment Status:** {{ ucfirst($order->payment_status) }}
    - **Payment Reference:** {{ $order->paynow_reference ?? 'N/A' }}
  @endcomponent

  ## Items Ordered

  | Item | Quantity | Price | Total |
  |------|----------|-------|-------|
  @foreach ($order->items as $item)
    | {{ $item->artisanService->name ?? ($item->artisanGood->name ?? 'Item') }} | {{ $item->quantity }} | ZWL
    {{ number_format($item->unit_price, 2) }} | ZWL {{ number_format($item->total_price, 2) }} |
  @endforeach

  @component('mail::panel')
    **Order Summary**

    - **Subtotal:** ZWL {{ number_format($order->items->sum('total_price'), 2) }}
    - **Service Fee:** ZWL {{ number_format($order->service_fee, 2) }}
    - **Total Amount:** ZWL {{ number_format($order->total_amount, 2) }}
  @endcomponent

  **Artisan:** {{ $order->artisan->user->name }}

  **Artisan Contact:** {{ $order->artisan->user->phone ?? 'N/A' }}

  ## What Happens Next?

  1. Your payment has been received and confirmed
  2. The artisan will review and begin work on your order
  3. You will receive updates on your order status
  4. Once completed, you'll receive a notification to review and rate the service

  You can track your order status anytime by visiting your [order details
  page]({{ route('user-order-details', $order) }}).

  If you have any questions or concerns about this order, please [contact the
  artisan]({{ route('user-contact-artisan', $order) }}).

  Thank you for using ArtisanConnect!

  Best regards,
  **ArtisanConnect Team**
@endcomponent
