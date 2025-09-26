<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductResource;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public static $wrap = null; //remove "data" key
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'status'  => 200,
            'message' => 'Products retrieved successfully',
            'rows'    => ProductResource::collection($this->collection),
            'total'   => $this->collection->count(),
        ];
    }
}
