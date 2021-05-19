<?php

namespace App\Http\Requests;

use App\Rules\GreaterThanMinPriceRule;
use App\Rules\LessThanMaxPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'product_name' => ['nullable', 'string', 'max:255'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'integer', new LessThanMaxPriceRule()],
            'max_price' => ['nullable', 'integer', new GreaterThanMinPriceRule()],
            'sort_by' => ['nullable', 'string', 'max:255', 'in:price,votes,selling'],
        ];
    }
}
