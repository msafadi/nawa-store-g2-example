<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index($category_slug = null)
    {
        $category = null;
        if ($category_slug) {
            $category = Category::where('slug', '=', $category_slug)
                ->firstOrFail();
        }
        $products = Product::active()
                ->orderBy('price', 'DESC')
                ->with('category')
                ->when($category?->id, function($builder, $category_id) {
                    $builder->where('category_id', $category_id);
                })
                ->get();
        
        return view('front.products.index', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', '=', $slug)->firstOrFail();
        return view('front.products.show', [
            'product' => $product,
        ]);
    }
}
