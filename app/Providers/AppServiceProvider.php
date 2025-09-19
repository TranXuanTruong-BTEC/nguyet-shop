<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register helper functions
        if (!function_exists('getProductImage')) {
            function getProductImage($product, $size = '300x300') {
                if ($product->images && count(json_decode($product->images)) > 0) {
                    $image = json_decode($product->images)[0];
                    return Storage::url($image);
                }
                return "https://via.placeholder.com/{$size}?text=No+Image";
            }
        }
    }
}
