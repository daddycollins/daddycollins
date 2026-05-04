@component('mail::message')
  # Payment Received

  Hello {{ $order->artisan->user->name }},

  Great news! You have received a new payment for an order. A client has just paid for your service.

  @component('mail::panel')
    **Order Details**

    - **Order ID:** {{ $order->id }}
    - **Order Date:** {{ $order->created_at->format('M d, Y h:i A') }}
    - **Payment Date:** {{ $order->updated_at->format('M d, Y h:i A') }}
    - **Status:** {{ ucfirst($order->status) }}
    - **Payment Status:** {{ ucfirst($order->payment_status) }}
    - **Payment Reference:** {{ $order->paynow_reference ?? 'N/A' }}
  @endcomponent

  ## Order Summary

  | Item | Quantity | Price | Total |
  |------|----------|-------|-------|
  @foreach ($order->items as $item)
    | {{ $item->artisanService->name ?? ($item->artisanGood->name ?? 'Item') }} | {{ $item->quantity }} | ZWL
    {{ number_format($item->unit_price, 2) }} | ZWL {{ number_format($item->total_price, 2) }} |
  @endforeach

  @component('mail::panel')
    **Payment Summary**

    - **Subtotal:** ZWL {{ number_format($order->items->sum('total_price'), 2) }}
    - **Service Fee (Platform):** ZWL {{ number_format($order->service_fee, 2) }}
    - **Total Paid:** ZWL {{ number_format($order->total_amount, 2) }}
    - **Your Earnings:** ZWL {{ number_format($order->total_amount - $order->service_fee, 2) }}
  @endcomponent

  **Client:** {{ $order->client->name }}

  **Client Contact:** {{ $order->client->phone ?? 'N/A' }}

  ## Next Steps

  1. ✓ Payment received and confirmed
  2. Begin work on the order at your earliest convenience
  3. Update the order status as you progress
  4. Notify the client when the order is completed
  5. The client will review and rate your work

  [View order details]({{ route('artisan-order-details', $order) }}) | [Update order
  status]({{ route('artisan-order-details', $order) }})

  Thank you for being part of the ArtisanConnect community!

  Best regards,
  **ArtisanConnect Team**
@endcomponent
