<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $orders = Order::with(['client', 'artisan'])->limit(15)->get();

    if ($orders->isEmpty()) {
      return;
    }

    $comments = [
      'Excellent work! The service was completed on time and with great attention to detail.',
      'Very professional and courteous. Would definitely hire again for future projects.',
      'Great quality of work. Minor issues but overall very satisfied with the service.',
      'Good work but took longer than expected. Quality is acceptable.',
      'Service was not up to standard. Communication could have been better.',
      'Outstanding craftsmanship! Highly recommend to everyone.',
      'Decent work but could improve on punctuality and customer communication.',
      'Perfect! Exactly what I was looking for. Excellent attention to detail.',
      'Good service but a bit pricey. Quality is decent.',
      'Reliable and professional. Will definitely work with them again.',
      'Amazing! Went above and beyond expectations. Truly impressed.',
      'Average work. Nothing special but got the job done.',
      'Fantastic experience from start to finish. Highly satisfied!',
      'Could be better. Some issues with the final output but mostly acceptable.',
      'Exceptional service! Great communication and brilliant results.',
    ];

    // Create reviews for each order
    foreach ($orders as $key => $order) {
      $rating = rand(1, 5);

      Review::create([
        'order_id' => $order->id,
        'artisan_id' => $order->artisan_id,
        'client_id' => $order->client_id,
        'rating' => $rating,
        'comment' => $comments[$key % count($comments)],
        'created_at' => $order->created_at->addDays(rand(1, 5)),
        'updated_at' => $order->created_at->addDays(rand(1, 5)),
      ]);
    }
  }
}
