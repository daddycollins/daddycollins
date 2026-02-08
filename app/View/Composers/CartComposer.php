<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Services\CartService;

class CartComposer
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Bind cart count to the view.
     */
    public function compose(View $view)
    {
        // Only calculate cart count for authenticated client users
        if (auth()->check() && auth()->user()->role === 'client') {
            $cartCount = $this->cartService->getCartItemCount();
            $view->with('cartCount', $cartCount);
        } else {
            $view->with('cartCount', 0);
        }
    }
}
