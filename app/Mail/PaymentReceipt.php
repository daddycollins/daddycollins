<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceipt extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(
    public Order $order,
    public string $recipientType = 'client' // 'client' or 'artisan'
  ) {
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    $subject = $this->recipientType === 'client'
      ? "Payment Confirmation - Order #{$this->order->id}"
      : "Payment Received - Order #{$this->order->id}";

    return new Envelope(
      subject: $subject,
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: $this->recipientType === 'client'
      ? 'emails.payment-receipt-client'
      : 'emails.payment-receipt-artisan',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return [];
  }
}
