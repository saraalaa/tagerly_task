<?php


namespace App\QueryFilters\Product;


class ProductName extends Filter
{
    protected function applySearchFilter($builder)
    {
        return $builder->where('name','like','%'.\request('product_name').'%');
    }
}
