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
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      $verticalMenuData = json_decode($verticalMenuJson);

      // Filter menu based on user role
      if (Auth::check()) {
        $verticalMenuData->menu = Helpers::filterMenuByRole($verticalMenuData->menu);
      } else {
        $verticalMenuData->menu = [];
      }

      // Share menuData with the view
      $view->with('menuData', [$verticalMenuData]);
    });
  }
}