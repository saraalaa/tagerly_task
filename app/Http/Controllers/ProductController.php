<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(FilterProductRequest $request) : AnonymousResourceCollection
    {
        $products = Product::allProducts();
        return ProductResource::collection($products);
    }
}
