<?php

namespace App\Providers;

use App\Helpers\Helpers;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Use View Composer to filter menu when layout view is rendered
    // This ensures Auth middleware has already run
    View::composer('layouts.layoutMaster', function ($view) {
      $menuPath = base_path('resources/menu/verticalMenu.json');

      // Check if menu file exists
      if (!file_exists($menuPath)) {
        \Log::error('Menu file not found: ' . $menuPath);
        $view->with('menuData', []);
        return;
      }

      $verticalMenuJson = file_get_contents($menuPath);
      $verticalMenuData = json_decode($verticalMenuJson);

      // Check if JSON decode was successful
      if ($verticalMenuData === null) {
        \Log::error('Failed to decode verticalMenu.json: ' . json_last_error_msg());
        $view->with('menuData', []);
        return;
      }

      // Filter menu based on user role
      if (Auth::check()) {
        $verticalMenuData->menu = Helpers::filterMenuByRole($verticalMenuData->menu ?? []);
      } else {
        $verticalMenuData->menu = [];
      }

      // Share menuData with the view
      $view->with('menuData', [$verticalMenuData]);
    });
  }
}