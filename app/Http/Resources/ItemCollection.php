<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit_measurement' => $this->unit_measurement,
            'description' => $this->description,
            'img' => $this->img,
            'product_code' => $this->product_code,
            'inventory' => new InventoryCollection($this->inventories),
        ];
    }
}
