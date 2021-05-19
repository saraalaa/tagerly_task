<?php


namespace App\QueryFilters\Product;


class MaxPrice extends Filter
{
    protected function applySearchFilter($builder)
    {
        return $builder->where('price', '<=', request('max_price'));
    }
}
