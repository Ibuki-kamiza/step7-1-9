<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'product_name' => $this->product_name,
            'price'        => $this->price,
            'stock'        => $this->stock,
            'company'      => [
                'id'   => optional($this->company)->id,
                'name' => optional($this->company)->company_name,
            ],
            'image_url'    => $this->img_path ? asset('storage/' . $this->img_path) : null,
            'created_at'   => optional($this->created_at)->toDateTimeString(),
        ];
    }
}
