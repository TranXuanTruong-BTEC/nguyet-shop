<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get product image URL
     */
    public static function getProductImage($product, $size = '300x300')
    {
        if ($product->images && count(json_decode($product->images)) > 0) {
            $image = json_decode($product->images)[0];
            return Storage::url($image);
        }
        return "https://via.placeholder.com/{$size}?text=No+Image";
    }

    /**
     * Get category image URL
     */
    public static function getCategoryImage($category, $size = '500x300')
    {
        if ($category->image) {
            return Storage::url($category->image);
        }
        return "https://via.placeholder.com/{$size}?text=No+Image";
    }

    /**
     * Get first product image
     */
    public static function getFirstProductImage($product, $size = '300x300')
    {
        if ($product->images && count(json_decode($product->images)) > 0) {
            $images = json_decode($product->images);
            return Storage::url($images[0]);
        }
        return "https://via.placeholder.com/{$size}?text=No+Image";
    }

    /**
     * Get all product images
     */
    public static function getAllProductImages($product)
    {
        if ($product->images && count(json_decode($product->images)) > 0) {
            $images = json_decode($product->images);
            return array_map(function($image) {
                return Storage::url($image);
            }, $images);
        }
        return [];
    }
}
