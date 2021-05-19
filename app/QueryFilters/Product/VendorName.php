<?php


namespace App\QueryFilters\Product;


class VendorName extends Filter
{
    protected function applySearchFilter($builder)
    {
        return $builder->whereHas('vendor', function ($products){
            $products->where('name','like','%'.\request('vendor_name').'%');
        });
    }

}
