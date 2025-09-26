<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Only expose necessary fields in API response
        return [
            'id' => $this->id,
            'title' => $this->title,
            'img' => $this->img,
            'prev_price' => $this->prev_price ? (float) $this->prev_price : null,
            'new_price' => (float) $this->new_price,
            'rating' => (int) $this->rating,
            'reviews' => $this->reviews,
            'company' => $this->company,
            'brand' => $this->brand,
            'color' => $this->color,
            'category' => $this->category,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
