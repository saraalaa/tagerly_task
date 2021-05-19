<?php

namespace App\Models;

use App\QueryFilters\Product\MaxPrice;
use App\QueryFilters\Product\MinPrice;
use App\QueryFilters\Product\ProductName;
use App\QueryFilters\Product\VendorName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pipeline\Pipeline;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['selling', 'votes'];
    protected $guarded = [];

    protected static array $searchFilter = [
        ProductName::class,
        VendorName::class,
        MaxPrice::class,
        MinPrice::class,
    ];

    public static function allProducts()
    {
        $products = app(Pipeline::class)
            ->send(Product::query()->with('vendor', 'votes', 'orderDetails'))
            ->through(self::$searchFilter)
            ->thenReturn()
            ->get();

        return self::sortedProducts($products);
    }

    protected static function sortedProducts($products)
    {
        $sortType = \request()->query('sort_by', 'created_at');

        if ($sortType == 'price')
            return $products->sortBy($sortType);
        else
            return $products->sortByDesc($sortType);
    }

    public function getSellingAttribute()
    {
        $selling = 0;
        foreach ($this->orderDetails as $orderDetail)
            $selling += $orderDetail->quantity;
        return $selling;
    }

    public function getVotesAttribute() : float
    {
        return round ($this->votes()->average('vote'),1);
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function votes() : HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function orderDetails() : HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

}
