<?php


namespace App\QueryFilters\Product;


class MinPrice extends Filter
{
    protected function applySearchFilter($builder)
    {
        return $builder->where('price', '>=', request('min_price'));
    }

}
