<?php

namespace App\QueryFilters\Product;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next)
    {
        if ( ! \request()->has($this->filterName()))
            return $next($request);

        $builder = $next($request);

        return $this->applySearchFilter($builder);
    }

    protected function filterName() : string
    {
        return Str::snake(class_basename($this));
    }

    protected abstract function applySearchFilter($builder);

}
