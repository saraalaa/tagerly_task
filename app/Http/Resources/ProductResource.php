<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'productName' => $this->name,
            'vendorName' => $this->vendor->name,
            'price' => $this->price,
            'totalSelling' => $this->selling,
            'votes' => $this->votes,
            'createdAt' => $this->created_at ? $this->created_at->toDateTimeString() : null,
        ];
    }
}
